<?php
session_start();
require_once '../../utils/ConexaoDB.php';
require_once '../../utils/Funcoes.php';
require_once __DIR__ . '../../../../../libs/autoload.php';

if (!empty($_POST['link_expiracao']) || !empty($_GET['id_vac_comp'])) {
    $id_vac = $_POST['id_vac_comp'];
    $uuid = uuidV4();
    $link = $_ENV['APP_URL'] . "/app/vacinas/" . $uuid;

    $dataAtual = new DateTime();

    switch ($_POST['link_expiracao']) {
        case '24':
            $dataAtual->modify('+24 hours');
            break;
        case '7':
            $dataAtual->modify('+7 days');
            break;
        case '30':
            $dataAtual->modify('+30 days');
            break;
        case 'never':
            $dataAtual = null;
            break;
        default:
            $retorna = ['status' => true, 'msg' => "Tempo de expiração inválido."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit();
            $dataAtual = null;
            break;
    }

    $sql = $pdo->prepare("INSERT INTO vacinas_compartilhadas (id_vac_FK, uuid, link, data_expiracao) 
    VALUES (:id_vac_FK, :uuid, :link, :data_expiracao)");
    $sql->bindValue(':id_vac_FK', $id_vac);
    $sql->bindValue(':uuid', $uuid);
    $sql->bindValue(':link', $link);
    $sql->bindValue(':data_expiracao', $dataAtual ? $dataAtual->format('Y-m-d H:i:s') : null);
    if ($sql->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            'link' => $link,
            'data_expiracao' => $dataAtual ? $dataAtual->format("d/m/Y H:i:s") : null,
            'data_compartilhamento' => date("d/m/Y H:i:s")
        ]);
    }
}
