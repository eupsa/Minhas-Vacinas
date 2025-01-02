<?php

//Busca IP do usuário, mesmo com Proxy
// Busca IP do usuário, mesmo com Proxy
$ip_usuario = $_SERVER["REMOTE_ADDR"];
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip_usuario = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip_usuario = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip_usuario = $_SERVER['REMOTE_ADDR'];
}

echo $ip_usuario;