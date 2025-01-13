<?php
$url = "https://meuip.com/api/meuip.php";
$response = file_get_contents($url);
echo $response;
?>
