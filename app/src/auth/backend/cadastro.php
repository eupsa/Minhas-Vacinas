<?php
require_once '../../utils/ConexaoDB.php';
require_once __DIR__ . '../../../../../libs/autoload.php';
require_once '../../utils/NovoDispositivo.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = ucwords($dados['nome']);
$email = filter_var(strtolower(trim($dados['email'])), FILTER_SANITIZE_EMAIL);
$estado = trim($dados['estado']);
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];
$retorna = [];

$estados = [
    'AC',
    'AL',
    'AP',
    'AM',
    'BA',
    'CE',
    'DF',
    'ES',
    'GO',
    'MA',
    'MT',
    'MS',
    'MG',
    'PA',
    'PB',
    'PR',
    'PE',
    'PI',
    'RJ',
    'RN',
    'RS',
    'RO',
    'RR',
    'SC',
    'SP',
    'SE',
    'TO'
];



if (empty($nome) || empty($email) || empty($estado) || empty($senha) || empty($confsenha) || empty($email)) {
    $retorna = ['status' => false, 'msg' => "Você não preencheu todos os campos obrigatórios. Por favor, revise e envie novamente."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (preg_match('/\d/', $nome)) {
    $retorna = ['status' => false, 'msg' => "O nome não pode conter números."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $retorna = ['status' => false, 'msg' => "E-mail fornecido é inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if ($senha !== $confsenha) {
    $retorna = ['status' => false, 'msg' => "A senha não corresponde. Verifique e tente novamente."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (!in_array($estado, $estados)) {
    $retorna = ['status' => false, 'msg' => "A sigla do estado é inválida. Por favor, atualize a página."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
$sql->bindValue(':email', $email);
$sql->execute();

if ($sql->rowCount() > 0) {
    $retorna = ['status' => false, 'msg' => "E-mail já cadastrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

try {
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = $pdo->prepare("INSERT INTO usuario (nome, email, estado, senha) VALUES (:nome, :email, :estado, :senha)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':senha', $senhaHash);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        $id_usuario = $pdo->lastInsertId();
        $ip = RegistrarDispostivos($pdo, $id_usuario);

        $sql = $pdo->prepare("UPDATE usuario SET ip_cadastro = :ip_cadastro WHERE id_usuario = :id_usuario");
        $sql->bindValue(':ip_cadastro', $ip);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->execute();

        $codigo = rand(100000, 999999);
        $sql = $pdo->prepare("INSERT INTO confirmar_cadastro (email, codigo) VALUES (:email, :codigo)");
        $sql->bindValue(':email', $email);
        $sql->bindValue(':codigo', $codigo);
        $sql->execute();

        if (email_cadastro($email, $codigo)) {
            $retorna = ['status' => true, 'msg' => "Sua conta foi criada. Um e-mail foi enviado com um código de verificação. Siga as instruções na página a seguir."];
            session_start();
        } else {
            // $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar cadastrar o usuário: " . $e->getMessage()];
            $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar cadastrar o usuário."];
        }
    } else {
        $retorna = ['status' => false, 'msg' => "Erro ao cadastrar usuário. Tente novamente."];
    }
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar cadastrar o usuário."];
    // $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar cadastrar o usuário: " . $e->getMessage()];
} finally {
    echo json_encode($retorna);
    exit();
}

function email_cadastro($email, $codigo)
{
    $email_body = file_get_contents('../../../public/email/cadastro.html');
    $email_body = str_replace('{{code}}', $codigo, $email_body);

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
        $mail->Subject = 'Confirmação de Cadastro';
        $mail->Body = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
