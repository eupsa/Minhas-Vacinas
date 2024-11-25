<?php
include '../../scripts/conn.php';
session_start();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$senha = $dados['senha'];

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (empty($email) || empty($senha)) {
        $retorna = ['status' => false, 'msg' => "Todos os campos devem ser preenchidos."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        try {
            $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() == 1) {
                $usuario = $sql->fetch(PDO::FETCH_BOTH);
                $email_conf = $usuario['email_conf'];

                if ($email_conf != 1) {
                    $retorna = ['status' => false, 'msg' => "É necessário confirmar seu cadastro para acessar o sistema."];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit;
                }
                if (password_verify($senha, $usuario['senha'])) {
                    $retorna = ['status' => true, 'msg' => "Bem-vindo à nossa plataforma, " . htmlspecialchars(explode(' ', $usuario['nome'])[0]) . "!"];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    $_SESSION['session_id'] = $usuario['id_user'];
                    $_SESSION['session_nome'] = $usuario['nome'];
                    $_SESSION['session_email'] = $usuario['email'];
                    exit;
                } else {
                    $retorna = ['status' => false, 'msg' => "As credenciais fornecidas estão incorretas."];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit;
                }
            } else {
                $retorna = ['status' => false, 'msg' => "O e-mail não existe em nosso sistema."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit;
            }
        } catch (PDOException $e) {
            $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar fazer o login"];
            // $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar fazer o login: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    }
} else {
    $retorna = ['status' => false, 'msg' => "E-mail fornecido é inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}
