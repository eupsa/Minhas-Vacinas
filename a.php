<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Certifique-se de que o PHPMailer está instalado via Composer

// Conectar ao banco de dados
$pdo = new PDO('mysql:host=136.248.69.97;dbname=minhasvacinas', 'root', 'Chicote1@');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Buscar todos os e-mails dos usuários registrados
$query = $pdo->query("SELECT email FROM novidades");
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

// Configuração do e-mail
$subject = "Atualização sobre Instabilidades Recentes no Minhas Vacinas";
$body = '
    <p><strong>Olá,</strong></p>
    <p>Identificamos que alguns usuários podem ter encontrado instabilidades ao acessar o <strong>Minhas Vacinas</strong> recentemente. Pedimos desculpas por qualquer inconveniente e queremos garantir que nossa equipe trabalhou rapidamente para resolver a situação.</p>
    <p>O acesso ao sistema já foi restabelecido e estamos monitorando de perto para evitar novas ocorrências. Se você ainda enfrentar algum problema, por favor, entre em contato conosco.</p>
    <p><a href="https://www.minhasvacinas.online/src/ajuda/" style="display:inline-block;padding:10px 20px;background:#007bff;color:#fff;text-decoration:none;border-radius:5px;">Acessar Suporte</a></p>
    <p>Agradecemos sua compreensão e confiança!</p>
    <p>Atenciosamente,<br>Equipe Minhas Vacinas</p>
';

// Enviar e-mails
foreach ($usuarios as $usuario) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nao.responder@minhasvacinas.online';
        $mail->Password = 'JE1+ip-PWMZvy-4x';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('nao.responder@minhasvacinas.online', 'Minhas Vacinas');
        $mail->addAddress($usuario['email']);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
    } catch (Exception $e) {
        error_log("Erro ao enviar e-mail para " . $usuario['email'] . ": " . $mail->ErrorInfo);
    }
}
?>
