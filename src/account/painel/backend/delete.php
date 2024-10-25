<?php
require '../../../backend/scripts/conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não logado.']);
    exit();
}

if (isset($_POST['id'])) {
    $vacinaId = $_POST['id'];

    $sql = $pdo->prepare("DELETE FROM vacina WHERE idVacina = :idVacina");
    $sql->bindValue(':idVacina', $vacinaId);

    if ($sql->execute()) {
        header('Location: ../vaccines/index.php');
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a vacina.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID da vacina não especificado.']);
}
