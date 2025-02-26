<?php
session_start();
require_once '../../../vendor/autoload.php';
require_once '../../scripts/conn.php';

$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

$email = $_SESSION['email-temp'];
$key = $_SESSION['key-temp'];
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$codigo = strtolower(trim($dados['codigo']));

if (empty($codigo)) {
    $retorna = ['status' => false, 'msg' => "Código não encontrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id_usuario = :id AND ip = :ip AND confirmado = 1");
    $sql->bindValue(':id', $id_usuario);
    $sql->execute();
}




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