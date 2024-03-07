<?php

use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

// Carテーブル
$car_create_query = "
CREATE TABLE IF NOT EXISTS Car (
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
";

$result = $mysqli->query($car_create_query);

if (!$result)
    throw new Exception('Carテーブルのセットアップクエリを実行できませんでした');
else
    print("Carテーブルのセットアップクエリを実行しました" . PHP_EOL);

$part_create_query = "
    CREATE TABLE IF NOT EXISTS Part (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50),
        description TEXT,
        price FLOAT,
        quantityInStock INT
    );
";

$result = $mysqli->query($part_create_query);

if (!$result)
    throw new Exception('Partテーブルのセットアップクエリを実行できませんでした');
else
    print("Partテーブルのセットアップクエリを実行しました" . PHP_EOL);

// CarPartテーブル
$car_part_create_query = "
    CREATE TABLE IF NOT EXISTS CarPart (
        carId INT, FOREIGN KEY(carId) REFERENCES Car(id),
        partId INT, FOREIGN KEY(partId) REFERENCES Part(id),
        quantity INT
    );
";

$result = $mysqli->query($car_part_create_query);
if (!$result)
    throw new Exception('CarPartテーブルのセットアップクエリを実行できませんでした');
else
    print("CarPartテーブルのセットアップクエリを実行しました" . PHP_EOL);

// Carのデータ
$car_insert_query = "
    INSERT INTO Car (make, model, year, color, price, milegage, transmission, engine, status) 
    VALUES 
        ('Toyota', 'Camry', 2018, 'White', 20000, 10000, 'Automatic', 'V6', 'New'), 
        ('Honda', 'Civic', 2017, 'Black', 15000, 8000, 'Automatic', 'V4', 'Used'), 
        ('Nissan', 'Altima', 2016, 'Red', 18000, 9000, 'Automatic', 'V6', 'Used'), 
        ('Ford', 'Fusion', 2015, 'Blue', 16000, 8500, 'Automatic', 'V4', 'Used')
";

$result = $mysqli->query($car_insert_query);
if (!$result)
    throw new Exception('Carテーブルのデータを挿入できませんでした');
else
    print("Carテーブルにデータを挿入しました" . PHP_EOL);

// Partのデータ
$part_insert_query = "
    INSERT INTO Part (name, description, price, quantityInStock)
    VALUES 
        ('Brake Pads', 'Front and Rear Brake Pads', 100, 50), 
        ('Oil Filter', 'Oil Filter for Engine', 10, 100), 
        ('Air Filter', 'Air Filter for Engine', 15, 100), 
        ('Headlight', 'Front Headlight', 50, 100)
";

$result = $mysqli->query($part_insert_query);
if (!$result)
    throw new Exception('Partテーブルのデータを挿入できませんでした');
else
    print("Partテーブルにデータを挿入しました" . PHP_EOL);

// CarPartのデータ
$car_part_insert_query = "
    INSERT INTO CarPart (carId, partId, quantity)
    VALUES 
        (1, 1, 2), (1, 2, 3), (1, 3, 1), (1, 4, 2), 
        (2, 1, 1), (2, 2, 2), (2, 3, 1), (2, 4, 1), 
        (3, 1, 2), (3, 2, 2), (3, 3, 2), (3, 4, 2), 
        (4, 1, 1), (4, 2, 1), (4, 3, 1), (4, 4, 1)
";

$result = $mysqli->query($car_part_insert_query);
if (!$result)
    throw new Exception('CarPartテーブルのデータを挿入できませんでした');
else
    print("CarPartテーブルにデータを挿入しました" . PHP_EOL);

echo "データの挿入が完了しました" . PHP_EOL;

$mysqli->close();


