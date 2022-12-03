<?php
//phpinfo();
//die;

/*$pdo = new PDO(
    'mysql:host=127.0.0.1:3306;dbname=symfony_docker',
    'symfony',
    'symfony',
    array(
        //PDO::MYSQL_ATTR_SSL_KEY    =>'/path/to/client-key.pem',
        //PDO::MYSQL_ATTR_SSL_CERT=>'/path/to/client-cert.pem',
        //PDO::MYSQL_ATTR_SSL_CA    =>'/path/to/ca-cert.pem'
    )
);*/

/*try {
    $conn = new PDO("mysql:host=database;port=3306;dbname=symfony_docker", 'symfony', 'symfony');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

die;*/

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

