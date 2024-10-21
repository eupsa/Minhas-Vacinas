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
$nome = strtolower(trim($dados['nome']));
$email = strtolower(trim($dados['email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$estado = trim($dados['estado']);
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (empty($nome) || empty($email) || empty($estado) || empty($senha) || empty($confsenha)) {
        $retorna = ['status' => false, 'msg' => "Preencha todos os campos"];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        if ($senha === $confsenha) {
            try {
                $emailConf = bin2hex(random_bytes(50));
                $senhaHash = hash('sha256', $senha);
                $sql = $pdo->prepare("INSERT INTO usuario (nome, email, estado, senha, emailConf) VALUES (:nome, :email, :estado, :senha, :emailConf)");
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':email', $email);
                $sql->bindValue(':estado', $estado);
                $sql->bindValue(':senha', $senhaHash);
                $sql->bindValue(':emailConf', $emailConf);
                $sql->execute();

                if ($sql->rowCount() ===  1) {
                    enviarEmail($nome, $email, $emailConf);
                    $retorna = ['status' => true, 'msg' => "Usuário cadastrado com sucesso!"];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit;
                }
            } catch (PDOException $e) {
                switch ($e) {
                    case '23000':
                        $retorna = ['status' => false, 'msg' => "Este e-mail já está registrado. Por favor, tente outro."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                        break;
                    case '42000':
                        $retorna = ['status' => false, 'msg' => "Houve um erro no processamento da sua solicitação. Tente novamente mais tarde."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                        break;
                    case '42S02':
                        $retorna = ['status' => false, 'msg' => "Erro interno: Recurso não encontrado. Tente novamente mais tarde."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                        break;
                    case 'HY000':
                        $retorna = ['status' => false, 'msg' => "Ocorreu um erro inesperado. Por favor, tente novamente mais tarde."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                        break;
                    case '28000':
                        $retorna = ['status' => false, 'msg' => "Erro de acesso ao sistema. Contate o suporte."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                        break;
                    default:
                        $retorna = ['status' => false, 'msg' => "Erro inesperado: Por favor, tente novamente mais tarde."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                        break;
                }
            }
        } else {
            $retorna = ['status' => false, 'msg' => "As senhas precisam ser iguais."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    }
} else {
    $retorna = ['status' => false, 'msg' => "E-mail fornecido é inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}


function enviarEmail($nome, $email, $emailConf)
{
    $email_body = file_get_contents('../../assets/templates/email_register.php');
    $action_url = $emailConf;
    $email_body = str_replace('{{nome}}', $nome, $email_body);
    $email_body = str_replace('{{email}}', $email, $email_body);
    $email_body = str_replace('{{action_url}}', $action_url, $email_body);
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
