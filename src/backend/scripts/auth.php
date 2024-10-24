<?php
require 'conn.php';
session_start();

function SeNaoLogado()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../account/auth/login/login.php");
        exit();
    }
}

function SeLogado()
{
    if (isset($_SESSION['user_id'])) {
        header("Location: ../../painel/index.php");
        exit();
    }
}


// usada no perfil
function CreateSessions($pdo)
{

    if (isset($_SESSION['user_id'])) {
        try {
            $sql = $pdo->prepare("SELECT nome, estado, idade, genero, cpf, telefone, cidade FROM usuario WHERE idUsuarios = :userId");
            $sql->bindValue(':userId', $_SESSION['user_id']);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                $user = $sql->fetch(PDO::FETCH_ASSOC);

                foreach ($user as $key => $value) {
                    if (!empty($value)) {
                        $_SESSION['user_' . $key] = $value;
                    }
                }
            } else {
                session_destroy();
                header("Location: ../painel/index.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header("Location: ../painel/index.php");
        exit();
    }
}
