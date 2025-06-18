<?php
require_once '../../scripts/Conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$dispositivo_id = $dados['dispositivo_id'];;

if (empty($dispositivo_id)) {
    header('Location: ../perfil/');
    exit();
} else {
    try {
        $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id = :id");
        $sql->bindValue(':id', $dispositivo_id);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $sql = $pdo->prepare("DELETE FROM dispositivos WHERE id = :id");
            $sql->bindValue(':id', $dispositivo_id);
            $sql->execute();

            $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id = :id");
            $sql->bindValue(':id', $dispositivo_id);
            $sql->execute();

            if ($sql->rowCount() === 0) {
                header('Location: ../perfil/');
                exit();
            }
        } else {
            header('Location: ../perfil/');
            exit();
        }
    } catch (PDOException $e) {
        header('Location: ../perfil/');
        exit();
    }
}
