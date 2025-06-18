<?php
session_start();
require_once __DIR__ . '/../../../../libs/autoload.php';
require_once '../../utils/ConexaoDB.php';

$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$codigo = strtolower(trim($dados['codigo']));
$secret = strtoupper(trim($dados['key']));

if (empty($codigo) || empty($secret)) {
    $retorna = ['status' => false, 'msg' => "Key ou código não encontrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if ($g->checkCode($secret, $codigo)) {
    $sql = $pdo->prepare("INSERT INTO 2FA (email, chave_secreta) VALUES (:email, :chave_secreta)");
    $sql->bindValue(':email', $_SESSION['user_email']);
    $sql->bindValue(':chave_secreta', $secret);
    $sql->execute();

    if ($sql->rowCount() == 1) {
        $retorna = ['status' => true, 'msg' => "Sucesso! Autenticação 2FA ativada!"];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
    $retorna = ['status' => false, 'msg' => "Eta! Ocorreu um erro inesperado | 1."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    $retorna = ['status' => false, 'msg' => "Código incorreto"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$retorna = ['status' => false, 'msg' => "Eta! Ocorreu um erro inesperado."];
header('Content-Type: application/json');
echo json_encode($retorna);
exit();
