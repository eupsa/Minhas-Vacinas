<?php
session_start();
require '../../scripts/conn.php';
require '../../../vendor/autoload.php';
require '../../scripts/registrar-dispositivos.php';

use Google\Client as GoogleClient;

if (empty($_POST['credential']) || empty($_POST['g_csrf_token'])) {
    $_SESSION['erro_email'] = "Dados de login inválidos.";
    header('Location: ../cadastro/');
    exit();
}

$cookie = $_COOKIE['g_csrf_token'];

if ($_POST['g_csrf_token'] != $cookie) {
    $_SESSION['erro_email'] = "Token CSRF inválido.";
    header('Location: ../cadastro/');
    exit();
}

$client = new GoogleClient(['client_id' => '14152276280-9pbtedkdibk5rsktetmnh32rap49a8jm.apps.googleusercontent.com']);
$payload = $client->verifyIdToken($_POST['credential']);

if (isset($payload['email'])) {
    $googleId = $payload['sub'];
    $email = $payload['email'];
    $nome = ucwords(trim($payload['name']));
    $foto_url = $payload['picture'];
    $ip = get_real_ip();

    $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $_SESSION['erro_email'] = "O e-mail já existe em nosso sistema.";
        header('Location: ../cadastro/');
        exit();
    }

    $sql = $pdo->prepare("INSERT INTO usuario (nome, email, email_conf) VALUES (:nome, :email, 1)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->execute();

    $id_usuario = $pdo->lastInsertId();
    $sql = $pdo->prepare("INSERT INTO usuario_google (id_usuario, google_id, foto_url) VALUES (:id_usuario, :google_id, :foto_url)");
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->bindValue(':google_id', $googleId);
    $sql->bindValue(':foto_url', $foto_url);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        $ip = registrar_dispositivo($pdo, $id_usuario);

        $sql = $pdo->prepare("UPDATE usuario SET ip_cadastro = :ip_cadastro WHERE id_usuario = :id_usuario");
        $sql->bindValue(':ip_cadastro', $ip);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->execute();
    }

    if ($sql->rowCount() === 1) {
        $_SESSION['sucesso_email'] = "Cadastro realizado com sucesso. ";
        header('Location: ../cadastro/');
        exit();
    } else {
        $_SESSION['erro_email'] = "Erro ao realizar o cadastro.";
        header('Location: ../cadastro/');
        exit();
    }
}
