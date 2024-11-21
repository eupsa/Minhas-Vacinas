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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vacinas - Painel</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top rounded-pill shadow"
            style="background-color: #007bff; z-index: 1081; width: 50%; left: 57%; transform: translateX(-50%); margin-top: 10px;">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 60px;">
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
                            <h5 class="card-title">Função 1</h5>
                            <p class="card-text">Descrição fictícia da função 1.</p>
                            <a href="#" class="btn btn-primary btn-sm mt-auto">Acessar</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <div class="card shadow-sm rounded-lg border-0 bg-light h-100">
                        <div class="card-body d-flex flex-column text-center">
                            <p class="text-success text-center">
                                <i class="fas fa-check-circle" style="color: #198754;"></i> Adicionada recentemente!
                            </p>
                            <h5 class="card-title">Função 2</h5>
                            <p class="card-text">Descrição fictícia da função 2.</p>
                            <a href="#" class="btn btn-primary btn-sm mt-auto">Acessar</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <div class="card shadow-sm rounded-lg border-0 bg-light h-100">
                        <div class="card-body d-flex flex-column text-center">
                            <p class="text-success text-center">
                                <i class="fas fa-check-circle" style="color: #198754;"></i> Adicionada recentemente!
                            </p>
                            <h5 class="card-title">Função 3</h5>
                            <p class="card-text">Descrição fictícia da função 3.</p>
                            <a href="#" class="btn btn-primary btn-sm mt-auto">Acessar</a>
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
                        <a href="index.php" class="nav-link active" aria-current="page">
                            <i class="bi bi-house-door"></i>
                            Início
                        </a>
                    </li>
                    <li>
                        <a href="vaccines/index.php" class="nav-link text-white">
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
                        <a href="profile/index.php" class="nav-link text-white">
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
                        <span><?php echo isset($_SESSION['session_nome']) ? $_SESSION['session_nome'] : 'Usuário'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="profile/index.php">Conta</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/src/backend/scripts/logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
    </section>

    <section class="side-bar">
        <div class="content">
            <h1 class="text-center mb-4">Painel de Notícias</h1>
            <div class="row">
                <?php
                $apiKey = "ffe99dae4cc64a67b05f07b8c72f3ba1";
                $query = "vacinação";
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