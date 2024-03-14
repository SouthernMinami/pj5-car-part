<?php

use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

// Carテーブル
const CREATE_CAR_TABLE_QUERY = "
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

// Partテーブル
const CREATE_PART_TABLE_QUERY = "
    CREATE TABLE IF NOT EXISTS Part (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50),
        description TEXT,
        price FLOAT,
        quantityInStock INT
    );
";

// CarPartテーブル(中間テーブル)
const CREATE_CAR_PART_TABLE_QUERY = "
    CREATE TABLE IF NOT EXISTS CarPart (
        carId INT, FOREIGN KEY(carId) REFERENCES Car(id),
        partId INT, FOREIGN KEY(partId) REFERENCES Part(id),
        quantity INT
    );
";
function insertCarQuery(
    string $make,
    string $model,
    int $year,
    string $color,
    float $price,
    float $mileage,
    string $transmission,
    string $engine,
    string $status
): string {
    return sprintf("
        INSERT INTO Car (make, model, year, color, price, milegage, transmission, engine, status)
        VALUES ('%s', '%s', %d, '%s', %f, %f, '%s', '%s', '%s');
    ", $make, $model, $year, $color, $price, $mileage, $transmission, $engine, $status);
}
;

function insertPartQuery(
    string $name,
    string $description,
    float $price,
    int $quantityInStock
): string {
    return sprintf("
        INSERT INTO Part (name, description, price, quantityInStock)
        VALUES ('%s', '%s', %f, %d);
    ", $name, $description, $price, $quantityInStock);
}

function insertCarPartQuery(
    int $carId,
    int $partId,
    int $quantity
): string {
    return sprintf("
        INSERT INTO CarPart (carId, partId, quantity)
        VALUES (%d, %d, %d);
    ", $carId, $partId, $quantity);
}

function runQuery(mysqli $mysqli, string $query): void
{
    $result = $mysqli->query($query);
    if (!$result) {
        throw new Exception('クエリを実行できませんでした');
    } else {
        print("クエリを実行しました" . PHP_EOL);
    }
}



// Carのデータ
runQuery($mysqli, CREATE_CAR_TABLE_QUERY);
runQuery(
    $mysqli,
    insertCarQuery(
        'Toyota',
        'Camry',
        2018,
        'White',
        20000,
        10000,
        'Automatic',
        'V6',
        'New'
    )
);

// Partのデータ
$part_insert_query = "
    INSERT INTO Part (name, description, price, quantityInStock)
    VALUES 
        ('Brake Pads', 'Front and Rear Brake Pads', 100, 50), 
        ('Oil Filter', 'Oil Filter for Engine', 10, 100), 
        ('Air Filter', 'Air Filter for Engine', 15, 100), 
        ('Headlight', 'Front Headlight', 50, 100)
";
runQuery($mysqli, CREATE_PART_TABLE_QUERY);
runQuery(
    $mysqli,
    insertPartQuery(
        'Brake Pads',
        'Front and Rear Brake Pads',
        100,
        50
    )
);

// CarPartのデータ
$car_part_insert_query = "
    INSERT INTO CarPart (carId, partId, quantity)
    VALUES 
        (1, 1, 2), (1, 2, 3), (1, 3, 1), (1, 4, 2), 
        (2, 1, 1), (2, 2, 2), (2, 3, 1), (2, 4, 1), 
        (3, 1, 2), (3, 2, 2), (3, 3, 2), (3, 4, 2), 
        (4, 1, 1), (4, 2, 1), (4, 3, 1), (4, 4, 1)
";
runQuery($mysqli, CREATE_CAR_PART_TABLE_QUERY);
runQuery(
    $mysqli,
    insertCarPartQuery(
        1,
        1,
        2
    )
);

echo "データの挿入が完了しました" . PHP_EOL;

$mysqli->close();


