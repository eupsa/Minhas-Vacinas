<?php
session_start();
require_once __DIR__ . '../../../../../libs/autoload.php';
require_once '../../utils/ConexaoDB.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
$dotenv->load();

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
    $email_conf = $usuario['email_conf'];

    if ($email_conf == 1) {
        $retorna = ['status' => false, 'msg' => "Seu cadastro já foi confirmado, faça login."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }

    $sql = $pdo->prepare("SELECT * FROM confirmar_cadastro WHERE email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if ($sql->rowCount() != 3) {
        $codigo = rand(100000, 999999);
        $sql = $pdo->prepare("INSERT INTO confirmar_cadastro (email, codigo) VALUES (:email, :codigo)");
        $sql->bindValue(':email', $email);
        $sql->bindValue(':codigo', $codigo);
        $sql->execute();

        email_cadastro($email, $codigo);
        $retorna = ['status' => true, 'msg' => "Um novo código foi enviado para seu e-mail."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        $retorna = ['status' => false, 'msg' => "Você excedeu o limite de códigos. Tente novamente mais tarde."];
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

function email_cadastro($email, $codigo)
{
    $email_body = file_get_contents('/app/public/email/cadastro.html');
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
        $mail->Subject = 'Confirmação de Cadastro';
        $mail->addEmbeddedImage('../../../assets/img/logo-img.png', 'logo-img');
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
