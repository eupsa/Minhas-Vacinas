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
$email_atual = $_SESSION['user_email'];

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
    $sql->bindValue(':id_usuario', $_SESSION['user_id']);
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
    $email_body = file_get_contents('/app/public/email/alterar-email.html');
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
        $mail->Subject = 'Alteração de E-mail';
        $mail->addEmbeddedImage('../../../public/img/logo-img.png', 'logo-img');
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
