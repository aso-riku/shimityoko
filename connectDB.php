<?php
function connectDB() {
    $dsn = 'mysql:host=mysql321.phy.lolipop.lan;
        dbname=LAA1595187-shimityoko;charset=utf8';
    $username = 'LAA1595187';
    $password = 'shimityoko';

    $pdo = new PDO($dsn, $username, $password);
    return $pdo;
}

function connectDB_local() {
    $dsn = 'mysql:host=localhost;
    dbname=shimityoko;charset=utf8';
    $username = 'root';
    $password = 'root';

    $pdo = new PDO($dsn, $username, $password);
    return $pdo;
}