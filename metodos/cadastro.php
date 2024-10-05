<?php
require 'config.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$estado = $_POST['estado'];
$senha = $_POST['senha'];
$confsenha = $_POST['confSenha'];

if ($senha != $confsenha) {
    echo "As senhas não coincidem";
} else {
    $senhaHash = hash('sha256', $senha);

    $sql = $pdo->prepare("INSERT INTO usuarios (nome, email, estado, senha) VALUES (:nome, :email, :estado, :senha)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':senha', $senhaHash);
    $sql->execute();

    header("Location: ../index.html");
    exit;
}
