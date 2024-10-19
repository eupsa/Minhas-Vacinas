<?php
require '../backend/scripts/conn.php';
require '../backend/scripts/auth.php';
VefLogin();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$senha = $dados['senha'];

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (empty($email) || empty($senha)) {
        $retorna = ['status' => false, 'msg' => "Preencha todos os campos"];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        try {
            $senhaHash = hash('sha256', $senha);
            $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha");
            $sql->bindValue(':email', $email);
            $sql->bindValue(':senha', $senhaHash);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                $usuario = $sql->fetch(PDO::FETCH_BOTH);
                $_SESSION['user_id'] = $usuario['idUsuarios'];
                $_SESSION['user_nome'] = $usuario['nome'];
                $_SESSION['user_email'] = $usuario['email'];
                $retorna = ['status' => true, 'msg' => "Login bem-sucedido!"];
                header('Content-Type: application/json');
                echo json_encode($retorna);
            } else {
                $retorna = ['status' => false, 'msg' => "Usuário ou senha incorretos."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit;
            }
        } catch (PDOException $e) {
            $retorna = ['status' => false, 'msg' => "Erro ao logar: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    }
} else {
    $retorna = ['status' => false, 'msg' => "E-Mail inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}
