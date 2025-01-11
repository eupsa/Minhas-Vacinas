<?php
session_start();
require '../../scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nomeVac = trim($dados['nomeVac']);
$dataAplicacao = trim($dados['dataAplicacao']);
$tipo = trim($dados['tipo']);
$dose = trim($dados['dose']);
$lote = trim($dados['lote']);
$obs = trim($dados['obs']);
$localAplicacao = trim($dados['localAplicacao']);
$outro_local = isset($dados['outro_local']) ? trim($dados['outro_local']) : '';

if ($localAplicacao === 'outro' && empty($outro_local)) {
    $retorna = ['status' => false, 'msg' => "Por favor, informe o nome do local de vacinação"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if ($localAplicacao === 'outro') {
    $localAplicacao = $outro_local;
}

if (empty($lote) && empty($obs)) {
    $lote = 'Lote não informado.';
    $obs = 'Nenhuma observação.';
}

if (empty($nomeVac) || empty($dataAplicacao) || empty($tipo) || empty($dose) || empty($localAplicacao)) {
    $retorna = ['status' => false, 'msg' => "Preencha todos os campos obrigatórios"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (validarData($dataAplicacao)) {
    if (empty($nomeVac) || empty($dataAplicacao) || empty($tipo) || empty($dose) || empty($localAplicacao)) {
        $retorna = ['status' => false, 'msg' => "Preencha todos os campos obrigatórios"];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        try {
            $sql = $pdo->prepare("INSERT INTO vacina (nome_vac, data_aplicacao, local_aplicacao, tipo, dose, lote, obs, id_usuario) 
                                  VALUES (:nome_vac, :data_aplicacao, :local_aplicacao, :tipo, :dose, :lote, :obs, :id_usuario)");
            $sql->bindValue(':nome_vac', $nomeVac);
            $sql->bindValue(':data_aplicacao', $dataAplicacao);
            $sql->bindValue(':local_aplicacao', $localAplicacao);
            $sql->bindValue(':tipo', $tipo);
            $sql->bindValue(':dose', $dose);
            $sql->bindValue(':lote', $lote);
            $sql->bindValue(':obs', $obs);
            $sql->bindValue(':id_usuario', $_SESSION['session_id']);
            $sql->execute();

            if ($sql->rowCount() ===  1) {
                $retorna = ['status' => true, 'msg' => "Vacina cadastrada com sucesso!"];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            } else {
                $retorna = ['status' => false, 'msg' => "Erro ao cadastrar a vacina. Tente novamente mais tarde."];
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
} else {
    $retorna = ['status' => false, 'msg' => "Data inválida ou data no futuro. A data precisa estar no formato 'DIA-MÊS-ANO' e não pode ser posterior ao dia de hoje."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function validarData($dataAplicacao)
{
    $dataFormatada = DateTime::createFromFormat('Y-m-d', $dataAplicacao);

    // Verifica se a data é válida e no formato correto
    if (!$dataFormatada || $dataFormatada->format('Y-m-d') !== $dataAplicacao) {
        return false;
    }

    // Verifica se a data de aplicação não é futura
    $dataHoje = new DateTime();
    if ($dataFormatada > $dataHoje) {
        return false;
    }

    // Verifica se a data de aplicação não é muito antiga (antes de 1900)
    $dataMinima = new DateTime('1900-01-01');
    if ($dataFormatada < $dataMinima) {
        return false;
    }

    return true;
}
