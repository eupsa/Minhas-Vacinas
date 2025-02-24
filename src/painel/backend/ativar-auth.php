<?php
session_start();
require_once '../../../vendor/autoload.php';
require_once '../../scripts/conn.php';

$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

$secret = $g->generateSecret();

$sql = $pdo->prepare("UPDATE usuario SET secretkey_2FA = :secretkey_2FA WHERE id_usuario = :id");
$sql->bindValue(':secretkey_2FA', $secret);
$sql->bindValue(':id', $_SESSION['user_id']);
$sql->execute();

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTH</title>
</head>

<body>
    <h1>Registre sua parada</h1>
    <img src="<?php echo $g->getUrl('(' . $_SESSION['user_email'] . ')', 'minhasvacinas.online', $secret) ?>" alt="">

</body>

</html>