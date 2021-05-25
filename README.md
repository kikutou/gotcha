- download all files first
- cd project directory and [composer install]
- プロジェクト用のDBを手動で構築する。
- .env.exampleを.envに変更して、対応するDB設定のところを自分のDB情報に変更する。
- php artisan migrateコマンドでテーブルを構築する。
- php artisan storage:link コマンドで、画像ファイルのルートを公開する。
- php artisan serve でテスト用のサーバーを起動する。(これはローカルで構築するときだけ必要です。)


マイグレーションが実行されると、以下のアカウントは自動的にDBに挿入される。
初期アカウント:
mail: admin@admin.com
password: admin


AWSのEC2にガチャをデプロイ手順整理：
1. AWSのEC2インスタンスを用意する。以下のURLを参照して、LAMP環境を構築する。
https://docs.aws.amazon.com/ja_jp/AWSEC2/latest/UserGuide/ec2-lamp-amazon-linux-2.html
2. 上記のドキュメントでインストールされたPHPバージョンは7.2なので、最低限7.4までアップグレードする必要があります。
https://qiita.com/nagahama/items/2fdc820791bee5d564ca
3. PHPのアップロードファイルのサイズ制限を解除する必要があります。
https://www.rumahtulip.nl/blog/index.php/apache/how-to-increase-upload-file-size-limit-on-php-apache
https://www.zbame.me/archives/36
