<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    header("Location: ../auth/entrar/");
    exit();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3472234536437513"
        crossorigin="anonymous"></script>
    <title>Vacinas - Painel</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top"
            style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);" id="navi">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
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
                <div class="d-flex align-items-center justify-content-center" style="height: 10vh;">
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

    <section class="side-bar">
        <div class="content" style="margin-top: -5%;">
            <h1 class="text-center mb-4">Últimas Notícias</h1>
            <div class="row">
                <?php
                $apiKey = "cca8aa0d21a74b84a307fdcfe5375f8d";
                $query = "Saude";
                $language = "pt";
                $url = "https://newsapi.org/v2/everything?q=" . urlencode($query) . "&language=" . $language . "&apiKey=" . $apiKey;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "User-Agent: Minhas-Vacinas/1.0"
                ]);

                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);

                if (isset($data['articles'])) {
                    foreach ($data['articles'] as $article) {
                        $title = $article['title'];

                        if (strpos(strtolower($title), 'removed') !== false) {
                            continue;
                        }

                        $description = $article['description'];
                        $url = $article['url'];
                        $image = $article['urlToImage'] ?? "https://via.placeholder.com/200x150";

                        echo '
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded-lg">
                            <img src="' . $image . '" class="card-img-top rounded-top" alt="Imagem da notícia">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate" style="font-size: 1rem; font-weight: bold;">' . $title . '</h5>
                                <p class="card-text text-truncate" style="font-size: 0.85rem; flex-grow: 1;">' . $description . '</p>
                                <a href="' . $url . '" class="btn btn-success btn-block mt-3" target="_blank" style="font-size: 0.85rem; border-radius: 50px; transition: background-color 0.3s; padding: 10px 20px;">Leia mais</a>
                            </div>
                        </div>
                    </div>';
                    }
                } else {
                    echo '<p class="text-danger text-center">Nenhuma notícia encontrada.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>