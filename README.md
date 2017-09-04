# ShortStoryServer
SSを投稿するようなアレ

## 仕様
* Laravel 5.5
* ZURB Foundation 6.4
* Vue 2

## 外部利用
* Redis
  - キャッシュとセッションとキューとインデックスに使用。
* SparkPost
  - メール通知に使用。
* Supervisor
  - キューワーカーを見守るために使用。
* MeCab
  - 全文検索インデックスの形態素解析に利用。
  - mecab-ipadic-neologdの使用が推奨されますがRaspiでは性能的にビルドできないという
    問題点があります。

## 運用のマニュアル
* 上記のインストール、もしくは登録・APIキーの取得を済ませてください。
  あとTwitterのキーとGitHubのキーも必要です。
* misc/ 内にSupervisor用のコンフィグと.envのサンプルがあるので自分の環境に合わせて編集して配置してください。
* ShortStoryServer自体のAPIキーの生成をartisanから行っておいてください。
  - これをしないといいね！機能などが使えません
* npm(yarn)でアセットコンパイルをしてください。
* Web鯖の設定は自分でなんとかしてください。

##ライセンス
The MIT Licenseです。以上
