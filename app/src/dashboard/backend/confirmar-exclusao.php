<?php
session_start();
require_once __DIR__ . '../../../libs/autoload.php';
require_once '../../utils/ConexaoDB.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id_usuario = $_SESSION['user_id'];
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

            $sql = $pdo->prepare("DELETE FROM usuario_google WHERE id_usuario = :id_usuario");
            $sql->bindValue(':id_usuario', $id_usuario);
            $sql->execute();

            enviarEmail($email);
            $_SESSION = [];
            $retorna = [
                'status' => true,
                'msg' => "A sua conta foi excluída com sucesso. Todos os dados associados a ela foram removidos permanentemente."
            ];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
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
    $email_body = file_get_contents('../../../public/email/confirmar-exclusao.html');
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
        $mail->Subject = 'Sua conta foi excluída';
        $mail->addEmbeddedImage('../../../public/img/logo-img.png', 'logo-img');
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
