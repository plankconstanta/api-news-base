# api-news
test task

### Локальный деплой
Структура проекта  
|  
|--app  
|--docker-compose.yml  
|--logs  
|--mysql  
|--nginx  
|--php  
|--README.md

1. создать папку проекта и залить репозиторий для докера  
`git clone https://github.com/plankconstanta/symfony_docker .` 
2. создаем контейнеры для проекта  
`docker-compose -f docker-compose.yml up --build -d`
3. перейти в папку app, залить репозиторий проекта symfony   
`git clone https://github.com/plankconstanta/api-news .`
4. заходим в контейнер, где находится symfony
     - `docker exec -it php bash` 
     - `cp .env.lock .env`
     - `composer install`
     - `bin/console doctrine:migrations:migrate`
     - `bin/console cache:clear`
###### Итог 
1. api
    - http://localhost:8080/api/news
    - http://localhost:8080/api/news?page=1&year=2021&month=12&tag=спорт
2. db
    - http://localhost:9080/
