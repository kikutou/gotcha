- download all files first
- cd project directory and [composer install]
- プロジェクト用のDBを手動で構築する。
- .env.exampleを.envに変更して、対応するDB設定のところを自分のDB情報に変更する。
- php artisan migrateコマンドでテーブルを構築する。
- php artisan storage:link コマンドで、画像ファイルのルートを公開する。
- php artisan serve でテスト用のサーバーを起動する。

