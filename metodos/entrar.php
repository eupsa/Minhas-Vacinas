<?php
session_start();
require 'config.php';

$email = $_REQUEST['email'];
$senha = $_REQUEST['senha'];
$senhaHash = hash('sha256', $senha);

function entrar($pdo, $email, $senha, $senhaHash)
{
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
            header("Location: ../painel/index.html");
            exit;
        } else {
            echo "E-mail ou senha incorretos. Tente novamente.";
        }
    } catch (PDOException $e) {
        echo "Erro ao acessar o banco de dados: " . $e->getMessage();
    }
}

if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION)) {
    header("Location: ../painel/index.html");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        entrar($pdo, $email, $senha, $senhaHash);
    }
} else {
    header("Location: ../cadastro/index.html");
}
