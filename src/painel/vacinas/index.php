<?php
require '../../scripts/conn.php';
require '../../scripts/auth.php';

session_start();
if (!isset($_SESSION['session_id'])) {
    header("Location: ../../auth/entrar/");
    exit();
} else {

    $id_user = $_SESSION['session_id'];
    $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_user = :id_user");
    $sql->bindValue(':id_user', $id_user);
    $sql->execute();
    $vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($vacinas) > 0) {
        $_SESSION['vacinas'] = $vacinas;
    } else {
        $_SESSION['vacinas'] = [];
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3472234536437513"
        crossorigin="anonymous"></script>
    <title>Minhas Vacinas - Suas Vacinas</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top"
            style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

    <section>
        <div class="wrapper">
            <aside class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
                <div class="d-flex align-items-center justify-content-center" style="height: 10vh;">
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="../" class="nav-link text-white" aria-current="page">
                            <i class="bi bi-house-door"></i>
                            Início
                        </a>
                    </li>
                    <li>
                        <a href="" onclick="Location.reload()" class="nav-link active" aria-current="page">
                            <i class="fas fa-syringe"></i>
                            Vacinas
                        </a>
                    </li>
                    <li>
                        <a href="" onclick="alert('Indisponível')" class="nav-link text-white">
                            <i class="fas fa-bullhorn"></i>
                            Campanhas
                        </a>
                    </li>
                    <li>
                        <a href="../perfil/" class="nav-link text-white">
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
                    <a href="" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/img/bx-user.svg" alt="Foto do Usuário" class="rounded-circle me-2"
                            width="40" height="40">
                        <span><?php echo isset($_SESSION['session_nome']) ? explode(' ', $_SESSION['session_nome'])[0] : 'Usuário'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="../perfil/"><i class="fas fa-user"></i> Minha conta</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../../scripts/sair.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>


    <div class="content">
        <section>
            <div class="esq">
                <h1>Vacinas</h1>
                <h3 class="fw-light">Registre e visualize as suas vacinas aplicadas.</h3>
                <a type="button" class="btn btn-primary" href="cadastro-vacinas/">Registrar Doses</a>
            </div>
            <div class="vacinas-container">
                <?php if (count($vacinas) > 0): ?>
                    <?php foreach ($vacinas as $vacina): ?>
                        <div class="card" style="width: 300px;">
                            <img src="../../../../assets/img/vac-card.jpg" class="card-img-top" alt="Vacina">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($vacina['nome_vac']) ?></h5>
                                <p class="card-text">Dose: <?= htmlspecialchars($vacina['dose']) ?></p>
                                <p class="card-text">Data de Aplicação: <?= htmlspecialchars($vacina['data_aplicacao']) ?></p>
                                <p class="card-text">Local: <?= htmlspecialchars($vacina['local_aplicacao']) ?></p>
                                <p class="card-text">Lote: <?= htmlspecialchars($vacina['lote']) ?></p>
                                <p class="card-text">Observações: <?= htmlspecialchars($vacina['obs']) ?></p>
                                <form action="../backend/excluir-vacina.php" method="POST" style="display: inline;" class="form-excluir-vacina">
                                    <input type="hidden" name="id_vac" value="<?= $vacina['id_vac'] ?>">
                                    <button type="submit" class="btn btn-danger" id="btn-excluir">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>