<?php
use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

$result = $mysqli->query(file_get_contents(__DIR__ . '/Examples/cars-setup1.sql'));

if ($result === false)
    throw new Exception('クエリを実行できませんでした。');
else
    print("クエリを実行しました。" . PHP_EOL);
