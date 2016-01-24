<?php

namespace App\Lib;

class Database extends \PDO
{

    public function __construct(Config $dbConfig)
    {

        $drive = $dbConfig->get('db_driver', 'mysql');
        $dbName = $dbConfig->get('db_name', '');
        $dbHost = $dbConfig->get('db_host', '127.0.0.1');
        $dbPort = $dbConfig->get('db_port');
        $username = $dbConfig->get('db_user', '');
        $passwd = $dbConfig->get('db_password', '');

        $dsn = $drive . ':dbname=' . $dbName . ';host=' . $dbHost;

        if ($dbPort) {
            $dsn .= ';port=' . $dbPort;
        }

        parent::__construct($dsn, $username, $passwd);
    }

}
