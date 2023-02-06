cp .env.lock .env
composer install
echo 'Composer was installed'
bin/console doctrine:migrations:migrate
echo 'Migration was done'
bin/console cache:clear
echo 'Cache was cleared'