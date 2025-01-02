<?php

function getUserIPs()
{
    $ips = ['ipv4' => null, 'ipv6' => null];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        if (filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $ips['ipv4'] = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ips['ipv6'] = $_SERVER['HTTP_CLIENT_IP'];
        }
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipList as $ip) {
            $ip = trim($ip);
            if ($ips['ipv4'] === null && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ips['ipv4'] = $ip;
            } elseif ($ips['ipv6'] === null && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ips['ipv6'] = $ip;
            }
        }
    }

    if (empty($ips['ipv4']) && !empty($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $ips['ipv4'] = $_SERVER['REMOTE_ADDR'];
    }

    if (empty($ips['ipv6']) && !empty($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        $ips['ipv6'] = $_SERVER['REMOTE_ADDR'];
    }

    return $ips;
}

$ips_usuario = getUserIPs();
echo "IP Público do Usuário (IPv4): " . ($ips_usuario['ipv4'] ?? 'Não disponível') . "<br>";
echo "IP Público do Usuário (IPv6): " . ($ips_usuario['ipv6'] ?? 'Não disponível') . "<br>";
