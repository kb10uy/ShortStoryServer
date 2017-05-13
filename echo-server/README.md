# YALES - Yet Another Laravel Echo Server 
このファイルの1行目書いてる時に適当に名前考えました。

## 概要
[laravel-echo-server](https://github.com/tlaverdure/laravel-echo-server)からHTTP API鯖を削ったり
ちょっと書き方を改善したりしてコンパクトに纏めたものです。  
Redisを使う分には互換性は確保されているはずです。

## 使い方
まだnpm scriptsとかを用意してないので

```
cd echo-server
tsc
node dist/server.js
```

という感じで手動でコンパイルする必要があります。  
ついでに言うとデーモン用スクリプトも用意してないですね。すみません。

## ライセンス
MIT Licenseとします。