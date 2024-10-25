<?php
session_start();
require '../backend/scripts/conn.php'; // Certifique-se de que isso cria a variável $pdo

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
        $sql = $pdo->prepare("INSERT INTO vacina (nomeVac, dataAplicacao, localAplicacao, tipo, dose, lote, obs, idUsuario) VALUES (:nomeVacina, :dataAplicacao, :localAplicacao, :tipo, :dose, :lote, :obs, :idUsuario)");
        $sql->bindValue(':nomeVacina', $nomeVac);
        $sql->bindValue(':dataAplicacao', $dataAplicacao);
        $sql->bindValue(':localAplicacao', $localAplicacao);
        $sql->bindValue(':tipo', $tipo);
        $sql->bindValue(':dose', $dose);
        $sql->bindValue(':lote', $lote);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':idUsuario', $_SESSION['user_id']);
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
