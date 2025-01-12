<?php
require '../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../vendor/autoload.php';
require '../../scripts/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$nome = ucwords(trim($dados['nome']));
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

if (preg_match('/\d/', $nome)) {
    $retorna = ['status' => false, 'msg' => "O nome não pode conter números."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (empty($nome) || empty($email) || empty($estado) || empty($senha) || empty($confsenha) || empty($email)) {
    $retorna = ['status' => false, 'msg' => "Você não preencheu todos os campos obrigatórios. Por favor, revise e envie novamente."];
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
    $retorna = ['status' => false, 'msg' => "A sigla do estado é inválida. Por favor atualiza a página."];
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
        $codigo = rand(100000, 999999);
        $sql = $pdo->prepare("INSERT INTO confirmar_cadastro (nome, email, codigo) VALUES (:nome, :email, :codigo)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':codigo', $codigo);
        $sql->execute();

        if (email_cadastro($email, $codigo)) {
            $retorna = ['status' => true, 'msg' => "Sua conta foi criada. Um e-mail foi enviado com um código de verificação. Siga as instruções na página a seguir."];
            session_start();
            $_SESSION['temp-cad'] = $email;
        } else {
            $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar cadastrar o usuário: " . $e->getMessage()];
        }
    } else {
        $retorna = ['status' => false, 'msg' => "Erro ao cadastrar usuário. Tente novamente."];
    }
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar cadastrar o usuário: " . $e->getMessage()];
} finally {
    echo json_encode($retorna);
    exit();
}

function email_cadastro($email, $codigo)
{
    // Carrega o conteúdo do template HTML
    $email_body = file_get_contents('../../../assets/email/cadastro.html');

    // Substitui o marcador {{code}} pelo código de verificação
    $email_body = str_replace('{{code}}', $codigo, $email_body);

    // Instancia o PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'equipevaccilife@gmail.com';
        $mail->Password = 'sfii esho quah qkjd'; // Use uma senha de app
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurações do remetente e destinatário
        $mail->setFrom('equipevaccilife@gmail.com', 'Minhas Vacinas');
        $mail->addAddress($email);

        // Configurações de HTML e charset
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Confirmação de Cadastro';

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
