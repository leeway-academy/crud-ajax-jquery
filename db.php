<?php

try {
    $db = new PDO('sqlite:mydb.sq3');
} catch (PDOException $exception) {
    die("Can't connect to the database: {$exception->getMessage()}");
}
