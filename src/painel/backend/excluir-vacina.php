<?php
session_start();
require '../../scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id_vac = $dados['id_vac'];
$id_user = $_SESSION['session_id'];

if (empty($id_vac)) {
    $retorna = ['status' => false, 'msg' => "Não foi possível encontrar o atributo id_vac."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    try {
        $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_vac = :id_vac AND id_user = :id_user");
        $sql->bindValue(':id_vac', $id_vac);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $sql = $pdo->prepare("DELETE FROM vacina WHERE id_vac = :id_vac AND id_user = :id_user");
            $sql->bindValue(':id_vac', $id_vac);
            $sql->bindValue(':id_user', $id_user);
            $sql->execute();

            $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_vac = :id_vac AND id_user = :id_user");
            $sql->bindValue(':id_vac', $id_vac);
            $sql->bindValue(':id_user', $id_user);
            $sql->execute();

            if ($sql->rowCount() === 0) {
                $retorna = ['status' => true, 'msg' => "Vacina excluída com sucesso."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            }
        } else {
            $retorna = ['status' => false, 'msg' => "Vacina não encontrada."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    } catch (PDOException $e) {
        $retorna = ['status' => false, 'msg' => "Erro ao buscar o token: " . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}
