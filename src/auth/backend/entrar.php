<?php
require '../../scripts/conn.php';
require '../../scripts/registrar-dispositivos.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$email = strtolower(trim($dados['email']));
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$senha = $dados['senha'];
$lembrarLogin = isset($_POST['lembrarLogin']) ? true : false;


if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (empty($email) || empty($senha)) {
        $retorna = ['status' => false, 'msg' => "Todos os campos devem ser preenchidos."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    } else {
        try {
            $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() == 1) {
                $usuario = $sql->fetch(PDO::FETCH_BOTH);
                $email_conf = $usuario['email_conf'];

                if ($email_conf != 1) {
                    $retorna = ['status' => false, 'msg' => "É necessário confirmar seu cadastro para acessar o sistema."];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit();
                }
                if (password_verify($senha, $usuario['senha'])) {
                    if (!$lembrarLogin) {
                        $id_usuario = $usuario['id_usuario'];
                        $ip = get_real_ip();

                        $sql = $pdo->prepare("SELECT * FROM usuario WHERE ip_cadastro = :ip_cadastro AND id_usuario = :id_usuario");
                        $sql->bindValue(':ip_cadastro', $ip);
                        $sql->bindValue(':id_usuario', $id_usuario);
                        $sql->execute();

                        if ($sql->rowCount() == 1) {
                            $retorna = ['status' => true, 'msg' => "Bem-vindo à nossa plataforma, " . htmlspecialchars(explode(' ', $usuario['nome'])[0]) . "!"];
                            header('Content-Type: application/json');
                            echo json_encode($retorna);
                            $_SESSION['session_id'] = $usuario['id_usuario'];
                            $_SESSION['session_nome'] = $usuario['nome'];
                            $_SESSION['session_email'] = $usuario['email'];
                            exit();
                        } else {
                            $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE ip = :ip AND id_usuario = :id_usuario");
                            $sql->bindValue(':ip', $ip);
                            $sql->bindValue(':id_usuario', $id_usuario);
                            $sql->execute();

                            if ($sql->rowCount() == 1) {
                                $retorna = ['status' => true, 'msg' => "Bem-vindo à nossa plataforma, " . htmlspecialchars(explode(' ', $usuario['nome'])[0]) . "!"];
                                header('Content-Type: application/json');
                                echo json_encode($retorna);
                                $_SESSION['session_id'] = $usuario['id_usuario'];
                                $_SESSION['session_nome'] = $usuario['nome'];
                                $_SESSION['session_email'] = $usuario['email'];
                                exit();
                            } else {
                                registrar_dispositivo($pdo, $id_usuario);
                                $token = 'c4444d8bf12e24';
                                $response = file_get_contents("https://ipinfo.io/{$ip}/json?token={$token}");
                                $data = json_decode($response, true);

                                $cidade = $data['city'];
                                $estado = $data['region'];
                                $pais = $data['country'];
                                $email = $usuario['email'];

                                enviarEmail($email, $ip, $cidade, $estado, $pais);
                                $retorna = ['status' => true, 'msg' => ""];
                                header('Content-Type: application/json');
                                echo json_encode($retorna);
                                exit();
                            }
                        }
                    } else {
                        $retorna = ['status' => true, 'msg' => "Para concluir o login, verifique seu e-mail e clique no link de confirmação. Um e-mail foi enviado com as instruções."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        //Modificar aqui quando encontrar a solução do Checkbox para login
                        $_SESSION['session_id'] = $usuario['id_usuario'];
                        $_SESSION['session_nome'] = $usuario['nome'];
                        $_SESSION['session_email'] = $usuario['email'];
                        exit();
                    }
                } else {
                    $retorna = ['status' => false, 'msg' => "As credenciais fornecidas estão incorretas."];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit();
                }
            } else {
                $retorna = ['status' => false, 'msg' => "O e-mail não existe em nosso sistema."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            }
        } catch (PDOException $e) {
            $retorna = ['status' => false, 'msg' => "Ocorreu um erro ao tentar fazer o login"];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    }
} else {
    $retorna = ['status' => false, 'msg' => "E-mail fornecido é inválido."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

function enviarEmail($email, $ip, $cidade, $estado, $pais)
{
    date_default_timezone_set('America/Sao_Paulo');
    $data_local = date('d/m/Y');
    $email_body = file_get_contents('../../../assets/email/alerta-login.html');
    $email_body = str_replace('{{ip}}', $ip, $email_body);
    $email_body = str_replace('{{cidade}}', $cidade, $email_body);
    $email_body = str_replace('{{estado}}', $estado, $email_body);
    $email_body = str_replace('{{pais}}', $pais, $email_body);
    $email_body = str_replace('{{horario}}', $pais, $email_body);
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
        $mail->Subject = 'Novo acesso a sua conta';
        $mail->addEmbeddedImage('../../../assets/img/logo-img.png', 'logo-img');
        $email_body = str_replace('{{logo-img}}', 'cid:logo-img', $email_body);
        $mail->Body = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
