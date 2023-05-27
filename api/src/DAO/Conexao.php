<?php

namespace App\DAO;

    abstract class Conexao
    {
        protected $pdo;

        public function __construct()
        {
            $host = $_ENV['SERVER_HOST'];
            $port = $_ENV['PORT'];
            $user = $_ENV['SERVER_USER'];
            $pass = $_ENV['SERVER_PASS'];
            $dbname = $_ENV['SERVER_DBNAME'];

            $dsn = "mysql:host={$host};dbname={$dbname};port{$port}";

            $this -> pdo = new \PDO($dsn, $user, $pass);
            $this -> pdo -> setAttribute(
                \PDO :: ATTR_ERRMODE,
                \PDO :: ERRMODE_EXCEPTION
            );
        }
    }