<?php
require 'config.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$estado = $_POST['estado'];
$senha = $_POST['senha'];
$confsenha = $_POST['confSenha'];

try {
    $senhaHash = hash('sha256', $senha);

    $sql = $pdo->prepare("INSERT INTO usuarios (nome, email, estado, senha) VALUES (:nome, :email, :estado, :senha)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':senha', $senhaHash);
    $sql->execute();

    if ($sql->execute() == true) {
        enviarEmail($email);
        header("Location: ../index.html");
        exit;
    }
} catch (PDOException $e) {
    // Capturando erros específicos
    switch ($e->getCode()) {
        case 23000: // Duplicidade de entrada
            echo "Esse e-mail já está cadastrado. Por favor, use um e-mail diferente.";
            break;
        case 42000: // Erro de sintaxe SQL
            echo "Erro no banco de dados. Por favor, tente novamente mais tarde.";
            break; // Erro de conexão
            //case 08004:
            //echo "Não foi possível conectar ao banco de dados. Por favor, verifique a conexão.";
            //break;
        case 22007: // Formato de dados inválido
            echo "Formato de dados inválido. Por favor, verifique os campos e tente novamente.";
            break;
        default: // Mensagem genérica para outros erros
            echo "Erro ao cadastrar: " . $e->getMessage();
    }
}

function enviarEmail($email) {}
