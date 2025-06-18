<?php
require '../../../vendor/autoload.php';
require '../../scripts/Conexao.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../../../');
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
    $email_body = file_get_contents('../../../assets/email/cadastro.html');
    $email_body = str_replace('{{code}}', $codigo, $email_body);
    $mail = new PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['HOST_SMTP'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom($_ENV['EMAIL'], 'Minhas Vacinas');
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
