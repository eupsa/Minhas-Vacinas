<?php
require '../../vendor\phpmailer\phpmailer\src\PHPMailer.php';
require '../../vendor\phpmailer\phpmailer\src\Exception.php';
require '../../vendor\phpmailer\phpmailer\src\SMTP.php';
require '../../vendor\autoload.php';
require '../backend/scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));

if (empty($email)) {
    $retorna = ['status' => false, 'msg' => "Por favor, complete todos os campos."];
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
            $sql = $pdo->prepare("INSERT INTO redefinicaoSenha (email, token, dataExpiracao) VALUES (:email, :token, :dataExpiracao)");
            $sql->bindValue(':email', $email);
            $sql->bindValue(':token', $token);
            $sql->bindValue(':dataExpiracao', $expiry);
            $sql->execute();
            enviarEmail($nome, $email, $token);
            $retorna = ['status' => true, 'msg' => "enviou"];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        } else {
            $retorna = ['status' => false, 'msg' => "Usuário não encontrado."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    } catch (PDOException $e) {
        $retorna = ['status' => false, 'msg' => "Erro ao logar: " . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

function enviarEmail($nome, $email, $token)
{
    $email_body = file_get_contents('../../assets/templates/email_forgot_password.php');
    $email_body = str_replace('{{nome}}', $nome, $email_body);
    $email_body = str_replace('{{token}}', $token, $email_body);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pedrooosxz@gmail.com';
        $mail->Password = 'zolp wzgo pvcr ucpb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('pedrooosxz@gmail.com', 'muda senha poha');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'ivadiru';
        $mail->Body = $email_body;
        $mail->AltBody = 'Este é o corpo do e-mail em texto plano, para clientes de e-mail sem suporte a HTML';
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
