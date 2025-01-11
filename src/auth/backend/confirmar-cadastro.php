<?php
session_start();
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';
require '../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$codigo = strtolower(trim($dados['codigo']));

if (empty($codigo)) {
    $retorna = ['status' => false, 'msg' => "O código não foi inserido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    try {
        $sql = $pdo->prepare("SELECT * FROM confirmar_cadastro WHERE codigo = :codigo");
        $sql->bindValue(':codigo', $codigo);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $usuario = $sql->fetch(PDO::FETCH_BOTH);
            $nome = $usuario['nome'];
            $email = $usuario['email'];
            $sql = $pdo->prepare("UPDATE usuario SET email_conf = 1 WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                enviarEmail($nome, $email);
                $sql = $pdo->prepare("DELETE FROM confirmar_cadastro WHERE email = :email");
                $sql->bindValue(':email', $email);
                $sql->execute();

                $retorna = ['status' => true, 'msg' => "Seu e-mail foi verificado. Agora você pode acessar todos os recursos da plataforma."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                $_SESSION = [];
                session_destroy();
                exit();
            } else {
                $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar confirmar seu cadastro. Tente novamente."];
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
    } catch (PDOException $e) {
        $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar confirmar seu cadastro."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

function enviarEmail($email)
{
    $email_body = file_get_contents('../../../assets/email/cadastro-confirmado.html');
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
        $mail->Subject = 'Parabéns! Seu Cadastro Está Confirmado!';
        $mail->Body = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
