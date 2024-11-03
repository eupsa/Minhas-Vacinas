<?php
// login-callback.php

// Função para verificar o token no backend
function verifyGoogleToken($token)
{
    $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $token;
    $response = file_get_contents($url);
    $response = json_decode($response, true);

    // Verifique se a resposta contém o campo 'email_verified' e se está verdadeiro
    if (isset($response['email_verified']) && $response['email_verified'] == "true") {
        return $response;
    }

    return false;
}

// Obtenha o token enviado pelo frontend
$data = json_decode(file_get_contents('php://input'), true);
$token = $data['AIzaSyBA2Alz5ZgpAdY84N8LouBa1qlsu5Sh2YU'] ?? '';

// Verifique o token
$userData = verifyGoogleToken($token);

if ($userData) {
    // Verifique se o usuário já está cadastrado no banco de dados
    // Caso não esteja, faça o cadastro
    // Você pode salvar informações como $userData['email'], $userData['name'], $userData['picture']

    // Responda com sucesso
    echo json_encode(['success' => true, 'message' => 'Login bem-sucedido', 'user' => $userData]);
} else {
    // Responda com erro
    echo json_encode(['success' => false, 'message' => 'Falha na autenticação com o Google']);
}
