<?php


$pdo = new PDO("mysql:dbname=sosVacina;host=localhost:3306", "root", "");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

