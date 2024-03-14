<?php
use Database\MySQLWrapper;

spl_autoload_extensions(".php");
spl_autoload_register(function ($class) {
    // クラス名から名前空間を取得
    $namespace = explode('\\', $class);
    // ファイルのパスを生成
    $file = __DIR__ . '/' . implode('/', $namespace) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// CLIから渡したmigrateオプションを取得
$ops = getopt('', ['migrate']);
if (isset($ops['migrate'])) {
    printf('Database migration started' . PHP_EOL);
    include('Database/setup.php');
    include('Database/setup1.php');
    printf('Database migration finished' . PHP_EOL);
}

$mysqli = new MySQLWrapper();
$charset = $mysqli->get_charset();
if ($charset === null)
    throw new Exception('Charsetがデータベースから読み取れませんでした。');

printf(
    "%s's charset: %s.%s",
    $mysqli->getDatabaseName(),
    $charset->charset,
    PHP_EOL
);

printf(
    "collation: %s.%s",
    $charset->collation,
    PHP_EOL
);

$mysqli->close();
