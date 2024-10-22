<?php
require '../backend/scripts/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $novaSenha = $_POST['nova_senha'];
    $confirmarSenha = $_POST['confirmar_senha'];
    // var_dump($_POST);
    
    if (empty($novaSenha) || empty($confirmarSenha)) {
        echo json_encode(['status' => false, 'msg' => 'Por favor, preencha todos os campos.']);
        exit();
    }

    if ($novaSenha !== $confirmarSenha) {
        echo json_encode(['status' => false, 'msg' => 'As senhas não coincidem.']);
        exit();
    }

    try {
        $sql = $pdo->prepare("SELECT * FROM redefinicaoSenha WHERE token = :token AND dataExpiracao > NOW()"); //now eh agora
        $sql->bindValue(':token', $token);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $dadosToken = $sql->fetch(PDO::FETCH_ASSOC);
            $email = $dadosToken['email'];

            $senhaHash = hash('sha256', $senha);
            $sqlUpdateSenha = $pdo->prepare("UPDATE usuario SET senha = :senha WHERE email = :email");
            $sqlUpdateSenha->bindValue(':senha', $senhaHash);
            $sqlUpdateSenha->bindValue(':email', $email);
            $sqlUpdateSenha->execute();

            // Deleta o token após uso
            $sqlDeleteToken = $pdo->prepare("DELETE FROM redefinicaoSenha WHERE token = :token");
            $sqlDeleteToken->bindValue(':token', $token);
            $sqlDeleteToken->execute();

            echo json_encode(['status' => true, 'msg' => 'Senha alterada com sucesso!']);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Token inválido ou expirado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => false, 'msg' => 'Erro ao alterar a senha: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => false, 'msg' => 'Método inválido.']);
}