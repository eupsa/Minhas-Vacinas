<?php
require '../scripts/conn.php';
session_start();
if (!isset($_SESSION['session_id'])) {
    header("Location: ../auth/entrar/");
    exit();
} else {
    $id_usuario = $_SESSION['session_id'];
    $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario ORDER BY id_vac DESC LIMIT 3");
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->execute();
    $vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($vacinas) > 0) {
        $_SESSION['vacinas'] = $vacinas;
    } else {
        $_SESSION['vacinas'] = [];
    }
}

$sql = $pdo->prepare("SELECT * FROM usuario_google WHERE id_usuario = :id_usuario");
$sql->bindValue(':id_usuario', $_SESSION['id_usuario']);
$sql->execute();

if ($sql->rowCount() === 1) {
    $usuario_google = $sql->fetchAll(PDO::FETCH_ASSOC);
    $foto_url = $usuario_google['foto_url'];
    var_dump($foto_url);
}

$sql = $pdo->prepare("SELECT * FROM dispositivos WHERE ip = :ip");
$sql->bindValue(':ip', $_SESSION['session_ip']);
$sql->execute();

if ($sql->rowCount() != 1) {
    $sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario AND ip_cadastro = :ip_cadastro");
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->bindValue(':ip_cadastro', $_SESSION['session_ip']);
    $sql->execute();

    if ($sql->rowCount() != 1) {

        $_SESSION = [];
        session_destroy();

        header("Location: ../auth/entrar/");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vacinas - Painel</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" id="sidebarToggle" type="button" data-bs-toggle="sidebar" data-bs-target="#sidebar" aria-controls="sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-left: 90%;">
                    <!-- <ul class="navbar-nav">
                        <li style="margin-left: 20px; margin-top: 2%;">
                            <div id="themeToggle" class="theme-toggle d-flex align-items-center" style="cursor: pointer;">
                                <i class="bi bi-sun" id="sunIcon" style="font-size: 1.2em;"></i>
                                <i class="bi bi-moon" id="moonIcon" style="font-size: 1.2em; display: none;"></i>
                            </div>
                        </li>
                    </ul> -->
                </div>
            </div>
        </nav>
    </header>

    <section class="access-quick">
        <div class="content text-center mb-5">
            <h1>Acesso Rápido</h1>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <div class="card shadow-sm rounded-lg border-0 bg-light h-100">
                        <div class="card-body d-flex flex-column text-center">
                            <p class="text-success text-center">
                                <i class="fas fa-check-circle" style="color: #198754;"></i> Adicionada recentemente!
                            </p>
                            <h5 class="card-title">Registro de Vacinas</h5>
                            <p class="card-text">Com essa funcionalidade você poderá organizar seu histórico de Vacinas.</p>
                            <a href="vacinas/cadastro-vacinas/" class="btn btn-primary btn-sm mt-auto">Acessar</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <div class="card shadow-sm rounded-lg border-0 bg-light h-100">
                        <div class="card-body d-flex flex-column text-center">
                            <p class="text-success text-center">
                                <i class="fas fa-check-circle" style="color: #198754;"></i> Adicionada recentemente!
                            </p>
                            <h5 class="card-title">Exclusão de Vacinas</h5>
                            <p class="card-text">Com essa funcionalidade você poderá excluir uma vacina seu histórico.</p>
                            <a href="vacinas/" class="btn btn-primary btn-sm mt-auto">Acessar</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <div class="card shadow-sm rounded-lg border-0 bg-light h-100">
                        <div class="card-body d-flex flex-column text-center">
                            <p class="text-warning text-center">
                                <i class="fas fa-spinner fa-spin" style="color: #ffc107;"></i> Em desenvolvimento!
                            </p>
                            <h5 class="card-title">Cadastro de Dependentes</h5>
                            <p class="card-text">Com essa funcionalidade você poderá adicionar seus dependentes e gerenciar suas vacinas.
                            </p>
                            <a href="#" class="btn btn-warning btn-sm mt-auto disabled">Indisponível</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div>
            <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
                <div class="d-flex align-items-center justify-content-center" style="height: 10vh;" id="sidebar">
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="" onclick="Location.reload()" class="nav-link active" aria-current="page">
                            <i class="bi bi-house-door"></i>
                            Início
                        </a>
                    </li>
                    <li>
                        <a href="vacinas/" class="nav-link text-white">
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
                        <a href="perfil/" class="nav-link text-white">
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
                        <li><a class="dropdown-item" href="perfil/"><i class="fas fa-user"></i> Minha conta</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../scripts/sair.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                    </ul>
                </div>
            </div>
    </section>

    <section class="access-quick">
        <div class="content text-center mb-5" style="margin-top: -10%;">
            <h1>Últimas vacinas</h1>
            <div class="row justify-content-center">
                <?php if (count($vacinas) > 0): ?>
                    <?php foreach ($vacinas as $vacina): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4"> <!-- Responsividade melhorada -->
                            <div class="card shadow-lg" style="width: 100%; height: 100%; border-radius: 20px; background-color: rgba(255, 255, 255, 0.95); transition: all 0.3s ease;">
                                <img src="../../../../assets/img/vac-card.jpg" class="card-img-top" alt="Vacina" style="object-fit: cover; height: 250px; width: 100%; border-radius: 20px 20px 0 0;">
                                <div class="card-body">
                                    <h5 class="card-title text-center text-dark" style="font-weight: bold;"><?= htmlspecialchars($vacina['nome_vac']) ?></h5>
                                    <div class="d-flex flex-column mt-3">
                                        <p class="card-text"><i class="fas fa-syringe text-success"></i> <strong>Dose:</strong> <?= !empty($vacina['dose']) ? htmlspecialchars($vacina['dose']) : 'Não informado' ?></p>
                                        <p class="card-text"><i class="fas fa-calendar-day text-info"></i> <strong>Data de Aplicação:</strong> <?= !empty($vacina['data_aplicacao']) ? htmlspecialchars($vacina['data_aplicacao']) : 'Não informada' ?></p>
                                        <p class="card-text"><i class="fas fa-map-marker-alt text-warning"></i> <strong>Local:</strong> <?= !empty($vacina['local_aplicacao']) ? htmlspecialchars($vacina['local_aplicacao']) : 'Não informado' ?></p>
                                        <p class="card-text"><i class="fas fa-cogs text-secondary"></i> <strong>Lote:</strong> <?= !empty($vacina['lote']) ? htmlspecialchars($vacina['lote']) : 'Não informado' ?></p>
                                        <p class="card-text"><i class="fas fa-sticky-note text-dark"></i> <strong>Observações:</strong> <?= !empty($vacina['obs']) ? htmlspecialchars($vacina['obs']) : 'Sem observações' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-warning">Nenhuma vacina registrada ainda. Adicione uma nova vacina ao seu histórico.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="../../block.js"></script>
</body>

</html>