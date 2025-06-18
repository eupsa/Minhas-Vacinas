<?php
require '../../../vendor/autoload.php';
require '../../scripts/Conexao.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));

if (empty($email)) {
    $retorna = ['status' => false, 'msg' => "Todos os campos devem ser preenchidos."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    try {
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $usuario = $sql->fetch(PDO::FETCH_BOTH);
            $nome = $usuario['nome'];
            $id_usuario = $usuario['id_usuario'];

            $token = bin2hex(random_bytes(50));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $sql = $pdo->prepare("INSERT INTO esqueceu_senha (email, token, data_expiracao, id_usuario) VALUES (:email, :token, :data_expiracao, :id_usuario)");
            $sql->bindValue(':email', $email);
            $sql->bindValue(':token', $token);
            $sql->bindValue(':data_expiracao', $expiry);
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();

            enviarEmail($email, $token);
            $retorna = ['status' => true, 'msg' => "Um e-mail foi enviado com um link para alteração da senha."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        } else {
            $retorna = ['status' => false, 'msg' => "O usuário informado não foi encontrado em nosso sistema."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    } catch (PDOException $e) {
        // $retorna = ['status' => false, 'msg' => "Erro ao logar: " . $e->getMessage()];
        $retorna = ['status' => false, 'msg' => "Erro. Tente novamente mais tarde ou contacte o suporte."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

function enviarEmail($email, $token)
{
    $email_body = file_get_contents('../../../assets/email/esqueceu-senha.html');
    $email_body = str_replace('{{token}}', $token, $email_body);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['HOST_SMTP'];
        $mail->SMTPAuth = true;
        $mail->Username =  $_ENV['EMAIL'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom($_ENV['EMAIL'], 'Minhas Vacinas');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Redefinição de Senha ';
        $mail->addEmbeddedImage('../../../assets/img/logo-img.png', 'logo-img');
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
