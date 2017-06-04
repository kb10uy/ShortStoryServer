<?php

namespace App\Utilities\Parsers;

use App\Utilities\Parsers\Parser;

class S3wfParser extends Parser
{
    public function __construct()
    {
    }

    //htmlspecialcharsを通した文字列が渡されます
    public function parse(string $text)
    {
        $lines = preg_split('/\R/u', $text, -1);
        $state = [];
        $state['type'] = [];
        $result = [];
        $anchors = [];
        
        foreach($lines as $line) {
            if($state['noparse'] ?? false) {
                $result[] = $line;
                continue;
            }
            //タイトル
            if (preg_match('/^(#+)\s*(.+)\s*$/', $line, $matches)) {
                $level = strlen($matches[1]) + 2;
                $title = $matches[2];
                $anchor = hash('crc32', $title);
                $result[] = "<h$level>$title</h$level><a name=\"$anchor\"></a>";
                $anchors[] = [$title, $anchor];
                continue;
            }

            //ブロック要素
            if (preg_match('/^&gt;-{4,}/u', $line) === 1) {
                if ($state['blockquote'] ?? false) {
                    $result[] = '</blockquote>';
                    $state['blockquote'] = false;
                } else {
                    $result[] = '<blockquote>';
                    $state['blockquote'] = true;
                }
                continue;
            } elseif (preg_match('/^!{4,}/u', $line) === 1) {
                if ($state['noparse'] ?? false) {
                    $state['noparse'] = false;
                } else {
                    $state['noparse'] = true;
                }
                continue;
            }

            //スクリプト的要素
            if (preg_match('/^@(\w+)=(#[0-9a-fA-F]{1,6})(,(.+))?/u', $line, $match) === 1) {
                $state['type'][$match[1]] = [$match[2], $match[4] ?: ''];
                continue;
            } elseif (preg_match('/^@(\w+)&gt;(.+)$/u', $line, $match) === 1) {
                $result[] = '<span style="color: ' . $state['type'][$match[1]][0] . ';" class="text-line-block">' . $state['type'][$match[1]][1] . $match[2] . '</span>';
                continue;
            }

            //インライン要素
            $line = preg_replace(
                '/\*\*(.+)\*\*/u', 
                '<span class="text-bold">$1</span>',
                $line, -1);
            $line = preg_replace(
                '/\/\/(.+)\/\//u', 
                '<span class="text-italic">$1</span>',
                $line, -1);
            $line = preg_replace(
                '/__(.+)__/u', 
                '<span class="text-underline">$1</span>',
                $line, -1);
            $line = preg_replace(
                '/--(.+)--/u', 
                '<span class="text-strike">$1</span>',
                $line, -1);
            $line = preg_replace(
                '/ ;;$/u', 
                '<br>',
                $line, -1);
            $line = preg_replace(
                '/^-{8,}$/u', 
                '<hr>',
                $line, -1);

            $line = preg_replace(
                '/\[(.+)\]\((http.+)\)/u', 
                '<a href="$2">$1</a>',
                $line, -1);
            
            $line = preg_replace_callback(
                '/&lt;@(.+)&gt;\((.+)\)/u', 
                function($m) use($state) {
                    return    '<span style="color: ' . $state['type'][$m[1]][0] . '" class="text-line-inline">' 
                            /*. $state['type'][$m[1]][1]*/ . $m[2] 
                            . '</span>';
                },
                $line, -1);

            $result[] = $line;
        }
        return ['text' => implode("\n", $result), 'anchors' => $anchors]; 
    }

    public function parseToPlain(string $text)
    {
        return strip_tags(($this->parse($text))['text']);
    }
}

/*
S3wf 暫定フォーマット

# h2
## h3
### h4

**太字**
//斜体//
__下線__
--取り消し--

この右のが強制改行 ;;
この下のが水平線(8コ以上)
---------------

>----
ここの間はblockquote(ハイフンは4以上)
>----

!!!!!
ここの間完全ノーパース(エクラは4回以上)
!!!!!
!<ここの間も完全ノーパース>!  <実装未定>

[リンクテキスト](リンク先uri)
[!! 画像番号] ←block的挿入を予定  <実装未定>

@cocoa=#ffffff,名前
(名前は未指定なら挿入なし)
<@cocoa>(言わせたいセリフ(インライン))
@cocoa> 言わせたいセリフ(行)
*/