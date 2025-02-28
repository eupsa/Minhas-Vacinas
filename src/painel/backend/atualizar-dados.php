<?php
session_start();
require_once '../../scripts/Conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = isset($dados['nome']) ? ucwords(trim($dados['nome'])) : null;
$cpf_formatado = isset($dados['cpf']) ? trim($dados['cpf']) : ($_SESSION['user_cpf'] ?? null);
$cpf = preg_replace('/[^0-9]/', '', $cpf_formatado);
$data_nascimento = isset($dados['data_nascimento']) ? trim($dados['data_nascimento']) : null;
$telefone = isset($dados['telefone']) ? trim($dados['telefone']) : null;
$estado = isset($dados['estado']) ? trim($dados['estado']) : 'N/A';
$genero = isset($dados['genero']) ? $dados['genero'] : null;
$cidade = isset($dados['cidade']) ? trim($dados['cidade']) : $_SESSION['user_cidade'];

if (empty($nome) && empty($cpf) && empty($data_nascimento) && empty($telefone) && empty($estado) && empty($genero)) {
    $retorna = ['status' => false, 'msg' => 'Preencha ao menos um campo para atualização.'];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (!empty($cpf)) {
    if (!validaCPF($cpf)) {
        $retorna = ['status' => false, 'msg' => 'O CPF informado é inválido. Por favor, verifique e tente novamente.'];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

if (!empty($data_nascimento)) {
    if (!validarData($data_nascimento)) {
        $retorna = ['status' => false, 'msg' => "Data inválida ou no futuro. A data precisa estar no formato 'DIA-MÊS-ANO' e não pode ser posterior ao dia de hoje."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

if (!empty($cpf_formatado)) {
    $sql = $pdo->prepare("SELECT * FROM usuario WHERE cpf = :cpf AND id_usuario != :id");
    $sql->bindValue(':cpf', $cpf_formatado);
    $sql->bindValue(':id', $_SESSION['user_id']);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $retorna = ['status' => false, 'msg' => 'CPF já cadastrado.'];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

$path = null;
if (isset($_FILES['foto-perfil']) && $_FILES['foto-perfil']['error'] === UPLOAD_ERR_OK) {
    $arquivo = $_FILES['foto-perfil'];
    $arquivoNew = explode('.', $arquivo['name']);

    if (!in_array(strtolower(end($arquivoNew)), ['jpg', 'png', 'jpeg'])) {
        die('Extensão inválida');
    } else {
        $name = bin2hex(random_bytes(50)) . '.' . strtolower(end($arquivoNew));
        $upload_dir = '/var/www/Assets-MV/user-img/';

        if (!is_dir($upload_dir)) {
            die('Diretório de upload não encontrado.');
        }

        if (!move_uploaded_file($arquivo['tmp_name'], $upload_dir . $name)) {
            die('Erro ao mover o arquivo para o diretório de upload.');
        }

        $path = 'https://usercontent.minhasvacinas.online/user-img/' . $name;
    }
}

try {
    $sql = "UPDATE usuario SET ";
    $params = [];

    if ($nome) {
        $sql .= "nome = :nome, ";
        $params[':nome'] = $nome;
    }
    if ($cpf_formatado) {
        $sql .= "cpf = :cpf, ";
        $params[':cpf'] = $cpf_formatado;
    }
    if ($data_nascimento) {
        $sql .= "data_nascimento = :data_nascimento, ";
        $params[':data_nascimento'] = $data_nascimento;
    }
    if ($telefone) {
        $sql .= "telefone = :telefone, ";
        $params[':telefone'] = $telefone;
    }
    if ($estado) {
        $sql .= "estado = :estado, ";
        $params[':estado'] = $estado;
    }
    if ($genero) {
        $sql .= "genero = :genero, ";
        $params[':genero'] = $genero;
    }
    if ($cidade) {
        $sql .= "cidade = :cidade, ";
        $params[':cidade'] = $cidade;
    }
    if ($path) {
        $sql .= "foto_perfil = :foto_perfil, ";
        $params[':foto_perfil'] = $path;
    }

    // Remove a última vírgula e adiciona a cláusula WHERE
    $sql = rtrim($sql, ', ') . " WHERE id_usuario = :id";
    $params[':id'] = $_SESSION['user_id'];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $retorna = ['status' => true, 'msg' => "Alteração realizada com sucesso. Suas informações estão atualizadas."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "Erro: " . $e->getMessage()];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function validaCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$t] != $d) {
            return false;
        }
    }

    return true;
}

function validarData($data_nascimento)
{
    $dataFormatada = DateTime::createFromFormat('Y-m-d', $data_nascimento);

    // Verifica se a data é válida e no formato correto
    if (!$dataFormatada || $dataFormatada->format('Y-m-d') !== $data_nascimento) {
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
