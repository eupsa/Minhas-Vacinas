<?php
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../vendor/autoload.php';
require '../backend/scripts/conn.php';
require '../backend/scripts/const.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configurações do Cloudflare Turnstile
$turnstile_secret = '0x4AAAAAAAzf0YMx_HyfyUuqEIU52lNhz-I';
$turnstile_response = $_POST['cf-turnstile-response'] ?? '';

// Verificação do Turnstile
$response = file_get_contents("https://challenges.cloudflare.com/turnstile/v0/siteverify?secret=$turnstile_secret&response=$turnstile_response");
$response_keys = json_decode($response, true);

if (!$response_keys['success']) {
    $retorna = ['status' => false, 'msg' => "Verificação de segurança falhou. Tente novamente."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

// Captura e sanitização dos dados de entrada
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = strtolower(trim($dados['nome'] ?? ''));
$email = filter_var(strtolower(trim($dados['email'] ?? '')), FILTER_SANITIZE_EMAIL);
$estado = trim($dados['estado'] ?? '');
$senha = $dados['senha'] ?? '';
$confsenha = $dados['confSenha'] ?? '';

// Verificação de campos obrigatórios e validação de e-mail
if (empty($nome) || empty($email) || empty($estado) || empty($senha) || empty($confsenha) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $retorna = ['status' => false, 'msg' => "Preencha todos os campos corretamente."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

// Verificação de senha
if ($senha !== $confsenha) {
    $retorna = ['status' => false, 'msg' => "As senhas precisam ser iguais."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$senhaHash = hash('sha256', $senha);

try {
    $sql_check = $pdo->prepare("SELECT id FROM usuario WHERE email = :email");
    $sql_check->bindValue(':email', $email);
    $sql_check->execute();

    if ($sql_check->rowCount() > 0) {
        $retorna = ['status' => false, 'msg' => "Este e-mail já está registrado. Por favor, tente outro."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }

    // Insere os dados no banco
    $sql = $pdo->prepare("INSERT INTO usuario (nome, email, estado, senha) VALUES (:nome, :email, :estado, :senha)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':senha', $senhaHash);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        // Envia e-mail de confirmação
        if (enviarEmail($nome, $email)) {
            $retorna = ['status' => true, 'msg' => "Você foi cadastrado com sucesso! Enviamos um e-mail para confirmação do cadastro!"];
        } else {
            $retorna = ['status' => false, 'msg' => "Cadastro realizado, mas não foi possível enviar o e-mail de confirmação."];
        }
    } else {
        $retorna = ['status' => false, 'msg' => "Erro ao cadastrar usuário. Tente novamente."];
    }
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "Erro ao processar sua solicitação. Por favor, tente novamente."];
} finally {
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

// Função para envio de e-mail
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
