<?php

namespace Database;

use mysqli;
use Helpers\Settings;

class MySQLWrapper extends mysqli {
    public function __construct(?string $hostname = 'localhost', ?string $username = null, ?string $password = null, ?string $database = null, ?int $port = null, ?string $socket = null) {
        // 接続失敗時には例外を投げるように設定
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $username = $username ?? Settings::env('DATABASE_USER');
        $password = $password ?? Settings::env('DATABASE_USER_PASSWORD');
        $database = $database ?? Settings::env('DATABASE_NAME');

        parent::__construct($hostname, $username, $password, $database, $port, $socket);
    }
    
    //　デフォルトのデータベースを取得
    public function getDatabaseName(): string {
        return $this->query("SELECT database() AS the_db")->fetch_row()[0];
    }
}