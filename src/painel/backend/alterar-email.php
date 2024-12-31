<?php
session_start();
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';
require '../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = filter_var(strtolower(trim($dados['email'])), FILTER_SANITIZE_EMAIL);

if (empty($email)) {
    $retorna = ['status' => false, 'msg' => "O e-mail não foi inserido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $retorna = ['status' => false, 'msg' => "E-mail fornecido é inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
$sql->bindValue(':email', $email);
$sql->execute();

if ($sql->rowCount() === 1) {

    $retorna = ['status' => false, 'msg' => "Já existe outro usuário com esse e-mail."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $usuario['id_usuario'];
    enviarEmail($email, $id_usuario);

    $retorna = ['status' => true, 'msg' => "E-mail enviando com sucesso. Verifique sua caixa de entrada para confirmar seu e-mail."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function enviarEmail($email, $id_usuario)
{
    $email_body = file_get_contents('../../../assets/email/alterar-email.php');
    $email_body = str_replace('{{id}}', $id_usuario, $email_body);
    $email_body = str_replace('{{email}}', $email, $email_body);
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
        $mail->Subject = 'Alertação de e-mail';
        $mail->Body = $email_body;
        $mail->AltBody = 'Este é o corpo do e-mail em texto plano, para clientes de e-mail sem suporte a HTML';
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
