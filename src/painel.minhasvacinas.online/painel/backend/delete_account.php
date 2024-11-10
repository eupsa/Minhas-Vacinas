<?php
session_start();
require '../../../backend/scripts/conn.php';

if (!isset($_SESSION['session_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não logado.']);
    exit();
}

$id_user = $_SESSION['session_id'];

$sql = $pdo->prepare("DELETE FROM usuario WHERE id_user = :id_user");
$sql->bindValue(':id_user', $id_user);

if ($sql->execute()) {
    session_destroy();
    echo json_encode(['status' => 'success', 'message' => 'Conta excluída com sucesso!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a conta.']);
}