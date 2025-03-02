<?php
session_start();
require_once '../../scripts/Conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nomeVac = trim($dados['nomeVac']);
$dataAplicacao = trim($dados['dataAplicacao']);
$proxima_dose = trim($dados['proxima_dose']);
$tipo = trim($dados['tipo']);
$dose = trim($dados['dose']);
$lote = trim($dados['lote']);
$obs = trim($dados['obs']);
$localAplicacao = trim($dados['localAplicacao']);

if (!empty($proxima_dose) && !compararDatas($dataAplicacao, $proxima_dose)) {
    $retorna = ['status' => false, 'msg' => "A próxima dose não pode ser anterior à data de aplicação."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (empty($proxima_dose)) {
    $proxima_dose = NULL;
}

if ($localAplicacao === 'outro' && empty($outro_local)) {
    $retorna = ['status' => false, 'msg' => "Por favor, informe o nome do local de vacinação"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
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

if (isset($_FILES['vac-card-img']) && $_FILES['vac-card-img']['error'] === UPLOAD_ERR_OK) {
    $arquivo = $_FILES['vac-card-img'];
    $arquivoNew = explode('.', $arquivo['name']);

    if (!in_array(strtolower(end($arquivoNew)), ['jpg', 'png', 'jpeg'])) {
        $retorna = ['status' => false, 'msg' => "Extensão inválida. Tente novamente com um arquivo .jpg, .png ou .jpeg."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        $name = bin2hex(random_bytes(50)) . '.' . strtolower(end($arquivoNew));

        $upload_dir = '/var/www/Assets-MV/vac-img/';

        if (!is_dir($upload_dir)) {
            $retorna = ['status' => false, 'msg' => "Diretório não encontrado."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }

        if (!move_uploaded_file($arquivo['tmp_name'], $upload_dir . $name)) {
            $retorna = ['status' => false, 'msg' => "Erro ao mover arquivo."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }

        $path = 'https://usercontent.minhasvacinas.online/vac-img/' . $name;
    }
} else {
    $path = $_SESSION['user_foto'] ?? null;
}

if (validarData($dataAplicacao)) {
    if (empty($nomeVac) || empty($dataAplicacao) || empty($tipo) || empty($dose) || empty($localAplicacao)) {
        $retorna = ['status' => false, 'msg' => "Preencha todos os campos obrigatórios"];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        try {
            $sql = $pdo->prepare("INSERT INTO vacina (nome_vac, data_aplicacao, proxima_dose, local_aplicacao, tipo, dose, lote, obs, imagem, id_usuario) 
                                  VALUES (:nome_vac, :data_aplicacao, :proxima_dose, :local_aplicacao, :tipo, :dose, :lote, :obs, :imagem, :id_usuario)");
            $sql->bindValue(':nome_vac', $nomeVac);
            $sql->bindValue(':data_aplicacao', $dataAplicacao);
            $sql->bindValue(':proxima_dose', $proxima_dose);
            $sql->bindValue(':local_aplicacao', $localAplicacao);
            $sql->bindValue(':tipo', $tipo);
            $sql->bindValue(':dose', $dose);
            $sql->bindValue(':lote', $lote);
            $sql->bindValue(':obs', $obs);
            $sql->bindValue(':imagem', $imagemBinaria, PDO::PARAM_LOB);
            $sql->bindValue(':id_usuario', $_SESSION['user_id']);
            $sql->execute();

            if ($sql->rowCount() === 1) {
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
    $retorna = [
        'status' => false,
        'msg' => "Data inválida ou no futuro. A data precisa estar no formato 'DIA-MÊS-ANO', não pode ser posterior ao dia de hoje e a próxima dose não pode ser anterior à data de aplicação."
    ];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function validarData($dataAplicacao)
{
    $dataFormatada = DateTime::createFromFormat('Y-m-d', $dataAplicacao);

    if (!$dataFormatada || $dataFormatada->format('Y-m-d') !== $dataAplicacao) {
        return false;
    }

    $dataHoje = new DateTime();
    if ($dataFormatada > $dataHoje) {
        return false;
    }

    $dataMinima = new DateTime('1900-01-01');
    if ($dataFormatada < $dataMinima) {
        return false;
    }

    return true;
}


function compararDatas($dataAplicacao, $proximaDose)
{
    $dataFormatada = DateTime::createFromFormat('Y-m-d', $dataAplicacao);
    $proximaDoseFormatada = DateTime::createFromFormat('Y-m-d', $proximaDose);

    if (!$dataFormatada || $dataFormatada->format('Y-m-d') !== $dataAplicacao) {
        return false;
    }

    if (!$proximaDoseFormatada || $proximaDoseFormatada->format('Y-m-d') !== $proximaDose) {
        return false;
    }

    if ($proximaDoseFormatada < $dataFormatada) {
        return false;
    }

    return true;
}
