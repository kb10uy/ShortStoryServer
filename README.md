# ShortStoryServer
SSを投稿するようなアレ

## 仕様
* Laravel 5.4
* ZURB Foundation 6

## 外部利用
* Redis
 - キャッシュとセッションとキューとインデックスに使用。
* SparkPost
 - メール通知に使用。
* Supervisor
 - キューワーカーを見守るために使用。
* MeCab
 - 全文検索インデックスの形態素解析に利用。

## 運用のマニュアル
* 上記のインストール、もしくは登録・APIキーの取得を済ませてください。
  あとTwitterのキーとGitHubのキーも必要です。
* 以下のように.envを適宜編集してください。
* Supervisorにワーカーのコンフィグを登録してください。
* ShortStoryServer自体のAPIキーの生成をartisanから行っておいてください。

##ライセンス
The MIT Licenseです。以上
