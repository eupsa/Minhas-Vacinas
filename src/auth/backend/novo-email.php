<?php
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';
require '../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$novo_email = filter_var(strtolower(trim($dados['novo_email'])), FILTER_SANITIZE_EMAIL);
$id_usuario = $dados['id'];

if (empty($id_usuario) && empty($novo_email)) {
    $retorna = ['status' => false, 'msg' => $novo_email,  $id_usuario];
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

$sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :novo_email");
$sql->bindValue(':novo_email', $novo_email);
$sql->execute();

if ($sql->rowCount() == 1) {
    $retorna = ['status' => false, 'msg' => "Já existe um usuário com esse e-mail."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    $sql = $pdo->prepare("UPDATE usuario SET email = :novo_email WHERE id_usuario = :id_usuario");
    $sql->bindValue(':novo_email', $novo_email);
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->execute();

    $retorna = ['status' => true, 'msg' => "acho q deu bom"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();

    enviarEmail($novo_email);
}

function enviarEmail($novo_email)
{
    $email_body = file_get_contents('../../../assets/email/cadastro.php');
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
        $mail->addAddress($novo_email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'imau';
        $mail->Body = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
