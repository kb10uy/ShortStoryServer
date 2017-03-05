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
* Pusher
 - WebSocketによるプッシュ通知に使用。
* Supervisor
 - キューワーカーを見守るために使用。

## 運用のマニュアル
* 上記のインストール、もしくは登録・APIキーの取得を済ませてください。
  あとTwitterのキーとGitHubのキーも必要です。
* 以下のように.envを適宜編集してください。
* Supervisorにワーカーのコンフィグを登録してください。

> APP_ENV=local
> APP_KEY=<新しく生成して>
> APP_DEBUG=false
> APP_LOG_LEVEL=info
> 
> APP_URL=<運用URL>
> SESSION_DOMAIN=<運用URLのドメイン>
> 
> DB_CONNECTION=sqlite
> DB_DATABASE=<SQLiteデータベースファイルへのパス>
> BROADCAST_DRIVER=pusher
> CACHE_DRIVER=redis
> SESSION_DRIVER=redis
> QUEUE_DRIVER=redis
> SCOUT_DRIVER=mecab
> REDIS_SOCKET=<Redisのソケットへのパス>
> REDIS_PASSWORD=<Redisのパスワード>
> 
> MAIL_DRIVER=sparkpost
> SPARKPOST_SECRET=<SparkPostのAPI Key>
> 
> PUSHER_APP_ID=<PusherのApp Id>
> PUSHER_APP_KEY=<PusherのApp Key>
> PUSHER_APP_SECRET=<PusherのApp Secret>
> TWITTER_CK=<TwitterのConsumer Key>
> TWITTER_CS=<TwitterのConsumer Secret>
> GITHUB_CK=<GitHubのConsumer Key>
> GITHUB_CS=<GitHubのConsumer Secret>


##ライセンス
The MIT Licenseです。以上