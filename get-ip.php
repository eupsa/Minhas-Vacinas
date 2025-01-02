<?php

if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip_do_usuario = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip_do_usuario = $_SERVER['REMOTE_ADDR'];
}
echo $ip_do_usuario;
