<?php
require '../backend/scripts/conn.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$nome = strtolower(trim($dados['suporteNome'])); // Nome do campo
$email = strtolower(trim($dados['suporteEmail'])); // E-mail do campo
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$mensagem = trim($dados['mensagem']); // Mensagem do suporte
$data = trim($dados['data']); // Capturando a data

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (empty($nome) || empty($email) || empty($mensagem) || empty($data)) {
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
                <p><strong>Data:</strong> {$data}</p>
                <p><strong>Mensagem:</strong></p>
                <p>{$mensagem}</p>
            </body>
            </html>
            ";

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'pedrooosxz@gmail.com'; // Seu e-mail
                $mail->Password = 'lbfn mois wxon hbxo'; // Sua senha
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('pedrooosxz@gmail.com', 'Suporte Vacinas!'); // De
                $mail->addAddress('equipevaccilife@gmail.com'); // Para
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Nova Mensagem de Suporte';
                $mail->Body = $email_body;
                $mail->send();

                $retorna = ['status' => true, 'msg' => "Email enviado com sucesso! Em até 48 horas, entraremos em contato."];
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
