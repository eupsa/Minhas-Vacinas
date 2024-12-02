<?php
// session_start();
// require '../../scripts/conn.php';

// // Receber os dados enviados via JSON
// $data = json_decode(file_get_contents("php://input"), true);

// // Verificar se os dados foram recebidos corretamente
// if ($data && isset($data['id_vacina'])) {
//     $id_vacina = $data['id_vacina'];

//     try {
//         // Preparar a consulta para excluir a vacina
//         $sql = $pdo->prepare("DELETE FROM vacina WHERE id_vac = :id_vac AND id_user = :id_user");
//         $sql->bindValue(':id_vac', $id_vacina);
//         $sql->bindValue(':id_user', $_SESSION['session_id']);
//         $sql->execute();

//         if ($sql->rowCount() > 0) {
//             $retorna = ['status' => true, 'msg' => 'Vacina excluída com sucesso!'];
//         } else {
//             $retorna = ['status' => false, 'msg' => 'Erro ao excluir a vacina. Tente novamente.'];
//         }
//     } catch (PDOException $e) {
//         $retorna = ['status' => false, 'msg' => 'Erro ao excluir a vacina. Tente novamente em alguns minutos.'];
//     }

//     header('Content-Type: application/json');
//     echo json_encode($retorna);
//     exit();
// } else {
//     // Caso os dados não sejam recebidos ou o id_vacina não esteja presente
//     $retorna = ['status' => false, 'msg' => 'Dados inválidos.'];
//     header('Content-Type: application/json');
//     echo json_encode($retorna);
//     exit();
// }
