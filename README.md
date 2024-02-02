## udemy Laravel講座

## ダウンロード方法
git cloneを使う場合
git clone https://github.com/bigstone1990/uMarche.git

git cloneを使ってブランチを指定してダウンロードする場合
git clone -b ブランチ名 https://github.com/bigstone1990/uMarche.git

もしくはzipファイルでダウンロードしてください。

## インストール方法
- cd uMarche
- sail composer install
- sail npm install
- sail up
- sail npm run dev

.env.exampleをコピーして.envファイルを作成

.envファイルの中の下記をご利用環境に合わせて変更してください。

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=umarche
DB_USERNAME=sail
DB_PASSWORD=password

XAMP/MAMPまたは他の開発環境でDBを起動した後に

sail artisan migrate:refresh --seed

と実行してください。
（データベーステーブルとダミーデータが追加されればOK）

最後に
sail artisan key:generate
と入力してキーを生成後、

php artisan serve
で簡易サーバーを立ち上げ、表示確認してください。

## インストール後の実施事項

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg ~ sample6.jpg として
保存しています。

sail artisan storage:link で
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に
保存すると表示されます。
（productsフォルダがない場合は作成してください。）

ショップの画像を表示する場合は、
storage/app/public/shopsフォルダを作成し、
画像を保存してください。

## section7の補足

決済のテストとしてstripeを利用しています。
必要な場合は .env にstripeの情報を追記してください。

## section8の補足

メールのテストとしてmailtrapを利用しています。
必要な場合は .env にmailtrapの情報を追記してください。
(講座内で解説しています。)

メール処理には時間がかかるので、
キューを使用しています。

必要な場合は sail artisan queue:workで
ワーカーを立ち上げて動作確認するようにしてください。