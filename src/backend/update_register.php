<?php
session_start();
require '../backend/scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = strtolower(trim($dados['nome']));
$data_nascimento = trim($dados['data_nascimento']);
$telefone = trim($dados['telefone']);
$estado = trim($dados['estado']);
$genero = trim($dados['genero']);
$cidade = trim($dados['Cidade']);

$user_id = $_SESSION['user_id']; 

if (empty($nome) || empty($data_nascimento) || empty($telefone) || empty($estado) || empty($genero) || empty($cidade)) {
    $retorna = ['status' => false, 'msg' => "Preencha todos os campos"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

try {
    $sql = $pdo->prepare("UPDATE usuario SET nome = :nome, data_nascimento = :data_nascimento, telefone = :telefone, estado = :estado, genero = :genero, cidade = :cidade WHERE id = :id");

    // Bind dos parâmetros
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':data_nascimento', $data_nascimento);
    $sql->bindValue(':telefone', $telefone);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':genero', $genero);
    $sql->bindValue(':cidade', $cidade);
    $sql->bindValue(':id', $user_id);

    // Executa a query
    if ($sql->execute()) {
        // Atualiza os dados da sessão
        $_SESSION['user_nome'] = $nome;
        $_SESSION['user_data_nascimento'] = $data_nascimento;
        $_SESSION['user_telefone'] = $telefone;
        $_SESSION['user_estado'] = $estado;
        $_SESSION['user_genero'] = $genero;
        $_SESSION['user_cidade'] = $cidade;

        $retorna = ['status' => true, 'msg' => "Perfil atualizado com sucesso!"];
    } else {
        $retorna = ['status' => false, 'msg' => "Erro ao atualizar o perfil."];
    }
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "Erro inesperado: " . $e->getMessage()];
}
