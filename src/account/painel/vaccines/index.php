<?php
require '../../../backend/scripts/auth.php';
require '../../../backend/scripts/conn.php';
SeNaoLogado();

$userId = $_SESSION['user_id'];
$sql = $pdo->prepare("SELECT * FROM vacina WHERE idUsuario = :idUsuario");
$sql->bindValue(':idUsuario', $userId);
$sql->execute();
$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);
if (count($vacinas) > 0) {
    $_SESSION['vacinas'] = $vacinas;
} else {
    $_SESSION['vacinas'] = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Minhas Vacinas - Suas Vacinas</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="../../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 60px;">
                </a>
                <button class="btn btn-light" id="sidebarToggle" aria-label="Open menu">
                    <span class="navbar-toggler-icon" id="menuButton"></span>
                </button>
            </div>
        </nav>
    </header>


    <div class="wrapper">
        <aside class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
            <div class="d-flex align-items-center justify-content-center" style="height: 10vh;">
                <!-- Adicione algum conteúdo aqui, como o logo ou o título -->
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link text-white" aria-current="page">
                        <i class="bi bi-house-door"></i>
                        Início
                    </a>
                </li>
                <li>
                    <a href="index.php" class="nav-link active">
                        <i class="fas fa-syringe"></i>
                        Vacinas
                    </a>
                </li>
                <li>
                    <a href="/src/campaigns/index.html" class="nav-link text-white">
                        <i class="fas fa-bullhorn"></i>
                        Campanhas
                    </a>
                </li>
                <li>
                    <a href="../profile/index.php" class="nav-link text-white">
                        <i class="bi bi-person"></i>
                        Conta
                    </a>
                </li>
                <li>
                    <hr>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="/assets/img/ft-perfil.png" alt="Foto do Usuário" class="rounded-circle me-2" width="40" height="40">
                    <span><?php echo isset($_SESSION['user_nome']) ? $_SESSION['user_nome'] : 'Usuário'; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../profile/index.php">Conta</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="/src/backend/scripts/logout.php">Sair</a></li>
                </ul>
            </div>
        </aside>
    </div>


    <div class="content">
        <section>
            <div class="esq">
                <h1>Vacinas</h1>
                <h3 class="fw-light">Registre as doses aplicadas.</h3>
                <a type="button" class="btn btn-primary" href="register/index.php">Registrar Doses</a>
            </div>
            <div class="content">
            </div>
            <div class="vacinas-container">
                <?php if (count($vacinas) > 0): ?>
                    <?php foreach ($vacinas as $vacina): ?>
                        <div class="card" style="width: 300px;">
                            <img src="../../../../assets/img/vac-card.jpg" class="card-img-top" alt="Vacina">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($vacina['nomeVac']) ?></h5>
                                <p class="card-text">Dose: <?= htmlspecialchars($vacina['dose']) ?></p>
                                <p class="card-text">Data de Aplicação: <?= htmlspecialchars($vacina['dataAplicacao']) ?></p>
                                <p class="card-text">Local: <?= htmlspecialchars($vacina['localAplicacao']) ?></p>
                                <p class="card-text">Lote: <?= htmlspecialchars($vacina['lote']) ?></p>
                                <p class="card-text">Observações: <?= htmlspecialchars($vacina['obs']) ?></p>
                                <form action="../backend/delete.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $vacina['idVacina'] ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Você ainda não registrou nenhuma vacina.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>



    <!-- 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script src="../../../../assets/js/sweetalert2.min.js"></script>
</body>

</html>