<?php
$host = '127.0.0.1';
$port = 5432;
$user = 'postgres';
$pass = 'wassim';
$db   = 'educa_laravel';
try {
    $pdo = new PDO("pgsql:host={$host};port={$port};dbname=postgres", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $pdo->exec("CREATE DATABASE \"{$db}\"");
    echo "created\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'already exists') !== false) {
        echo "exists\n";
        exit(0);
    }
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}
