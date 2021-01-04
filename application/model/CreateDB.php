<?php


namespace application\model;
require_once('Model.php');

class CreateDB extends Model
{
    private $createTableQueries = array(
        "CREATE TABLE `users` (
          `id` int NOT NULL AUTO_INCREMENT,
          `user_name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
          `email` varchar(100) COLLATE utf8_persian_ci NOT NULL,
          `password` varchar(100) COLLATE utf8_persian_ci NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY (`email`,`user_name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",

        "CREATE TABLE `files` (
          `file_id` int NOT NULL AUTO_INCREMENT,
          `name` varchar(200) COLLATE utf8_persian_ci,
          `content_length` bigint,
          `content_type` varchar(100),
          `path` varchar(100),
          `user_id` int NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime DEFAULT NULL,
          PRIMARY KEY (`file_id`,`name`,`user_id`),
          FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",

    );

    private $tableInitializes = array(['table' => 'users', 'fields' => ['user_name', 'email', 'password'], 'values' => ['ghazal', 'ghazal@gmail.com', '1234']]);

    public function run()
    {
//        foreach ($this->createTableQueries as $createTableQuery) {
//            $this->createTable($createTableQuery);
//        }
//        foreach ($this->tableInitializes as $tableInitialize) {
//            $this->insert($tableInitialize['table'], $tableInitialize['fields'], $tableInitialize['values']);
//            echo "helllo";
//        }
    }
}

