<?php
session_start();
require '../backend/scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nomeVac = trim($dados['nomeVac']);
$dataAplicacao = trim($dados['dataAplicacao']);
$tipo = trim($dados['tipo']);
$dose = trim($dados['dose']);
$lote = trim($dados['lote']);
$obs = trim($dados['obs']);
$localAplicacao = trim($dados['localAplicacao']);

if (empty($nomeVac) || empty($dataAplicacao) || empty($tipo) || empty($dose) || empty($localAplicacao)) {
    $retorna = ['status' => false, 'msg' => "Preencha todos os campos"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    try {
        $sql = $pdo->prepare("INSERT INTO vacina (nome_vac, data_aplicacao, local_aplicacao, tipo, dose, lote, obs, id_user) VALUES (:nome_vac, :data_aplicacao, :local_aplicacao, :tipo, :dose, :lote, :obs, :id_user)");
        $sql->bindValue(':nome_vac', $nomeVac);
        $sql->bindValue(':data_aplicacao', $dataAplicacao);
        $sql->bindValue(':local_aplicacao', $localAplicacao);
        $sql->bindValue(':tipo', $tipo);
        $sql->bindValue(':dose', $dose);
        $sql->bindValue(':lote', $lote);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':id_user', $_SESSION['session_id']);
        $sql->execute();

        if ($sql->rowCount() ===  1) {
            $retorna = ['status' => true, 'msg' => "Vacina adicionada com sucesso!"];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        } else {
            $retorna = ['status' => false, 'msg' => "Erro ao cadastrar a vacina."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    } catch (PDOException $e) {
        $retorna = ['status' => false, 'msg' => "Erro ao cadastrar a vacina: " . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}
