<?php

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

use Helpers\Settings;

// 接続失敗時には例外を投げるように設定
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli = new mysqli('localhost', Settings::env('DATABASE_USER'), Settings::env('DATABASE_USER_PASSWORD'), Settings::env('DATABASE_NAME'));

$charset = $mysqli->get_charset();

if ($charset === null) {
    throw new Exception('Charset could be read from the database');
}

// DBの文字セット、照合順序、統計情報を取得
printf("%s'%s charset", Settings::env('DATABASE_NAME'), $charset->charset, PHP_EOL);
printf("collation: %s'%s ", $charset->collation, PHP_EOL);

$mysqli->close();