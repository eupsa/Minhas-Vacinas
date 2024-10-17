<?php
require '../../vendor\phpmailer\phpmailer\src\PHPMailer.php';
require '../../vendor\phpmailer\phpmailer\src\Exception.php';
require '../../vendor\phpmailer\phpmailer\src\SMTP.php';
require '../../vendor\autoload.php';
require '../backend/scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));

if (empty($email)) {
    $retorna = ['status' => false, 'msg' => "Preencha todos os campos"];
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
            $codeReset = rand(100000, 999999);
            enviarEmail($nome, $email, $codeReset);
            // $retorna = ['status' => true, 'msg' => "Login bem-sucedido!"];
            // header('Content-Type: application/json');
            // echo json_encode($retorna);
        } else {
            $retorna = ['status' => false, 'msg' => "Usuário ou senha incorretos."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    } catch (PDOException $e) {
        $retorna = ['status' => false, 'msg' => "Erro ao logar: " . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

function enviarEmail($nome, $email, $codeReset)
{
    $email_body = file_get_contents('../../assets/templates/register.php');
    $email_body = str_replace('{{nome}}', $nome, $email_body);
    $email_body = str_replace('{{codeReset}}', $codeReset, $email_body);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pedrooosxz@gmail.com';
        $mail->Password = 'zolp wzgo pvcr ucpb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('pedrooosxz@gmail.com', 'php bonito');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'hmmm php';
        $mail->Body = $email_body;
        $mail->AltBody = 'Este é o corpo do e-mail em texto plano, para clientes de e-mail sem suporte a HTML';

        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
