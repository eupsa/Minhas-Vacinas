<?php
session_start();
require '../../scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id_vac = $dados['id_vac'];
$id_usuario = $_SESSION['session_id'];

if (empty($id_vac)) {
    $retorna = ['status'];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    try {
        $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_vac = :id_vac AND id_usuario = :id_usuario");
        $sql->bindValue(':id_vac', $id_vac);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $sql = $pdo->prepare("DELETE FROM vacina WHERE id_vac = :id_vac AND id_usuario = :id_usuario");
            $sql->bindValue(':id_vac', $id_vac);
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();

            $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_vac = :id_vac AND id_usuario = :id_usuario");
            $sql->bindValue(':id_vac', $id_vac);
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();

            if ($sql->rowCount() === 0) {
                $retorna = ['status'];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            }
        } else {
            $retorna = ['status'];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    } catch (PDOException $e) {
        $retorna = ['status'];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}
