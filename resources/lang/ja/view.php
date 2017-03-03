<?php

return [
    //ログインフォーム関係
    'not_loggedin' => 'ログインしていません',
    'update' => '更新', 
    
    //タイトル
    'title' => [
        'home' => 'ホーム',
        'about' => 'kb10uy S3とは',
        'profile' => 'プロフィール', 
        'setting' => '設定',
        'login' => 'ログイン',
        'register_user' => 'ユーザー登録',
        'post' => '投稿する',
    ],
    
    //aboutページ
    'about' => [
        'title' => 'ShortStoryServer とは?'
    ],
    //認証関係
    'auth' => [
        //含 register要素
        'register_intro' => 'ユーザー登録をすると、SSの投稿やブックマーク、通知などを利用できます！早速登録しましょう。',
        'register_account' => 'ShortStoryServerアカウントを作成する',
        
        'login_sss' => 'ShortStoryServerにログインする',
        'sss_account' => 'ShortStoryServerアカウント',
        'other_account' => '他のサービスのアカウント',
        'username' => 'ユーザー名',
        'username_p' => '使用したいユーザー名',
        'password' => 'パスワード',
        'password_p' => '使用するパスワード',
        'password_confirm' => 'パスワードの再入力',
        'email' => 'メールアドレス',
        'register' => '登録',
        'login' => 'ログイン',
        'logout' => 'ログアウト',
        'remember' => 'ログインしたままにする', 
        'forgot' => 'パスワードを忘れた方はこちら', 
        'reset_password' => 'パスワードのリセット',
        'send_reset_link' => 'パスワードリセットのリンクを送信',
        'enter_new_password' => '新しいパスワードの入力',
        'accept_password' => 'パスワードを更新',
        'other_account_info' => 'ShortStoryServerにTwitterアカウントなどを利用してログインできます。一度ログインすればSSSアカウントと外部アカウント両方でログインできます。',
        
        'login_with_twitter' => 'Twitterアカウントでログイン',
        'login_with_github' => 'GitHubアカウントでログイン',
    ],
    
    'user' => [
        'basic_setting' => '基本設定', 
        'icon' => 'アイコン',
        'misc' => 'その他',
        'password_update' => 'パスワードの更新',
        'basic_info' => '基本情報',
        'additional_info' => '追加情報',
        'social' => '連携',
        'profile' => 'プロフィール',
        'description' => '自己紹介',
        'description_p' => '自己紹介的な文章を入力してください。(200文字以内)',
        'no-description' => '(自己紹介はありません)',
        'cur_password' => '現在のパスワード',
        'new_password' => '新しいパスワード',
        'new_password_confirm' => '新しいパスワードの再入力',
        'url' => 'URL',
        'url_p' => '自分のWebサイトなどのURL',
        'display_name' => '名前',
        'display_name_p' => '作者名として表示されます(任意文字表示可能)。空にするとユーザー名',
        'birthday' => '誕生日',
        'icon_req_1' => '対応形式: PNG, JPEG, GIF',
        'icon_req_2' => '最大サイズ: 1024x1024, 512KB',
        'icon_req_3' => '内部で320x320 JPEGに縮小・変換されます',
        'icon_select' => 'ファイルを選択',
        'twitter' => 'Twitter',
        'github' => 'GitHub',
        'unset' => '未設定',
        'set' => '設定・更新',
        'unlink' => '解除',
    ],
    
    'message' => [
        'username_required' => 'ユーザー名は入力してください。',
        'email_required' => 'メールアドレスは入力してください。',
        'password_required' => 'パスワードを入力してください。',
        'new_password_required' => '新しいパスワードを入力してください。',
        'password_nomatch' => 'パスワードが一致しません。',
        'basic_info_updated' => '基本情報が更新されました。',
        'password_updated' => '基本情報が更新されました。',
        'misc_info_updated' => 'サブ情報が更新されました。',
        'user_not_exist' => 'そのユーザーは存在しません。',
        'post_not_exist' => 'このIDの投稿は存在しないか削除された可能性があります。',
        'post_invisible' => 'この投稿は現在非公開になっています。',
        'not_admin' => 'あなたに管理者権限がありません。',
    ],
];