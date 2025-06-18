<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';

    $mail->isSMTP();
    $mail->Host = 'mail.braintech.app.br';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@braintech.app.br'; // E-mail completo
    $mail->Password = 'domain0258@'; // Verifique se está correto
    $mail->SMTPSecure = 'tls'; // ou 'tls'
    $mail->Port = 587; // 465 para ssl, 587 para tls

    $mail->setFrom('noreply@braintech.app.br', 'BrainTech');
    $mail->addAddress('pedrooosxz@gmail.com', 'Pedro');

    $mail->isHTML(true);
    $mail->Subject = 'Teste de envio com Titan';
    $mail->Body    = '<strong>Mensagem enviada com sucesso via Titan SMTP</strong>';
    $mail->AltBody = 'Mensagem alternativa em texto puro';

    $mail->send();
    echo 'E-mail enviado com sucesso.';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
