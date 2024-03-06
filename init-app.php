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

printf("Local database username: %s\n", Settings::env('DATABASE_USER'));
printf("Local database password (hashed): %s\n", password_hash(Settings::env('DATABASE_USER_PASSWORD'), PASSWORD_DEFAULT));
