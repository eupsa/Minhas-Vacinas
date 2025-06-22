<?php
require_once '../../utils/ConexaoDB.php';

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

if ($dadosDispositivo['id_usuario'] !== $_POST['id_usuario']) {
    if (!empty($_POST['nome_dispositivo'])) {
        $sql = $pdo->prepare("UPDATE dispositivos SET nome_dispositivo = :nome, confirmado = 1 WHERE id = :id");
        $sql->bindValue(':nome', $_POST['nome_dispositivo']);
        $sql->bindValue(':id', $_POST['id_dispositivo']);

        if ($sql->execute()) {
            $retorna = ['status' => true, 'msg' => "O dispositivo foi confirmado."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    }

    $sql = $pdo->prepare("UPDATE dispositivos SET confirmado = 1 WHERE id = :id");
    $sql->bindValue(':id', $_POST['id_dispositivo']);
    if ($sql->execute()) {
        $retorna = ['status' => true, 'msg' => "O dispositivo foi confirmado."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
} else {
    $retorna = ['status' => false, 'msg' => "Você não tem permissão para manipular este dispositivo."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}
