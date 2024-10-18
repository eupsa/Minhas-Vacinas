<?php
require '../../vendor\phpmailer\phpmailer\src\PHPMailer.php';
require '../../vendor\phpmailer\phpmailer\src\Exception.php';
require '../../vendor\phpmailer\phpmailer\src\SMTP.php';
require '../../vendor\autoload.php';
require '../backend/scripts/conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$nome = strtolower(trim($dados['nome']));
$email = strtolower(trim($dados['email']));
$estado = trim($dados['estado']);
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];

if (empty($nome) || empty($email) || empty($estado) || empty($senha) || empty($confsenha)) {
    $retorna = ['status' => false, 'msg' => "Preencha todos os campos"];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if ($senha === $confsenha) {
    try {
        $senhaHash = hash('sha256', $senha);
        $sql = $pdo->prepare("INSERT INTO usuario (nome, email, estado, senha) VALUES (:nome, :email, :estado, :senha)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':estado', $estado);
        $sql->bindValue(':senha', $senhaHash);
        $sql->execute();

        if ($sql->rowCount()) {
            enviarEmail($nome, $email);
            $retorna = ['status' => true, 'msg' => "Usuário cadastrado com sucesso!"];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    } catch (PDOException $e) {
        $retorna = ['status' => false, 'msg' => "Erro ao cadastrar: " . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit;
    }
} else {
    $retorna = ['status' => false, 'msg' => "As senhas precisam ser iguais."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit;
}

function enviarEmail($nome, $email)
{
    $email_body = file_get_contents('../../assets/templates/tempRegister.php');

    $action_url = 'apple.com';
    $email_body = str_replace('{{nome}}', $nome, $email_body);
    $email_body = str_replace('{{email}}', $email, $email_body);
    $email_body = str_replace('{{action_url}}', $action_url, $email_body);
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
