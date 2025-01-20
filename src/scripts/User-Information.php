<?php
require 'conn.php';
function Sessions($pdo)
{
    if (isset($_SESSION['session_id'])) {
        try {
            $sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :session_id");
            $sql->bindValue(':session_id', $_SESSION['session_id']);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                $user = $sql->fetch(PDO::FETCH_ASSOC);

                foreach ($user as $key => $value) {
                    if (!empty($value)) {
                        $_SESSION['session_' . $key] = $value;
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
        header("Location: /src/auth/entrar/");
        exit();
    }
}
