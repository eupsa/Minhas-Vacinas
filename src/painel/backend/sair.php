<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('session.cookie_domain', '.minhasvacinas.online');

$_SESSION = [];
session_destroy();

header("Location: https://auth.minhasvacinas.online/login");
exit();
