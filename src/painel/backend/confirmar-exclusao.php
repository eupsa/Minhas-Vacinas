<?php
session_start();
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';
require '../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id_usuario = $_SESSION['session_id'];
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$codigo = strtolower(trim($dados['codigo']));

if (empty($codigo)) {
    $retorna = ['status' => false, 'msg' => "O código não foi inserido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    try {
        $sql = $pdo->prepare("SELECT * FROM excluir_conta WHERE codigo = :codigo");
        $sql->bindValue(':codigo', $codigo);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $usuario = $sql->fetch(PDO::FETCH_BOTH);
            $email = $usuario['email'];

            $sql = $pdo->prepare("DELETE FROM confirmar_cadastro WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            $sql = $pdo->prepare("DELETE FROM esqueceu_senha WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            $sql = $pdo->prepare("DELETE FROM excluir_conta WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            $sql = $pdo->prepare("DELETE FROM mudar_email WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            $sql = $pdo->prepare("DELETE FROM usuario WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            $sql = $pdo->prepare("DELETE FROM vacina WHERE id_usuario = :id_usuario");
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();


            enviarEmail($email);
            $_SESSION = [];
            session_destroy();
            header('Location: ../../auth/entrar/');
        } else {
            $retorna = ['status' => false, 'msg' => "O código está incorreto. Confira e tente novamente."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    } catch (PDOException $e) {
        // $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar confirmar seu cadastro:" . $e->getMessage()];
        $retorna = ['status' => false, 'msg' => "Ocorreu um erro."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

function enviarEmail($email)
{
    $email_body = file_get_contents('../../../assets/email/confirmar-exclusao.html');
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'equipevaccilife@gmail.com';
        $mail->Password = 'sfii esho quah qkjd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('equipevaccilife@gmail.com', 'Minhas Vacinas');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Sua conta foi excluída';
        $mail->addEmbeddedImage('../../../assets/img/logo-img.png', 'logo-img');
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
