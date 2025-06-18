<?php
session_start();
require_once __DIR__ . '../../../../../libs/autoload.php';
require_once '../../utils/ConexaoDB.php';

$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$codigo = strtolower(trim($dados['codigo']));

if (empty($codigo) || empty($_SESSION['email-temp'])) {
    $retorna = ['status' => false, 'msg' => "Código ou e-mail temporário não encontrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$sql = $pdo->prepare("SELECT chave_secreta FROM 2FA WHERE email = :email");
$sql->bindValue(':email', $_SESSION['email-temp']);
$sql->execute();

if ($sql->rowCount() == 1) {
    $user = $sql->fetch(PDO::FETCH_BOTH);
    $secret = $user['chave_secreta'];
    if ($g->checkCode($secret, $codigo)) {
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
        $sql->bindValue(':email', $_SESSION['email-temp']);
        $sql->execute();

        $usuario = $sql->fetch(PDO::FETCH_BOTH);
        $_SESSION['user_id'] = $usuario['id_usuario'];
        $_SESSION['user_nome'] = $usuario['nome'];
        $_SESSION['user_email'] = $usuario['email'];
        $_SESSION['user_ip'] = ObterIP();
        $retorna = ['status' => true, 'msg' => "Bem-vindo à nossa plataforma, " . htmlspecialchars(explode(' ', $usuario['nome'])[0]) . "!"];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }

    $retorna = ['status' => false, 'msg' => "Código 2FA expirado ou incorreto."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function ObterIP()
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = '192.168.1';
    }

    return $ip;
}
