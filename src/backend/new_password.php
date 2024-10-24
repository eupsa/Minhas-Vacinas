<?php
require '../backend/scripts/conn.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$senha = $dados['senha'];
$confsenha = $dados['confSenha'];
$token = $dados['token'];

if (empty($senha) || empty($confsenha) || empty($token)) {
    $retorna = ['status' => false, 'msg' => "Todos os campos devem ser preenchidos."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
} else {
    if ($senha === $confsenha) {
        try {
            $sql = $pdo->prepare("SELECT * FROM redefinicaoSenha WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() === 1) {
                $tokenData = $sql->fetch(PDO::FETCH_ASSOC);
                $email = $tokenData['email'];

                try {
                    $sql = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
                    $sql->bindValue(':email', $email);
                    $sql->execute();

                    if ($sql->rowCount() === 1) {
                        $senhaHash = hash('sha256', $senha);
                        $sql = $pdo->prepare("UPDATE usuario SET senha = :senha WHERE email = :email");
                        $sql->bindValue(':senha', $senhaHash);
                        $sql->bindValue(':email', $email);
                        $sql->execute();

                        if ($sql->rowCount() === 1) {
                            try {
                                $sql = $pdo->prepare("DELETE FROM redefinicaoSenha WHERE token = :token");
                                $sql->bindValue(':token', $token);
                                $sql->execute();

                                $retorna = ['status' => true, 'msg' => "Senha atualizada com sucesso."];
                                header('Content-Type: application/json');
                                echo json_encode($retorna);
                                exit();
                            } catch (PDOException $e) {
                                $retorna = ['status' => false, 'msg' => "Erro ao remover o token: " . $e->getMessage()];
                                header('Content-Type: application/json');
                                echo json_encode($retorna);
                                exit();
                            }
                        } else {
                            $retorna = ['status' => false, 'msg' => "Erro ao atualizar a senha."];
                            header('Content-Type: application/json');
                            echo json_encode($retorna);
                            exit();
                        }
                    } else {
                        $retorna = ['status' => false, 'msg' => "Usuário não encontrado."];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit();
                    }
                } catch (PDOException $e) {
                    $retorna = ['status' => false, 'msg' => "Erro ao buscar usuário: " . $e->getMessage()];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit();
                }
            } else {
                $retorna = ['status' => false, 'msg' => "Token inválido ou expirado."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit();
            }
        } catch (PDOException $e) {
            $retorna = ['status' => false, 'msg' => "Erro ao buscar o token: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
        }
    } else {
        $retorna = ['status' => false, 'msg' => "As senhas não coincidem."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit();
    }
}
