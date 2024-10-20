<?php
require '../backend/scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = $pdo->prepare("SELECT * FROM redefinicaoSenha WHERE token = :token");
    $sql->bindValue(':token', $token);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        $redefinicao = $sql->fetch(PDO::FETCH_ASSOC);
        $email = $redefinicao['email'];
        $dataExpiracao = $redefinicao['dataExpiracao'];

        if (date('Y-m-d H:i:s', strtotime($dataExpiracao)) > date('Y-m-d H:i:s')) {
            if (empty($senha) || empty($confsenha)) {
                $retorna = ['status' => false, 'msg' => "Preencha todos os campos."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit;
            } else {
                if ($senha === $confsenha) {
                    try {
                        $senhaHash = hash('sha256', $senha);
                        $sql = $pdo->prepare("UPDATE usuario SET senha = :senha WHERE email = :email");
                        $sql->bindValue(':senha', $senhaHash);
                        $sql->bindValue(':email', $email);
                        $sql->execute();

                        $sql = $pdo->prepare("DELETE FROM redefinicaoSenha WHERE token = :token");
                        $sql->bindValue(':token', $token);
                        $sql->execute();

                        $retorna = ['status' => true, 'msg' => "Senha alterada com sucesso!"];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                    } catch (PDOException $e) {
                        $retorna = ['status' => false, 'msg' => "Erro ao atualizar a senha: " . $e->getMessage()];
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
            }
        } else {
            $retorna = ['status' => false, 'msg' => "O link de redefinição de senha expirou."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    } else {
        $retorna = ['status' => false, 'msg' => "Token inválido."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit;
    }
} else {
    $retorna = ['status' => false, 'msg' => "Token não encontrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit;
}
