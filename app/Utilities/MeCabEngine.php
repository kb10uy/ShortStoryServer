<?php

namespace App\Utilities;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;
use Illuminate\Database\Eloquent\Collection;
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
                $words = $this->getValidWords($elem);
                $allwords = $allwords->union($words);
            }
            $allwords = $allwords->unique()->values()->toArray();

            $this->deleteData($model->id);
            $this->applyData($model->id, $allwords);
        }
    }

    public function delete($models)
    {
        foreach($models as $model) $this->deleteData($model->id);
    }

    public function search(Builder $builder)
    {
        return $this->performSearch(['query' => $builder->query]);    
    }

    public function paginate(Builder $builder, $perPage, $page)
    {
        return $this->performSearch([
            'query' => $builder->query,
            'page' => $page,
            'perPage' => $perPage,
        ]);
    }

    public function map($results, $model)
    {
        if ($results['count'] === 0) return Collection::make();

        $models = $model->whereIn(
            $model->getQualifiedKeyName(), $results['matches']
        )->get()->keyBy($model->getKeyName());

        return Collection::make($results['matches'])->map(function ($hitId) use ($model, $models) {
            $key = $hitId;
            if (isset($models[$key])) {
                return $models[$key];
            }
        })->filter();
    }   

    public function mapIds($results)
    {
        return $results['matches'];
    }

    public function getTotalCount($results)
    {
        return $results['count'];
    }

    // protected ---------------------------------------
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

    protected function getValidWords($elem)
    {
        $words = collect([]);
        if (is_string($elem)) {
            $words = 
                collect($this->mecab->analysis(preg_replace('/\R/u', '', Text::parseToPlain('plain', $elem), -1)))
                ->filter(function ($value, $key) {
                    return 
                        ($value->getSpeech() === '名詞')
                        && (array_search($value->getSpeechInfo()[0], $this->nounTypesToIgnore) === FALSE);
                })
                ->map(function($value, $key) {
                    return $value->getText();
                });
        } elseif (is_array($elem)) {
            $words = collect([]);
            foreach($elem as $child) $words = $words->union($this->getValidWords($child));
        }
        //dd($words);
        return $words->unique()->values();
    }

    protected function performSearch(array $options)
    {
        $schfor = preg_split('/[\s　]/u', $options['query'], -1, PREG_SPLIT_NO_EMPTY);
        $searches = $this->getValidWords($schfor)
            ->map(function($item, $key) {
                return config('database.keys.post-index-prefix') . $item;
            })
            ->toArray();
        $matches = collect(Redis::sinter(implode(" ", $searches)))
            ->map(function ($item, $key){
                return (int)$item; 
            })
            ->sort(function($a, $b) {
                return $a - $b;
            });
        $result['count'] = count($matches);
        
        if (isset($options['page'])) {
            $matches = $matches->forPage($options['page'], $options['perPage']);
        }
        $result['matches'] = $matches;
        return $result;
    }
}