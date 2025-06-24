<?php
require_once '../../utils/ConexaoDB.php';
require_once __DIR__ . '/../../../../libs/autoload.php';
require_once '../../utils/NovoDispositivo.php';

use Google\Client as GoogleClient;
use Google\Service\Oauth2;

// 1. Verifica se o código foi recebido
if (empty($_GET['code'])) {
    header('Location: ../cadastro/?msg=erro&text=' . urlencode("Código de autorização ausente."));
    exit();
}

// 2. Inicializa o cliente Google
$client = new GoogleClient();
$client->setClientId($_ENV['GOOGLE_ID_CLIENT']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_REGISTER']);
$client->addScope(['openid', 'email', 'profile']);

// 3. Troca o code por token de acesso
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

if (isset($token['error'])) {
    header('Location: ../cadastro/?msg=erro&text=' . urlencode("Erro ao autenticar com o Google."));
    exit();
}

$client->setAccessToken($token['access_token']);

// 4. Pega dados do usuário autenticado
$oauth = new Oauth2($client);
$userInfo = $oauth->userinfo->get();

$email = strtolower(trim($userInfo->email));
$nome = ucwords(trim($userInfo->name));
$foto_url = $userInfo->picture ?? null;
$googleId = $userInfo->id;
$ip = ObterIP();

// 5. Verifica se o e-mail já existe
$sql = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :email");
$sql->bindValue(':email', $email);
$sql->execute();

if ($sql->rowCount() > 0) {
    header('Location: ../cadastro/?msg=erro&text=' . urlencode("Este e-mail já está cadastrado."));
    exit();
}

// 6. Insere o novo usuário
$sql = $pdo->prepare("INSERT INTO usuario (nome, email, email_conf) VALUES (:nome, :email, 1)");
$sql->bindValue(':nome', $nome);
$sql->bindValue(':email', $email);
$sql->execute();
$id_usuario = $pdo->lastInsertId();

// 7. Insere na tabela de Google
$sql = $pdo->prepare("INSERT INTO usuario_google (id_usuario, google_id, foto_url) VALUES (:id_usuario, :google_id, :foto_url)");
$sql->bindValue(':id_usuario', $id_usuario);
$sql->bindValue(':google_id', $googleId);
$sql->bindValue(':foto_url', $foto_url);
$sql->execute();

// 8. Registra dispositivo
$ip = RegistrarDispostivos($pdo, $id_usuario);
$sql = $pdo->prepare("UPDATE usuario SET ip_cadastro = :ip WHERE id_usuario = :id");
$sql->bindValue(':ip', $ip);
$sql->bindValue(':id', $id_usuario);
$sql->execute();

// 9. Finaliza
header('Location: ../entrar/?msg=sucesso&text=' . urlencode("Cadastro realizado com sucesso! Faça login."));
exit();