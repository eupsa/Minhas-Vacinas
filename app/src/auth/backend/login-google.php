<?php
session_start();
require_once '../../utils/ConexaoDB.php';
require_once __DIR__ . '/../../../../libs/autoload.php';

use Google\Client as GoogleClient;
use Google\Service\Oauth2;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (empty($_GET['code'])) {
    header('Location: ../entrar/?msg=erro&text=' . urlencode("Código de autorização ausente."));
    exit();
}

$client = new GoogleClient();
$client->setClientId($_ENV['GOOGLE_ID_CLIENT']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_LOGIN']);
$client->addScope(['openid', 'email', 'profile']);

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
if (isset($token['error'])) {
    header('Location: ../entrar/?msg=erro&text=' . urlencode("Erro ao autenticar com o Google."));
    exit();
}
$client->setAccessToken($token['access_token']);

$oauth = new Oauth2($client);
$userInfo = $oauth->userinfo->get();

$email    = strtolower(trim($userInfo->email));
$googleId = $userInfo->id;
$nome     = ucwords(trim($userInfo->name));
$foto_url = $userInfo->picture ?? null;
$ip       = ObterIP();

$sql = $pdo->prepare("
  SELECT u.* FROM usuario u
  JOIN usuario_google ug USING(id_usuario)
  WHERE ug.google_id = :gid
");
$sql->bindValue(':gid', $googleId);
$sql->execute();

if ($sql->rowCount() === 0) {
    header('Location: ../entrar/?msg=erro&text=' . urlencode("Usuário não cadastrado. Faça o cadastro primeiro."));
    exit();
}

$usuario = $sql->fetch(PDO::FETCH_ASSOC);
$id_usuario = $usuario['id_usuario'];

$sql = $pdo->prepare("SELECT * FROM dispositivos WHERE ip = :ip AND id_usuario = :uid");
$sql->bindValue(':ip', $ip);
$sql->bindValue(':uid', $id_usuario);
$sql->execute();

if ($sql->rowCount() == 0) {
    RegistrarDispositivos($pdo, $id_usuario);
    $id_dispositivo = RegistrarDispositivos($pdo, $id_usuario);
    EnviarEmail($id_usuario, $email, $id_dispositivo);
    header('Location: ../entrar/?msg=sucesso&text=' . urlencode("Novo dispositivo detectado. Verifique seu e‑mail para confirmar."));
    exit();
}

$dispositivo = $sql->fetch(PDO::FETCH_ASSOC);
if ($dispositivo['confirmado'] != 1) {
    EnviarEmail($id_usuario, $email, $ip, $dispositivo['cidade'], $dispositivo['estado'], $dispositivo['pais']);
    header('Location: ../entrar/?msg=sucesso&text=' . urlencode("Para concluir o login, confirme o dispositivo pelo e‑mail."));
    exit();
}

// 7. Verifica 2FA
$sql2FA = $pdo->prepare("SELECT * FROM 2FA WHERE email = :email");
$sql2FA->bindValue(':email', $email);
$sql2FA->execute();

if ($sql2FA->rowCount() > 0) {
    $_SESSION['temp_user_email'] = $usuario['email'];
    header('Location: ../dois-fatores/');
    exit();
}

// 8. Tudo certo: login direto (sem 2FA)
$_SESSION['user_id']    = $usuario['id_usuario'];
$_SESSION['user_nome']  = $usuario['nome'];
$_SESSION['user_email'] = $usuario['email'];
$_SESSION['user_ip']    = $ip;

header('Location: ../../dashboard/');
exit();

function EnviarEmail($id_usuario, $email, $id_dispositivo)
{
    $email_body = file_get_contents('../../../public/email/alerta-login.html');
    $url = $_ENV['APP_URL'] . "/app/src/auth/novo-dispositivo?deviceid={$id_dispositivo}&userid={$id_usuario}";
    $email_body = str_replace('{{url}}', $url, $email_body);
    $mail = new PHPMailer(true);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['MAIL_PORT'] ?? 587;
        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Minhas Vacinas');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Novo acesso detectado';
        $mail->Body    = $email_body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function RegistrarDispositivos($pdo, $id_usuario)
{
    $ip = ObterIP();
    $token = $_ENV['IPINFO_TOKEN'];
    $geo = @json_decode(file_get_contents("https://ipinfo.io/{$ip}/json?token={$token}"), true);
    $cid = $geo['city'] ?? 'Desconhecida';
    $st  = $geo['region'] ?? 'Desconhecido';
    $cty = $geo['country'] ?? 'Desconhecido';
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $info = NavegadorInfo($ua);
    $nome_disp = strtoupper((strpos($ua, 'Mobile') !== false ? 'Mobile' : 'Desktop')) . " | {$info['os']} | {$info['browser']}";
    $sql = $pdo->prepare("
      INSERT INTO dispositivos 
      (id_usuario,nome_dispositivo,tipo_dispositivo,ip,navegador,cidade,estado,pais,confirmado) 
      VALUES 
      (:uid,:nome_disp,:tipo,:ip,:nav,:cid,:st,:cty,0)
    ");
    $sql->execute([
        ':uid' => $id_usuario,
        ':nome_disp' => $nome_disp,
        ':tipo' => strpos($ua, 'Mobile') !== false ? 'Mobile' : 'Desktop',
        ':ip' => $ip,
        ':nav' => $info['browser'],
        ':cid' => $cid,
        ':st' => $st,
        ':cty' => $cty
    ]);

    $id_dispositivo = $pdo->lastInsertId();
    return $id_dispositivo;
}

function ObterIP()
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    if (!empty($_SERVER['REMOTE_ADDR'])) return $_SERVER['REMOTE_ADDR'];
    return '0.0.0.0';
}

function NavegadorInfo($ua)
{
    $osList = ['Windows', 'Macintosh' => 'Mac OS', 'Linux', 'Android', 'iPhone' => 'iOS'];
    foreach ($osList as $key => $val) {
        if (strpos($ua, (is_int($key) ? $val : $key)) !== false) {
            $os = is_int($key) ? $val : $val;
            break;
        }
    }
    $browser = 'Desconhecido';
    foreach (['Chrome', 'Firefox', 'Safari', 'Edge', 'MSIE', 'Trident'] as $b) {
        if (strpos($ua, $b) !== false) {
            $browser = $b;
            break;
        }
    }
    return compact('os', 'browser');
}
