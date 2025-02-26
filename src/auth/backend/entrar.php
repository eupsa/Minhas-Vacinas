<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../../../vendor/autoload.php';
require_once '../../scripts/Conexao.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$senha = $dados['senha'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $retorna = ['status' => false, 'msg' => "E-mail fornecido é inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

if (empty($email) || empty($senha)) {
    $retorna = ['status' => false, 'msg' => "Todos os campos devem ser preenchidos."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email AND email_conf = 1");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        $usuario = $sql->fetch(PDO::FETCH_BOTH);
        if (password_verify($senha, $usuario['senha'])) {
            $id_usuario = $usuario['id_usuario'];
            $ip = ObterIP();

            $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id_usuario = :id AND ip = :ip AND confirmado = 1");
            $sql->bindValue(':id', $id_usuario);
            $sql->bindValue(':ip', $ip);
            $sql->execute();

            if ($sql->rowCount() == 1) {
                $email = $usuario['email'];
                $sql = $pdo->prepare("SELECT chave_secreta FROM 2FA WHERE email = :email");
                $sql->bindValue(':email', $email);
                $sql->execute();

                if ($sql->rowCount() == 1) {
                    $key = $sql->fetch(PDO::FETCH_BOTH);
                    $_SESSION['email-temp'] = $email;
                    $_SESSION['key-temp'] = $key['chave_secreta'];
                    $retorna = ['status' => '2FA', 'msg' => 'Autenticação de dois fatores necessária.'];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit();
                }

                $retorna = ['status' => true, 'msg' => "Bem-vindo à nossa plataforma, " . htmlspecialchars(explode(' ', $usuario['nome'])[0]) . "!"];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                $_SESSION['user_id'] = $usuario['id_usuario'];
                $_SESSION['user_nome'] = $usuario['nome'];
                $_SESSION['user_email'] = $usuario['email'];
                $_SESSION['user_ip'] = $ip;
                exit();
            } else {
                RegistrarDispositivo($pdo, $id_usuario);
                $token = $_ENV['IPINFO_TOKEN'];
                $response = file_get_contents("https://ipinfo.io/{$ip}/json?token={$token}");
                $data = json_decode($response, true);

                if (!isset($data['city']) || !isset($data['region']) || !isset($data['country'])) {
                    $cidade = 'Desconhecida';
                    $estado = 'Desconhecido';
                    $pais = 'Desconhecido';
                } else {
                    $cidade = $data['city'];
                    $estado = $data['region'];
                    $pais = $data['country'];
                }
                EmailLogin($id_usuario, $email, $ip, $cidade, $estado, $pais);
                $retorna = ['status' => true, 'msg' => "Para concluir o login, verifique seu e-mail e clique no link de confirmação. Um e-mail foi enviado com as instruções."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            }
        } else {
            $retorna = ['status' => false, 'msg' => "E-mail ou senha incorretos."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    } else {
        $retorna = ['status' => false, 'msg' => "Usuário não cadastrado ou cadastro não confimado."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}

function EmailLogin($id_usuario, $email, $ip, $cidade, $estado, $pais)
{
    date_default_timezone_set('America/Sao_Paulo');
    $data_local = date('d/m/Y H:i:s');
    $email_body = file_get_contents('../../../assets/email/alerta-login.html');
    $email_body = str_replace('{{ip}}', $ip, $email_body);
    $email_body = str_replace('{{cidade}}', $cidade, $email_body);
    $email_body = str_replace('{{estado}}', $estado, $email_body);
    $email_body = str_replace('{{pais}}', $pais, $email_body);
    $email_body = str_replace('{{horario}}', $data_local, $email_body);
    $email_body = str_replace('{{id}}', $id_usuario, $email_body);
    $email_body = str_replace('{{ip}}', $ip, $email_body);
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL'];
        $mail->Password = $_ENV['EMAIL_PASS'];;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom($_ENV['EMAIL'], 'Minhas Vacinas');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Sua conta Minhas Vacinas foi acessada a partir de um novo endereço IP';
        $mail->addEmbeddedImage('../../../assets/img/logo-img.png', 'logo-img');
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function RegistrarDispositivo($pdo, $id_usuario)
{
    $ip = ObterIP();
    $token = 'c4444d8bf12e24';
    $response = file_get_contents("https://ipinfo.io/{$ip}/json?token={$token}");
    $data = json_decode($response, true);

    $cidade = isset($data['city']) ? $data['city'] : 'Desconhecida';
    $estado = isset($data['region']) ? $data['region'] : 'Desconhecido';
    $pais = isset($data['country']) ? $data['country'] : 'Desconhecido';

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $browser_info = NavegadorINFO($user_agent);
    $navegador = $browser_info['browser'];
    $sistema_operacional = $browser_info['os'];
    $tipo_dispositivo = (strpos($user_agent, 'Mobile') !== false) ? 'Mobile' : 'Desktop';
    $tipo_dispositivo = strtoupper($tipo_dispositivo);
    $nome_dispositivo = $tipo_dispositivo . " - " . $sistema_operacional . " | " . $navegador;

    $sql = $pdo->prepare("INSERT INTO dispositivos (id_usuario, nome_dispositivo, tipo_dispositivo, ip, navegador, cidade, estado, pais)
    VALUES
    (:id_usuario, :nome_dispositivo, :tipo_dispositivo, :ip, :navegador, :cidade, :estado, :pais)");

    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->bindValue(':nome_dispositivo', $nome_dispositivo);
    $sql->bindValue(':tipo_dispositivo', $tipo_dispositivo);
    $sql->bindValue(':ip', $ip);
    $sql->bindValue(':navegador', $navegador);
    $sql->bindValue(':cidade', $cidade);
    $sql->bindValue(':estado', $estado);
    $sql->bindValue(':pais', $pais);
    $sql->execute();

    return $ip;
}

function ObterIP()
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = '192.168.1';
    }

    return $ip;
}

function NavegadorINFO($user_agent)
{
    if (strpos($user_agent, 'Windows NT') !== false) {
        $os = 'Windows';
    } elseif (strpos($user_agent, 'Macintosh') !== false) {
        $os = 'Mac OS';
    } elseif (strpos($user_agent, 'Linux') !== false) {
        $os = 'Linux';
    } elseif (strpos($user_agent, 'Android') !== false) {
        $os = 'Android';
    } elseif (strpos($user_agent, 'iPhone') !== false) {
        $os = 'iOS';
    } else {
        $os = 'Desconhecido';
    }

    if (strpos($user_agent, 'Chrome') !== false) {
        $browser = 'Chrome';
    } elseif (strpos($user_agent, 'Firefox') !== false) {
        $browser = 'Firefox';
    } elseif (strpos($user_agent, 'Safari') !== false) {
        $browser = 'Safari';
    } elseif (strpos($user_agent, 'Edge') !== false) {
        $browser = 'Edge';
    } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
        $browser = 'Internet Explorer';
    } else {
        $browser = 'Desconhecido';
    }

    return [
        'os' => $os,
        'browser' => $browser
    ];
}
