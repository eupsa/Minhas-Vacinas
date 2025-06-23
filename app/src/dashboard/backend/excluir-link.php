<?php
session_start();
require_once '../../utils/ConexaoDB.php';

var_dump($_POST);

if (empty($_POST['id_vac'])) {
    $retorna = ['status' => false, 'msg' => "ID Vacina não encontrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit();
}

$sql = $pdo->prepare("DELETE FROM vacinas_compartilhadas WHERE id_vac_FK = :id");
$sql->bindValue(':id', $_POST['id_vac']);
if ($sql->execute()) {
    header("Location: /app/src/dashboard/vacinas/");
}
