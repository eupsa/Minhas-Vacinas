<?php
session_start();
require_once '../../../vendor/autoload.php';
require_once '../../scripts/conn.php';

$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

$token = '697409';

$sql = $pdo->prepare("SELECT secretkey_2FA FROM usuario WHERE email = :email");
$sql->bindValue(':email', $_SESSION['user_email']);
$sql->execute();

if ($sql->rowCount() === 1) {
    $usuario = $sql->fetch(PDO::FETCH_BOTH);

    if ($usuario && isset($usuario['secretkey_2FA'])) {
        $secret = $usuario['secretkey_2FA'];

        if ($g->checkCode($secret, $token)) {
            echo 'deu bom';
        } else {
            echo 'token ruim';
        }
    } else {
        echo 'Erro: Usuário ou secretkey_2FA inválidos';
    }
} else {
    echo 'Usuário não encontrado';
}
