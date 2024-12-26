<?php
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';
require '../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));

if (empty($email)) {
    $retorna = ['status' => false, 'msg' => "Todos os campos devem ser preenchidos."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    try {
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $usuario = $sql->fetch(PDO::FETCH_BOTH);
            $nome = $usuario['nome'];
            $token = bin2hex(random_bytes(50));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $sql = $pdo->prepare("INSERT INTO esqueceu_senha (email, token, data_expiracao) VALUES (:email, :token, :data_expiracao)");
            $sql->bindValue(':email', $email);
            $sql->bindValue(':token', $token);
            $sql->bindValue(':data_expiracao', $expiry);
            $sql->execute();
            enviarEmail($nome, $email, $token);
            $retorna = ['status' => true, 'msg' => "Um e-mail foi enviado com um link para alteração da senha."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        } else {
            $retorna = ['status' => false, 'msg' => "O usuário informado não foi encontrado em nosso sistema."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    } catch (PDOException $e) {
        // $retorna = ['status' => false, 'msg' => "Erro ao logar: " . $e->getMessage()];
        $retorna = ['status' => false, 'msg' => "Erro. Tente novamente mais tarde ou contacte o suporte."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

function enviarEmail($nome, $email, $token)
{
    $email_body = file_get_contents('../../../assets/email/esqueceu-senha.php');
    $email_body = str_replace('{{nome}}', $nome, $email_body);
    $email_body = str_replace('{{email}}', $email, $email_body);
    $email_body = str_replace('{{token}}', $token, $email_body);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'equipevaccilife@gmail.com';
        $mail->Password = 'sfii esho quah qkjd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('equipevaccilife@gmail.com', 'Minhas Vacinas');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Solicitação de Redefinição de Senha';
        $mail->Body = $email_body;
        $mail->AltBody = 'Este é o corpo do e-mail em texto plano, para clientes de e-mail sem suporte a HTML';
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
