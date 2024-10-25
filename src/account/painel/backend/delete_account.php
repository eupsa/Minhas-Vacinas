<?php
session_start(); // Inicia a sessão

// Inclui o script de conexão ao banco de dados
require '../../../backend/scripts/conn.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não logado.']);
    exit();
}

// Recupera o ID do usuário da sessão
$userId = $_SESSION['user_id'];

// Prepara a consulta para excluir a conta do usuário
$sql = $pdo->prepare("DELETE FROM usuario WHERE idUsuarios = :idUsuario");
$sql->bindValue(':idUsuario', $userId);

if ($sql->execute()) {
    // Se a exclusão for bem-sucedida, destrói a sessão e redireciona para a página de login
    session_destroy();
    echo json_encode(['status' => 'success', 'message' => 'Conta excluída com sucesso!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a conta.']);
}
