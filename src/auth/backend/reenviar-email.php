<?php
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
    $retorna = ['status' => false, 'msg' => "O campo e-mail não foi preenchido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $retorna = ['status' => false, 'msg' => "E-mail inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
$sql->bindValue(':email', $email);
$sql->execute();

if ($sql->rowCount() == 1) {
    $usuario = $sql->fetch(PDO::FETCH_BOTH);
    $nome = $usuario['nome'];

    $sql = $pdo->prepare("SELECT * FROM confirmar_cadastro WHERE email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if ($sql->rowCount() < 2) {
        $codigo = rand(100000, 999999);
        $sql = $pdo->prepare("INSERT INTO confirmar_cadastro (nome, email, codigo) VALUES (:nome, :email, :codigo)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':codigo', $codigo);
        $sql->execute();

        reenviarEmail($nome, $email, $codigo);
        $retorna = ['status' => true, 'msg' => "Um novo código foi enviado para seu e-mail."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        $retorna = ['status' => false, 'msg' => "Você excedeu o limite. Tente novamente mais tarde ou entre em contato com o suporte."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
} else {
    $retorna = ['status' => false, 'msg' => "Cadastro não encontrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}


function reenviarEmail($nome, $email, $codigo)
{
    $email_body = file_get_contents('../../../assets/email/cadastro.php');
    $email_body = str_replace('{{nome}}', $nome, $email_body);
    $email_body = str_replace('{{codigo}}', $codigo, $email_body);
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
        $mail->Subject = 'Confirmação de Cadastro';
        $mail->Body = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
