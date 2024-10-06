<?php
session_start();
require 'config.php';

$email = $_REQUEST['email'];
$senha = $_REQUEST['senha'];

$senhaHash = hash('sha256', $senha);

try {
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
    $sql->bindValue(':email', $email);
    $sql->bindValue(':senha', $senhaHash);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $usuario = $sql->fetch(PDO::FETCH_BOTH);    
        
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_nome'] = $usuario['nome'];
        $_SESSION['user_email'] = $usuario['email'];
        $_SESSION['user_cidade'] = $usuario['cidade'];
        header("Location: ../painel/index.html");
        exit;
    } else {
        echo "E-mail ou senha incorretos. Tente novamente.";
    }
} catch (PDOException $e) {
    echo "Erro ao acessar o banco de dados: " . $e->getMessage();
}