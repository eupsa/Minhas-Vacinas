<?php
session_start();
require '../../scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id_vac = $dados['id_vac'];

if (empty($id_vac)) {
    $retorna = ['status' => false, 'msg' => "ID não encontrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}
else {
    try {
        $sql = $pdo->prepare("DELETE FROM vacina WHERE id_vac = :id_vac");
        $sql->bindValue(':id_vac', $id_vac);
        $sql->execute();
        if ($sql->rowCount() === 1) {
            $retorna = ['status' => true, 'msg' => 'Vacina excluída com sucesso!'];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        } else {
            $retorna = ['status' => false, 'msg' => 'Erro ao excluir a vacina.'];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    } catch (PDOException $e) {
        $retorna = ['status' => false, 'msg' => 'Erro ao excluir a vacina: ' . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }

}
