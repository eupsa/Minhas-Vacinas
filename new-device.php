<?php
require_once '../../utils/ConexaoDB.php';
$id_usuario = isset($_GET['id']) ? $_GET['id'] : '';
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$erro = '';

if (empty($id_usuario) || empty($ip)) {
    echo json_encode(['status' => false, 'msg' => "Variável IP ou ID não definida."]);
    exit();
}

$retorna = null;
try {
    $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE ip = :ip AND id_usuario = :id_usuario");
    $sql->bindValue(':ip', $ip);
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->execute();

    if ($sql->rowCount() === 0) {
        $retorna = ['status' => false, 'msg' => "Nenhum dispositivo encontrado com o IP e ID fornecidos."];
    } else {
        $sql = $pdo->prepare("UPDATE dispositivos SET confirmado = 1 WHERE ip = :ip AND id_usuario = :id_usuario");
        $sql->bindValue(':ip', $ip);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $retorna = ['status' => true, 'msg' => "Dispositivo adicionado à sua conta."];
        } else {
            $retorna = ['status' => false, 'msg' => "Erro ao adicionar dispositivo."];
        }
    }
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "Erro ao adicionar dispositivo: " . $e->getMessage()];
}
