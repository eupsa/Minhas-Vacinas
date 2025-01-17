<?php
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$nome = strtolower(trim($dados['suporte_nome']));
$email = strtolower(trim($dados['suporte_email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$mensagem = trim($dados['mensagem']);
$motivo_contato = trim($dados['motivo_contato']);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (empty($nome) || empty($email) || empty($mensagem) || empty($motivo_contato)) {
        $retorna = ['status' => false, 'msg' => "Todos os campos devem ser preenchidos."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        try {
            $email_body = "
            <html>
            <head>
                <title>Mensagem de Suporte</title>
            </head>
            <body>
                <h2>Mensagem de Suporte</h2>
                <p><strong>Nome:</strong> {$nome}</p>
                <p><strong>E-mail:</strong> {$email}</p>
                <p><strong>Motivo do Contato:</strong> {$motivo_contato}</p> <!-- Adicionando motivo -->
                <p><strong>Mensagem:</strong></p>
                <p>{$mensagem}</p>
            </body>
            </html>
            ";

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.zoho.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'contato@minhasvacinas.online';
                $mail->Password = 'H;H6<j$Vp<wd;AgA';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('contato@minhasvacinas.online', 'Suporte Vacinas');
                $mail->addAddress('minhasvacinas@hotmail.com');
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Nova Mensagem de Suporte';
                $mail->Body = $email_body;
                $mail->send();

                $retorna = ['status' => true, 'msg' => "E-mail enviado com sucesso! Responderemos sua mensagem o mais rápido possível."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            } catch (Exception $e) {
                $retorna = ['status' => false, 'msg' => "Erro ao enviar o email: {$mail->ErrorInfo}"];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            }
        } catch (Exception $e) {
            $retorna = ['status' => false, 'msg' => "Erro ao processar a mensagem."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    }
} else {
    $retorna = ['status' => false, 'msg' => "E-mail fornecido é inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}
