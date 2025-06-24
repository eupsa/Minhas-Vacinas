<?php
session_start();
require_once __DIR__ . '/../../../../libs/autoload.php';
require_once '../../utils/ConexaoDB.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = filter_var($_POST['novoEmail'], FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $retorna = ['status' => false, 'msg' => "E-mail inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$_SESSION['temp_codigo'] = rand(100000, 999999);

if (EnviarEmail($email, $_SESSION['temp_codigo'])) {
    $retorna = ['status' => true, 'msg' => "Um código foi enviado para seu e-mail com um código de verificação."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function EnviarEmail($email, $codigo)
{
    $email_body = file_get_contents('../../../public/email/cadastro.html');
    $email_body = str_replace('{{code}}', $codigo, $email_body);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = isset($_ENV['MAIL_PORT']) ? (int)$_ENV['MAIL_PORT'] : 587;
        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Minhas Vacinas');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Alteração de Senha';
        $mail->Body = $email_body;
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
