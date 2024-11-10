<?php
require '../../../backend/scripts/conn.php';
session_start();

if (!isset($_SESSION['session_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não logado.']);
    exit();
}

if (isset($_POST['id'])) {
    $vacinaId = $_POST['id'];

    $sql = $pdo->prepare("DELETE FROM vacina WHERE id_vac = :id_vac");
    $sql->bindValue(':id_vac', $vacinaId);

    if ($sql->execute()) {
        header('Location: ../vaccines/index.php');
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a vacina.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID da vacina não especificado.']);
}
