<?php
session_start();
require_once __DIR__ . '../../../libs/autoload.php';
require_once '../../utils/ConexaoDB.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
$dotenv->load();

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
        $sql = $pdo->prepare("SELECT * FROM mudar_email WHERE codigo = :codigo");
        $sql->bindValue(':codigo', $codigo);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $usuario = $sql->fetch(PDO::FETCH_BOTH);
            $id_usuario = $usuario['id_usuario'];
            $email = $usuario['email'];
            $sql = $pdo->prepare("UPDATE usuario SET email = :email WHERE id_usuario = :id_usuario");
            $sql->bindValue(':email', $email);
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                $sql = $pdo->prepare("DELETE FROM mudar_email WHERE id_usuario = :id_usuario");
                $sql->bindValue(':id_usuario', $id_usuario);
                $sql->execute();

                enviarEmail($email);
                $_SESSION['user_id'] = $email;
                $retorna = ['status' => true, 'msg' => "E-mail alterado e verificado com sucesso."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
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
        $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar confirmar seu cadastro:" . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

function enviarEmail($email)
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
