<?php
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';
require '../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = filter_var(strtolower(trim($dados['email'])), FILTER_SANITIZE_EMAIL);
$code_email = $dados['code_email'] ?? '';


if (!empty($code_email)) {
    $sql = $pdo->prepare("DELETE FROM usuario WHERE email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();

    $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if ($sql->rowCount() === 0) {
        $retorna = ['status' => false, 'msg' => "exclui"];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
} else {
    if (empty($email)) {
        $retorna = ['status' => false, 'msg' => "É necessário preencher o campo e-mail."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        try {
            $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                $code_email = rand(100000, 999999);
                $sql = $pdo->prepare("INSERT INTO excluir_conta (code_email, email) VALUES (:code_email, :email)");
                $sql->bindValue(':code_email', $code_email);
                $sql->bindValue(':email', $email);
                $sql->execute();

                if ($sql->rowCount() === 1) {
                    if (email_excluir_conta($email, $code_email)) {
                        $retorna = ['status' => true, 'msg' => "Um e-mail com um código foi enviado com sucesso!"];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit();
                    } else {
                        $retorna = ['status' => false, 'msg' => "O e-mail não pode ser enviado."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit();
                    }
                } else {
                    $retorna = ['status' => false, 'msg' => "Nenhum cadastro encontrado."];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit();
                }
            } else {
                $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar fazer o login: " . $e->getMessage()];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            }
        } catch (PDOException $e) {
            $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar fazer o login: "];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    }
}


function email_excluir_conta($email, $code_email)
{
    $email_body = file_get_contents('../../../assets/email/excluir-conta.php');
    $email_body = str_replace('{{code_email}}', $code_email, $email_body);
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
