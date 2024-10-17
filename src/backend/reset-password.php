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
            $codeReset = rand(100000, 999999);



            $retorna = ['status' => true, 'msg' => "Login bem-sucedido!"];
            header('Content-Type: application/json');
            echo json_encode($retorna);
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
