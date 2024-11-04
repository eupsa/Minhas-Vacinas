<?php
require '../../vendor\phpmailer\phpmailer\src\PHPMailer.php';
require '../../vendor\phpmailer\phpmailer\src\Exception.php';
require '../../vendor\phpmailer\phpmailer\src\SMTP.php';
require '../../vendor\autoload.php';
require '../backend/scripts/conn.php';
require '../backend/scripts/const.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = ucwords(strtolower(trim($dados['nome'])));
$email = strtolower(trim($dados['email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$estado = trim($dados['estado']);
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];


function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) $d += $cpf[$c] * (($t + 1) - $c);
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }
    return true;
}

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = ucwords(strtolower(trim($dados['nome'])));
$email = strtolower(trim($dados['email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$estado = trim($dados['estado']);
$cpf = $dados['cpf'];
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];

if (!validarCPF($cpf)) {
    $retorna = ['status' => false, 'msg' => "CPF inválido"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (empty($nome) || empty($email) || empty($estado) || empty($cpf) || empty($senha) || empty($confsenha)) {
        $retorna = ['status' => false, 'msg' => "Preencha todos os campos"];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } elseif ($senha === $confsenha) {
        try {
            $senhaHash = hash('sha256', $senha);
            $sql = $pdo->prepare("INSERT INTO usuario (nome, email, estado, cpf, senha) VALUES (:nome, :email, :estado, :cpf, :senha)");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':estado', $estado);
            $sql->bindValue(':cpf', $cpf);
            $sql->bindValue(':senha', $senhaHash);
            $sql->execute();

            if ($sql->rowCount() ===  1) {
                enviarEmail($nome, $email);
                $retorna = ['status' => true, 'msg' => "Seu cadastro foi realizado com sucesso! Enviamos um e-mail para confirmação do cadastro!"];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit;
            }
        } catch (PDOException $e) {
            // Erros específicos do PDO
        }
    } else {
        $retorna = ['status' => false, 'msg' => "As senhas precisam ser iguais."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
} else {
    $retorna = ['status' => false, 'msg' => "E-mail fornecido é inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}


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
