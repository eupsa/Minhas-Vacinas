<?php
session_start();
require_once '../../scripts/Conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id_vac = $dados['id_vac'];
$id_usuario = $_SESSION['user_id'];

if (empty($id_vac)) {
    header('Location: ../vacinas/');
    exit();
} else {
    try {
        $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_vac = :id_vac AND id_usuario = :id_usuario");
        $sql->bindValue(':id_vac', $id_vac);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $vacina = $sql->fetch(PDO::FETCH_BOTH);

            if (isset($vacina['path_card'])) {
                $path = explode('/',  $vacina['path_card'][4]);

                $dir = '/var/www/Assets-MV/vac-img/' . $path .
                unlink($dir);
            }

            $sql = $pdo->prepare("DELETE FROM vacina WHERE id_vac = :id_vac AND id_usuario = :id_usuario");
            $sql->bindValue(':id_vac', $id_vac);
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();

            $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_vac = :id_vac AND id_usuario = :id_usuario");
            $sql->bindValue(':id_vac', $id_vac);
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();

            if ($sql->rowCount() === 0) {
                header('Location: ../vacinas/');
                exit();
            }
        } else {
            header('Location: ../vacinas/');
            exit();
        }
    } catch (PDOException $e) {
        header('Location: ../vacinas/');
        exit();
    }
}
