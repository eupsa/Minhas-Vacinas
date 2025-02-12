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
$email_atual = $_SESSION['session_email'];

if (empty($email)) {
    $retorna = ['status' => false, 'msg' => "O campo e-mail não foi preenchido."];
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

$sql = $pdo->prepare("SELECT * FROM mudar_email WHERE email = :email");
$sql->bindValue(':email', $email);
$sql->execute();

if ($sql->rowCount() >= 3) {
    $retorna = ['status' => false, 'msg' => "Máximo de solicitaçõea alcançadas. Tente novamente mais tarde ou entre em contato conosc."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        $retorna = ['status' => false, 'msg' => "E-mail já cadastrado."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

try {
    $codigo = rand(100000, 999999);
    $sql = $pdo->prepare("INSERT INTO mudar_email (email, codigo, id_usuario) VALUES (:email, :codigo, :id_usuario)");
    $sql->bindValue(':email', $email);
    $sql->bindValue(':codigo', $codigo);
    $sql->bindValue(':id_usuario', $_SESSION['session_id']);
    $sql->execute();

    enviarEmail($email, $codigo);
    $retorna = ['status' => true, 'msg' => "Código enviado com sucesso!"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => $e];
    echo json_encode($retorna);
} finally {
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function enviarEmail($email, $codigo)
{
    $email_body = file_get_contents('../../../assets/email/alterar-email.html');
    $email_body = str_replace('{{code}}', $codigo, $email_body);
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nao.responder@minhasvacinas.online';
        $mail->Password = 'JE1+ip-PWMZvy-4x';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('nao.responder@minhasvacinas.online', 'Minhas Vacinas');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Alteração de E-mail ';
        $mail->addEmbeddedImage('../../../assets/img/logo-img.png', 'logo-img'); // Caminho da imagem e identificador CID
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
