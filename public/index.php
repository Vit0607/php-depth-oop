<?php

require '../vendor/autoload.php';

use Aura\SqlQuery\QueryFactory;

$queryFactory = new QueryFactory('mysql');

$select = $queryFactory->newSelect();

$select->cols(['*'])->from('posts');

// a PDO connection
$pdo = new PDO("mysql:host=localhost;dbname=app3;charset=utf8", "root", "");

// prepare the statement
$sth = $pdo->prepare($select->getStatement());

// bind the values and execute
$sth->execute($select->getBindValues());

// get the results back as an associative array
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

var_dump($result);

echo 123;