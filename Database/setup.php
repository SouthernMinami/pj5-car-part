<?php

use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

$result = $mysqli->query("
    CREATE TABLE IF NOT EXISTS carsTable (
        id INT PRIMARY KEY AUTO_INCREMENT,
        make VARCHAR(50),
        model VARCHAR(50),
        year INT,
        color VARCHAR(20),
        price FLOAT,
        milegage FLOAT,
        transmission VARCHAR(20),
        engine VARCHAR(20),
        status VARCHAR(10)
    );
");

if (!$result)
    throw new Exception('クエリを実行できませんでした');
else
    print("SQL セットアップクエリを実行しました" . PHP_EOL);