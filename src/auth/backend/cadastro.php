<?php
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';
require '../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = strtolower(trim($dados['nome']));
$email = filter_var(strtolower(trim($dados['email'])), FILTER_SANITIZE_EMAIL);
$estado = trim($dados['estado']);
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];

if (empty($nome) || empty($email) || empty($estado) || empty($senha) || empty($confsenha) || empty($email)) {
    $retorna = ['status' => false, 'msg' => "Você não preencheu todos os campos obrigatórios. Por favor, revise e envie novamente."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if ($senha !== $confsenha) {
    $retorna = ['status' => false, 'msg' => "A senha não corresponde. Verifique e tente novamente."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

try {
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = $pdo->prepare("INSERT INTO usuario (nome, email, estado, senha) VALUES (:nome, :email, :estado, :senha)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':senha', $senhaHash);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        if (email_cadastro($nome, $email)) {
            $retorna = ['status' => true, 'msg' => "Cadastro realizado. E-mail de confirmação enviado. Verifique sua caixa de entrada para concluir o processo."];
        } else {
            $retorna = ['status' => false, 'msg' => "Cadastro realizado, mas não foi possível enviar o e-mail de confirmação."];
        }
    } else {
        $retorna = ['status' => false, 'msg' => "Erro ao cadastrar usuário. Tente novamente."];
    }
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "O cadastro não pôde ser concluído. Verifique os dados e tente novamente."];
} finally {
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function email_cadastro($nome, $email)
{
    $email_body = file_get_contents('../../../assets/email/cadastro.php');
    $email_body = str_replace('{{nome}}', $nome, $email_body);
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
