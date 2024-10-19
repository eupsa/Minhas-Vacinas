<?php
require 'scripts/conn.php';

function VefToken($pdo)
{
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $sql = $pdo->prepare("SELECT * FROM redefinicaoSenha WHERE token = :token");
        $sql->bindValue(':token', $token);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $redefinicao = $sql->fetch(PDO::FETCH_BOTH);
            $email = $redefinicao['email'];
            $dataExpiracao = $redefinicao['dataExpiracao'];
            if (strtotime($dataExpiracao) < time()) {
                echo 'token expirado';
                $retorna = ['status' => false, 'msg' => "O token expirou."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit;
            }
        } else {
            $retorna = ['status' => false, 'msg' => "Token inválido ou expirado."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    }
}
