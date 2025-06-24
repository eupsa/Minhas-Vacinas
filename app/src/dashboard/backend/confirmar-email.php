<?php
session_start();
require_once __DIR__ . '/../../../../libs/autoload.php';
require_once '../../utils/ConexaoDB.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$codigo = strtolower(trim($_POST['codigo']));

if (empty($codigo)) {
    $retorna = ['status' => false, 'msg' => "O código não foi inserido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if ($codigo == $_SESSION['temp_codigo']) {
    $sql = $pdo->prepare("UPDATE usuario SET email = :email WHERE id_usuario = :id_usuario");
    $sql->bindValue(':email', $_SESSION['temp_email']);
    $sql->bindValue(':id_usuario', $_SESSION['user_id']);

    if ($sql->execute()) {
        $sql = $pdo->prepare("DELETE FROM mudar_email WHERE id_usuario = :id_usuario");
        $sql->bindValue(':id_usuario', $_SESSION['user_id']);
        $sql->execute();

        EnviarEmail($email);
        $_SESSION['user_id'] = $email;
        $retorna = ['status' => true, 'msg' => "E-mail alterado e verificado com sucesso."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar atualizar seu e-mail. Tente novamente."];
        // $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar confirmar seu cadastro:" . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
} else {
    $retorna = ['status' => false, 'msg' => "O código está incorreto. Confira e tente novamente."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function EnviarEmail($email)
{
    $email_body = file_get_contents('../../../public/email/novo-email.html');
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = isset($_ENV['MAIL_PORT']) ? (int)$_ENV['MAIL_PORT'] : 587;
        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Minhas Vacinas');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'E-mail alterado com sucesso!';
        $mail->addEmbeddedImage('../../../public/img/logo-img.png', 'logo-img');
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
