Rodar o seguintes comandos 
cd ns 
 cp .env.example  .env
docker-compose up -d
docker-compose exec setupNSF-php php artisan migrate --seed
