<?php
require '../../../../libs/autoload.php';
require '../../utils/ConexaoDB.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
$dotenv->load();

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
            $sql = $pdo->prepare("INSERT INTO suporte (nome_usuario, email_usuario, motivo_contato, mensagem) VALUES (:nome_usuario, :email_usuario, :motivo_contato, :mensagem)");
            $sql->bindValue(':nome_usuario', $nome);
            $sql->bindValue(':email_usuario', $email);
            $sql->bindValue(':motivo_contato', $motivo_contato);
            $sql->bindValue(':mensagem', $mensagem);
            $sql->execute();

            $email_body = "
            <html>
            <head>
                <title>Mensagem de Suporte</title>
            </head>
            <body>
                <h2>Mensagem de Suporte</h2>
                <p><strong>Nome:</strong> {$nome}</p>
                <p><strong>E-mail:</strong> {$email}</p>
                <p><strong>Motivo do Contato:</strong> {$motivo_contato}</p>
                <p><strong>Mensagem:</strong></p>
                <p>{$mensagem}</p>
            </body>
            </html>
            ";

            $mail = new PHPMailer(true);
            try {
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = $_ENV['MAIL_HOST'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['MAIL_USERNAME'];
                $mail->Password = $_ENV['MAIL_PASSWORD'];
                $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = isset($_ENV['MAIL_PORT']) ? (int)$_ENV['MAIL_PORT'] : 587;

                $mail->setFrom($_ENV['MAIL_USERNAME'], 'Suporte Vacinas');
                $mail->addAddress('pedro.s.araujo291@gmail.com');
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
