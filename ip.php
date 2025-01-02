<?php

function getUserIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Verifica se o IP está no cabeçalho HTTP_CLIENT_IP
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Verifica se o IP está no cabeçalho HTTP_X_FORWARDED_FOR
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]); // Retorna o primeiro IP da lista
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        // Pega o IP direto da conexão
        return $_SERVER['REMOTE_ADDR'];
    }
    return 'IP não encontrado';
}

$ip_publico = getUserIP();
echo "IP Público do Usuário: " . $ip_publico;
