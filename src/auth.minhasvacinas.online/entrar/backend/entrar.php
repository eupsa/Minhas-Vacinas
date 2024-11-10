<?php
// require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require '../../vendor/phpmailer/phpmailer/src/Exception.php';
// require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
// require '../../vendor/autoload.php';
require '../backend/scripts/conn.php';
ini_set('session.cookie_domain', '.minhasvacinas.online');
session_start();

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

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
            $senhaHash = hash('sha256', $senha);
            $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha AND email_conf = 1");
            $sql->bindValue(':email', $email);
            $sql->bindValue(':senha', $senhaHash);
            $sql->execute();

            if ($sql->rowCount() == 1) {
                $usuario = $sql->fetch(PDO::FETCH_BOTH);
                $type_user = $usuario['user_root'];
                $email_conf = $usuario['email_conf'];

                if ($type_user == 1) {
                    $retorna = ['adm' => true, 'msg' => "Login bem-sucedido! Bem-vindo Administrador, " . htmlspecialchars($usuario['nome']) . "."];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit;
                } else {
                    if ($email_conf != 1) {
                        $retorna = ['status' => false, 'msg' => "É necessário confirmar seu cadastro para acessar o sistema."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                    } else {
                        $retorna = ['status' => true, 'msg' => "Login bem-sucedido! Bem-vindo, " . htmlspecialchars($usuario['nome']) . "."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        $_SESSION['session_id'] = $usuario['id_user'];
                        $_SESSION['session_nome'] = $usuario['nome'];
                        $_SESSION['session_email'] = $usuario['email'];
                        exit;
                    }
                }
            } else {
                $retorna = ['status' => false, 'msg' => "As credenciais fornecidas estão incorretas ou o seu cadastro ainda não foi confirmado."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit;
            }
        } catch (PDOException $e) {
            $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar fazer o login: " . $e->getMessage()];
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
