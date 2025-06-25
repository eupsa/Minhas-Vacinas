<?php
require_once '../../utils/ConexaoDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../entrar/");
    exit();
}

if (empty($_POST['id_usuario']) || empty($_POST['id_dispositivo'])) {
    $retorna = ['status' => false, 'msg' => "ID Usuário ou ID Dispositivo não informado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id = :id");
$sql->bindValue(':id', $_POST['id_dispositivo']);
$sql->execute();

if ($sql->rowCount() <= 0) {
    $retorna = ['status' => false, 'msg' => "O dispositivo informado não existe."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$dadosDispositivo = $sql->fetch();

// Agora checamos se o dispositivo pertence ao usuário corretamente
if ($dadosDispositivo['id_usuario'] === $_POST['id_usuario']) {
    // Se nome do dispositivo foi enviado, atualiza também
    if (!empty($_POST['nome_dispositivo'])) {
        $sql = $pdo->prepare("UPDATE dispositivos SET nome_dispositivo = :nome, confirmado = 1 WHERE id = :id");
        $sql->bindValue(':nome', $_POST['nome_dispositivo']);
    } else {
        $sql = $pdo->prepare("UPDATE dispositivos SET confirmado = 1 WHERE id = :id");
    }

    $sql->bindValue(':id', $_POST['id_dispositivo']);

    if ($sql->execute()) {
        $retorna = ['status' => true, 'msg' => "O dispositivo foi confirmado."];
    } else {
        $retorna = ['status' => false, 'msg' => "Erro ao confirmar o dispositivo."];
    }

    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    $retorna = ['status' => false, 'msg' => "Você não tem permissão para manipular este dispositivo."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}
