<?php

$user_agent = $_SERVER['HTTP_USER_AGENT'];

function get_browser_info($user_agent)
{
    if (strpos($user_agent, 'Windows NT') !== false) {
        $os = 'Windows';
    } elseif (strpos($user_agent, 'Macintosh') !== false) {
        $os = 'Mac OS';
    } elseif (strpos($user_agent, 'Linux') !== false) {
        $os = 'Linux';
    } elseif (strpos($user_agent, 'Android') !== false) {
        $os = 'Android';
    } elseif (strpos($user_agent, 'iPhone') !== false) {
        $os = 'iOS';
    } else {
        $os = 'Desconhecido';
    }

    if (strpos($user_agent, 'Chrome') !== false) {
        $browser = 'Chrome';
    } elseif (strpos($user_agent, 'Firefox') !== false) {
        $browser = 'Firefox';
    } elseif (strpos($user_agent, 'Safari') !== false) {
        $browser = 'Safari';
    } elseif (strpos($user_agent, 'Edge') !== false) {
        $browser = 'Edge';
    } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
        $browser = 'Internet Explorer';
    } else {
        $browser = 'Desconhecido';
    }

    return [
        'os' => $os,
        'browser' => $browser
    ];
}

print_r(get_browser_info($user_agent));