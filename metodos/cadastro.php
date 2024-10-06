<?php
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/SMTP.php';
require '../vendor/autoload.php';
require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$nome = $_POST['nome'];
$email = $_POST['email'];
$estado = $_POST['estado'];
$senha = $_POST['senha'];
$confsenha = $_POST['confSenha'];

enviarEmail($nome, $email);

try {
    $senhaHash = hash('sha256', $senha);

    $sql = $pdo->prepare("INSERT INTO usuarios (nome, email, estado, senha) VALUES (:nome, :email, :estado, :senha)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':senha', $senhaHash);
    $sql->execute();

    if ($sql->execute() == true) {
        enviarEmail($nome, $email);
        header("Location: ../index.html");
        exit;
    }
} catch (PDOException $e) {
    // Capturando erros específicos
    switch ($e->getCode()) {
        case 23000: // Duplicidade de entrada
            echo "Esse e-mail já está cadastrado. Por favor, use um e-mail diferente.";
            break;
        case 42000: // Erro de sintaxe SQL
            echo "Erro no banco de dados. Por favor, tente novamente mais tarde.";
            break; // Erro de conexão
            //case 08004:
            //echo "Não foi possível conectar ao banco de dados. Por favor, verifique a conexão.";
            //break;
        case 22007: // Formato de dados inválido
            echo "Formato de dados inválido. Por favor, verifique os campos e tente novamente.";
            break;
        default: // Mensagem genérica para outros erros
            echo "Erro ao cadastrar: " . $e->getMessage();
    }
}

function enviarEmail($nome, $email)
{

    $email_body = file_get_contents('../PHPMailer/src/templates/cadastro.html');

    $action_url = 'apple.com';
    $email_body = str_replace('{{nome}}', $nome, $email_body);
    $email_body = str_replace('{{email}}', $email, $email_body);
    $email_body = str_replace('{{action_url}}', $action_url, $email_body);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pedrooosxz@gmail.com'; // Usuário de e-mail
        $mail->Password = 'zolp wzgo pvcr ucpb'; // senha
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurações do remetente e destinatário
        $mail->setFrom('pedrooosxz@gmail.com', 'php bonito');
        $mail->addAddress($email); // E-mail do destinatário

        // Conteúdo do e-mail
        $mail->isHTML(true); // Enviar como HTML
        $mail->Subject = 'hmmm php';
        $mail->Body = $email_body;
        $mail->AltBody = 'Este é o corpo do e-mail em texto plano, para clientes de e-mail sem suporte a HTML';
        $mail->send();

        echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
