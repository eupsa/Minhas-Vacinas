<?php

function Gerar_Session($pdo)
{
    $sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
    $sql->bindValue(':id_usuario', $_SESSION['user_id']);
    $sql->execute();

    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user_estado'] = $usuario['estado'];
    $_SESSION['user_nascimento'] = $usuario['data_nascimento'];
    $_SESSION['user_genero'] = $usuario['genero'];
    $_SESSION['user_cpf'] = $usuario['cpf'];
    $_SESSION['user_telefone'] = $usuario['telefone'];
    $_SESSION['user_cidade'] = $usuario['cidade'];
}

function Auth($pdo)
{
    if (isset($_SESSION['user_id'], $_SESSION['user_ip'])) {
        // Verifica se o usuário existe na tabela 'usuario'
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
        $sql->bindValue(':id_usuario', $_SESSION['user_id']);
        $sql->execute();

        if ($sql->rowCount() != 1) {
            $_SESSION = [];
            session_destroy();
            header("Location: /src/auth/entrar/");
            exit();
        }

        $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE ip = :ip AND id_usuario = :id_usuario AND confirmado = 1");
        $sql->bindValue(':ip', $_SESSION['user_ip']);
        $sql->bindValue(':id_usuario', $_SESSION['user_id']);
        $sql->execute();

        if ($sql->rowCount() != 1) {
            $_SESSION = [];
            session_destroy();
            header("Location: /src/auth/entrar/");
            exit();
        }
    } else {
        $_SESSION = [];
        session_destroy();
        header("Location: /src/auth/entrar/");
        exit();
    }

    $sql = $pdo->prepare("SELECT * FROM usuario_google WHERE id_usuario = :id_usuario");
    $sql->bindValue(':id_usuario', $_SESSION['user_id']);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        $usuario_google = $sql->fetch(PDO::FETCH_BOTH);
        $_SESSION['user_foto'] = $usuario_google['foto_url'];
    }
}
