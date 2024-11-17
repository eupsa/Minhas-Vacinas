<?php
require '../../../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../../../vendor/autoload.php';
require '../../../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<div id='alerta' class='alert alert-$alertType alert-dismissible fade show' role='alert'>
<strong>$alertMessage</strong>
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";


$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = strtolower(trim($dados['nome']));
$email = filter_var(strtolower(trim($dados['email'])), FILTER_SANITIZE_EMAIL);
$estado = trim($dados['estado']);
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];

if (empty($nome) || empty($email) || empty($estado) || empty($senha) || empty($confsenha) || empty($email)) {
    $retorna = ['status' => false, 'msg' => "Todos os campos obrigatórios devem ser preenchidos."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if ($senha !== $confsenha) {
    $retorna = ['status' => false, 'msg' => "As senhas precisam ser iguais."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $sql_check = $pdo->prepare("SELECT id FROM usuario WHERE email = :email");
    $sql_check->bindValue(':email', $email);
    $sql_check->execute();

    if ($sql_check->rowCount() > 0) {
        $retorna = [
            'status' => false,
            'msg' => "Este e-mail já está registrado. <a href=https://auth.minhasvacinas.online/entrar'>Faça login aqui</a>"
        ];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }

    $sql = $pdo->prepare("INSERT INTO usuario (nome, email, estado, senha) VALUES (:nome, :email, :estado, :senha)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':senha', $senhaHash);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        if (email_cadastro($nome, $email)) {
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

function email_cadastro($nome, $email)
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
