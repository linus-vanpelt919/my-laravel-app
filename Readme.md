練習用カレンダーアプリ
laravel8



#環境立ち上げ

#docker起動
docker-compose up or make up(MakeFile記載以下同)

#docker コンテナの状態確認
docker-compose ps or make ps

#docker削除
docker-compose down or make down

#Laravelのソースがあるappコンテナ配下に入ってコマンドを入力

docker exec -it my-laravel-app_app_1 bash or app-laravel

#mysqlへ接続

docker exec -it my-laravel-app_mysql_1 bash or db-laravel


exitで接続を切る

laravel起動
cd app 
npm run dev
npm run watch　で監視

http://localhost:8000/
にアクセス
