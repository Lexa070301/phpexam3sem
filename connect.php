<?php
define("HOST", "127.0.0.1");
define("DBNAME", "exam");
define("DBUSER", "root");
define("DBPASSWORD", "root");

// Подключение через PDO
try {
    $db = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e) {
    print('Error!' . $e->getMessage() . '<br/>');
    exit;
}
//Пример запроса
$id = 'mysql';

$stmt = $db->prepare("SELECT * FROM user WHERE 'User' = ?;");
$stmt->execute(array($id));
var_dump($stmt->fetch());