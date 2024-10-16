<?php
require 'conn.php';
session_start();

function VefNoLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login/index.php");
        exit();
    }
}

function VefLogin()
{
    if (isset($_SESSION['user_id'])) {
        header("Location: ../painel/index.php");
        exit();
    }
}

function CreateSessions()
{
    global $pdo; // Certifique-se de que a conexão PDO está acessível

    // Verifica se o ID do usuário está na sessão antes de continuar
    if (isset($_SESSION['user_id'])) {
        try {
            // Preparar a consulta SQL para buscar os dados do usuário
            $sql = $pdo->prepare("SELECT estado, idade, genero, cpf, telefone, cidade FROM usuario WHERE idUsuarios = :userId");
            $sql->bindValue(':userId', $_SESSION['user_id']);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                $user = $sql->fetch(PDO::FETCH_ASSOC); // Use FETCH_ASSOC para obter um array associativo

                // Atualiza as sessões com os dados do banco, exceto ID e email
                foreach ($user as $key => $value) {
                    if (!empty($value)) { // Verifica se o valor não está vazio
                        $_SESSION['user_' . $key] = $value;
                    }
                }
            } else {
                // Para debug: Se não encontrar o usuário
                echo "Usuário não encontrado na base de dados.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        // Para debug: Se o ID do usuário não estiver na sessão
        echo "ID do usuário não encontrado na sessão.";
    }
}
