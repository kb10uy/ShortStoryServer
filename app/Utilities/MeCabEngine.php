<?php

namespace App\Utilities;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;
use meCab\meCab;
use Text;
use Redis;

class MeCabEngine extends Engine
{
    protected $mecab;

    protected $nounTypesToIgnore = [
        'ナイ形容詞語幹', '引用文字列', '形容動詞語幹',
        '数', '接続詞的', '接尾', '代名詞', '動詞非自立的',
        '特殊', '非自立', '副詞可能',
    ];

    public function __construct() 
    {
        $this->mecab = new meCab;
    }

    public function update($models)
    {
        foreach($models as $model) {
            $allwords = collect([]);
            $parse = $model->type;
            foreach($model->toSearchableArray() as $elem) {
                $words = collect([]);
                if (is_string($elem)) {
                    $words = 
                        collect($this->mecab->analysis(preg_replace('/\R/u', '', Text::parseToPlain($model->type ?? 'plain', $elem), -1)))
                        ->filter(function ($value, $key) {
                            return 
                                ($value->getSpeech() === '名詞')
                                && (array_search($value->getSpeechInfo()[0], $this->nounTypesToIgnore) === FALSE);
                        })
                        ->map(function($value, $key) {
                            return $value->getText();
                        });
                } elseif (is_array($elem)) {
                    $words = collect($elem);
                }
                $allwords = $allwords->union($words);
            }
            $allwords = $allwords->unique()->values()->toArray();

            $this->deleteData($model->id);
            $this->applyData($model->id, $allwords);
        }
    }

    //重複無きこと
    protected function applyData(int $id, array $words)
    {
        Redis::pipeline(function($pipe) use ($id, $words) {
            foreach($words as $word) $pipe->sadd(config('database.keys.post-index-prefix') . $word, $id);
        });
        Redis::hset(config('database.keys.post-index-table'), $id, implode(' ', $words));
    }

    protected function deleteData(int $id)
    {
        
        $list = Redis::hget(config('database.keys.post-index-table'), $id) ?? '';
        $list = preg_split('/ /u', $list, -1, PREG_SPLIT_NO_EMPTY);
        Redis::pipeline(function($pipe) use ($id, $list) {
            foreach($list as $word) $pipe->srem(config('database.keys.post-index-prefix') . $word, $id);
        });
        Redis::hset(config('database.keys.post-index-table'), $id, '');
    }

    public function delete($models)
    {
        foreach($models as $model) $this->deleteData($model->id);
    }

    public function search(Builder $builder)
    {

    }

    public function paginate(Builder $builder, $perPage, $page)
    {

    }

    public function map($results, $model)
    {
        
    }

    public function mapIds($results)
    {
        return collect($results['hits'])->pluck('objectID')->values();
    }

    public function getTotalCount($results)
    {
        return $results['nbHits'];
    }
}