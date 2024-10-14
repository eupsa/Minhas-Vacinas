<?php
session_start(); // Inicia a sessão

// Verifica se a sessão está iniciada
if (!isset($_SESSION['user_id'])) {
    // Se a variável de sessão 'user_id' não estiver definida, redireciona para o login
    header("Location: ../login/index.html");
    exit();
}
// Se a sessão estiver ativa, não faz nada e permite o acesso à página.
?>