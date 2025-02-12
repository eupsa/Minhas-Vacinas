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
                $_SESSION['session_email'] = $email;
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
    // Carrega o conteúdo do template HTML
    $email_body = file_get_contents('../../../assets/email/novo-email.html');

    // Instancia o PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nao.responder@minhasvacinas.online';
        $mail->Password = 'JE1+ip-PWMZvy-4x'; // Use uma senha de app
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurações do remetente e destinatário
        $mail->setFrom('nao.responder@minhasvacinas.online', 'Minhas Vacinas');
        $mail->addAddress($email);

        // Configurações de HTML e charset
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'E-mail alterado com sucesso!';

        // Adiciona a imagem como anexo embutido (CID)
        $mail->addEmbeddedImage('../../../assets/img/logo-img.png', 'logo-img'); // Caminho da imagem e identificador CID

        // Substitui o marcador {{logo_img}} no corpo do e-mail pelo CID
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);

        // Define o corpo do e-mail
        $mail->Body = $email_body;

        // Envia o e-mail
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
