<?php
$pdo = new PDO("mysql:dbname=minhas_vacinas;host=vacinas.cfmmccyw4yhv.sa-east-1.rds.amazonaws.com", "admin", "Chicote1");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);