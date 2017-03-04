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
        $lines = preg_split("/\R/", $text);
        $state = [];
        $state['type'] = [];
        $result = [];

        foreach($lines as $line) {
            if($state['noparse'] ?? false) {
                $result[] = $line;
                continue;
            }
            //タイトル
            if (strpos($line, '###') === 0) {
                $result[] = '<h5>' . trim(substr($line, 3)) . '</h5>';
                continue;
            } elseif (strpos($line, '##') === 0) {
                $result[] = '<h4>' . trim(substr($line, 2)) . '</h4>';
                continue;
            } elseif (strpos($line, '#') === 0) {
                $result[] = '<h3>' . trim(substr($line, 1)) . '</h3>';
                continue;
            }

            //ブロック要素
            if (preg_match('/^&gt;-{4,}/', $line) === 1) {
                if ($state['blockquote'] ?? false) {
                    $result[] = '</blockquote>';
                    $state['blockquote'] = false;
                } else {
                    $result[] = '<blockquote>';
                    $state['blockquote'] = true;
                }
                continue;
            } elseif (preg_match('/^!{4,}/', $line) === 1) {
                if ($state['noparse'] ?? false) {
                    $state['noparse'] = false;
                } else {
                    $state['noparse'] = true;
                }
                continue;
            }

            //スクリプト的要素
            if (preg_match('/^@(\w+)=(#[0-9a-fA-F]{1,6})(,(.+))?/', $line, $match) === 1) {
                $state['type'][$match[1]] = [$match[2], $match[4] ?: ''];
                continue;
            } elseif (preg_match('/@(\w+)&gt;(.+)$/', $line, $match) === 1) {
                $result[] = '<span style="color: ' . $state['type'][$match[1]][0] . ';">' . $state['type'][$match[1]][1] . $match[2] . '</span><br>';
                continue;
            }

            //インライン要素
            $line = preg_replace(
                '/\*\*(.+)\*\*/', 
                '<span class="text-bold">$1</span>',
                $line, -1);
            $line = preg_replace(
                '/\/\/(.+)\/\//', 
                '<span class="text-italic">$1</span>',
                $line, -1);
            $line = preg_replace(
                '/__(.+)__/', 
                '<span class="text-underline">$1</span>',
                $line, -1);
            $line = preg_replace(
                '/--(.+)--/', 
                '<span class="text-strike">$1</span>',
                $line, -1);
            $line = preg_replace(
                '/ ;;$/', 
                '<br>',
                $line, -1);
            $line = preg_replace(
                '/^-{8,}$/', 
                '<hr>',
                $line, -1);

            $line = preg_replace(
                '/\[(.+)\]\((.+)\)/', 
                '<a href="$2">$1</a>',
                $line, -1);
            
            $line = preg_replace_callback(
                '/&lt;@(.+)&gt;\((.+)\)/', 
                function($m) {
                    return    '<span style="color: ' . $state['type'][$m[1]][0] . '">' 
                            . $state['type'][$m[1]][1] . $m[2] 
                            . '</span>';
                },
                $line, -1);

            $result[] = $line;
        }
        return implode("\n", $result); 
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