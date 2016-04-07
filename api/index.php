<?php

define('API_KEY', sha1("asd9kasid0"));

require_once realpath('./vendor/autoload.php');

require_once 'Db.php';

function dd($value, $exit = true)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    if ($exit) {
        exit;
    }
}

try {
    $pdo = new PDO("mysql:host=localhost; dbname=db004", "root", "asdasd");
} catch (PDOException $ex) {
    die("Database Connection Error: " . $ex->getMessage());
}

$pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

$db = new Db($pdo);

$app = new \Slim\Slim();

require_once './routes/inc.php';

$app->get('/', function () use ($db) {
});

$app->run();
