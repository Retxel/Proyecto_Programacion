<?php
try {
    $dbh = new PDO('mysql:host=127.0.0.1', 'root', '');
    $dbh->exec('CREATE DATABASE IF NOT EXISTS `proyecto_programacion`');
    echo 'DB Created';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
