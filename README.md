# api-news
test task

### Локальный деплой
1. создать папку проекта и залить репозиторий https://github.com/plankconstanta/symfony_docker 
2. в папке, где docker-compose.yml, запускаем docker-compose -f docker-compose.yml up --build -d
3. перейти в папку app, залить репозиторий https://github.com/plankconstanta/api-news
4. заходим в контейнер где лежит symfony docker exec -it php bash 
4.1 cp .env.lock .env
4.2 composer install
4.3 bin/console doctrine:migrations:migrate
4.4 bin/console cache:clear
5. api
- http://localhost:8080/api/news
- http://localhost:8080/api/news?page=1&year=2021&month=12&tag=спорт
6. db
- http://localhost:9080/
