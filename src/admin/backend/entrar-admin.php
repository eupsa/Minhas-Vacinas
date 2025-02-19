<?php
require '../../scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));
$senha = $dados['senha'];

if (empty($email) || empty($senha)) {
    $retorna = ['status' => false, 'msg' => "Todos os campos devem ser preenchidos."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    $sql = $pdo->prepare("SELECT * FROM admin WHERE email_admin = :email_admin");
    $sql->bindValue(':email_admin', $email);
    $sql->execute();

    if ($sql->rowCount() != 1) {
        $retorna = ['status' => false, 'msg' => "Usuário não cadastrado."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }

    $usuario = $sql->fetch(PDO::FETCH_BOTH);
    if (password_verify($senha, $usuario['senha'])) {
        $retorna = ['status' => true, 'msg' => "Bem-vindo à nossa plataforma, " . htmlspecialchars(explode(' ', $usuario['nome_admin'])[0]) . "!"];
        header('Content-Type: application/json');
        echo json_encode($retorna);

        $_SESSION['user_id'] = $usuario['id_admin'];
        $_SESSION['user_nome'] = $usuario['nome_admin'];
        $_SESSION['user_email'] = $usuario['email_admin'];
        exit();
    }

    $retorna = ['status' => false, 'msg' => "E-mail ou senha incorretos."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}
