<?php
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../vendor/autoload.php';
require '../backend/scripts/conn.php';
require '../backend/scripts/const.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Google_Client;

// Recebe o token de ID do Google enviado via POST
$data = json_decode(file_get_contents('php://input'), true);
$id_token = $data['id_token'] ?? null;

if (!$id_token) {
    $response = ['status' => false, 'msg' => "Token de ID não fornecido."];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Inicializa o cliente do Google
$client = new Google_Client();
$client->setClientId('1012019764396-mqup55sj8cd77v795ea6v9ak8nhkkak2.apps.googleusercontent.com');
$payload = $client->verifyIdToken($id_token);

if ($payload) {
    $nome = $payload['name'];
    $email = $payload['email'];

    try {
        // Verifica se o e-mail já está registrado
        $sql = $pdo->prepare("SELECT id FROM usuario WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            // Usuário já registrado
            $response = ['status' => true, 'msg' => "Login realizado com sucesso!"];
        } else {
            // Novo usuário - registra no banco
            $sql = $pdo->prepare("INSERT INTO usuario (nome, email) VALUES (:nome, :email)");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                enviarEmail($nome, $email);
                $response = ['status' => true, 'msg' => "Cadastro realizado com sucesso! Um e-mail de confirmação foi enviado."];
            } else {
                $response = ['status' => false, 'msg' => "Erro ao registrar o usuário."];
            }
        }
    } catch (PDOException $e) {
        $response = ['status' => false, 'msg' => "Erro ao acessar o banco de dados."];
    }
} else {
    $response = ['status' => false, 'msg' => "Token de ID inválido."];
}

// Retorna a resposta em JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();

// Função para enviar o e-mail de boas-vindas
function enviarEmail($nome, $email)
{
    $email_body = file_get_contents('../../assets/templates/email_register.php');
    $email_body = str_replace('{{nome}}', $nome, $email_body);
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
        $mail->setFrom('equipevaccilife@gmail.com', 'Bem-Vindo ao Vacinas!');
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
