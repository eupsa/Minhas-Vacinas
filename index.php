<?php
session_start();
require 'src/scripts/conn.php';

$ip = $_SERVER['REMOTE_ADDR'];
$token = 'c4444d8bf12e24';

$response = file_get_contents("https://ipinfo.io/{$ip}/json?token={$token}");

if ($response !== false) {
    $data = json_decode($response, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        $cidade = isset($data['city']) ? $data['city'] : null;
        $estado = isset($data['region']) ? $data['region'] : null;
        $pais = isset($data['country']) ? $data['country'] : null;
        $empresa = isset($data['org']) ? $data['org'] : null;

        $sql = $pdo->prepare("SELECT COUNT(*) FROM ip_logs WHERE ip = :ip");
        $sql->bindValue(':ip', $ip);
        $sql->execute();
        $ipExistente = $sql->fetchColumn();

        if ($ipExistente == 0) {
            try {
                $sql = $pdo->prepare("INSERT INTO ip_logs (ip, cidade, estado, pais, empresa) VALUES (:ip, :cidade, :estado, :pais, :empresa)");
                $sql->bindValue(':ip', $ip);
                $sql->bindValue(':cidade', $cidade);
                $sql->bindValue(':estado', $estado);
                $sql->bindValue(':pais', $pais);
                $sql->bindValue(':empresa', $empresa);
                $sql->execute();
            } catch (PDOException $e) {
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    try {
        $sql = $pdo->prepare("INSERT INTO novidades (email) VALUES (:email)");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            header("Location: /?status=sucesso#nossa-missao");
        }
        header("Location: /?status=sucesso#nossa-missao");
    } catch (PDOException $e) {
        header("Location: /?status=sucesso#nossa-missao");
    }
}

$latestVersion = 'v0.1';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="manifest" href="manifest.json">
    <!-- SEO - Configurações básicas -->
    <meta name="description" content="Minhas Vacinas - A plataforma para gestão e controle do histórico de vacinação. Organize suas vacinas, receba alertas e informações sobre imunizações.">
    <meta name="author" content="Minhas Vacinas Inc">
    <meta name="keywords" content="Minhas Vacinas Inc">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#0056b3">
    <meta name="format-detection" content="telephone=no">
    <!-- SEO - Versão alternativa do site para outros idiomas -->
    <link rel="alternate" href="" hreflang="pt-br">
    <!-- SEO - URL canônica para evitar conteúdo duplicado -->
    <link rel="canonical" href="https://www.minhasvacinas.online/">
    <!-- Open Graph (Facebook, LinkedIn e outras redes sociais) -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="https://www.minhasvacinas.online/">
    <meta property="og:title" content="Minhas Vacinas">
    <meta property="og:description" content="Minhas Vacinas - A plataforma para gestão e controle do histórico de vacinação. Organize suas vacinas, receba alertas e informações sobre imunizações.">
    <meta property="og:image" content="https://www.minhasvacinas.online/assets/img/banner-200x200.png">
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Minhas Vacinas">
    <meta name="twitter:description" content="Minhas Vacinas - A plataforma para gestão e controle do histórico de vacinação. Organize suas vacinas, receba alertas e informações sobre imunizações.">
    <meta name="twitter:image" content="https://www.minhasvacinas.online/assets/img/banner-200x200.png">
    <!-- Informações de contato do negócio -->
    <meta property="business:contact_data:country_name" content="Brasil">
    <meta property="business:contact_data:region" content="BA">
    <meta property="business:contact_data:website" content="https://www.minhasvacinas.online/">
    <meta property="business:contact_data:email" content="contato@minhasvacinas.online">
    <!-- Geolocalização -->
    <meta name="geo.placename" content="Bahia">
    <meta name="geo.region" content="BR">
    <title>Minhas Vacinas</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="/">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="/#nossa-missao">Sobre</a></li>
                        <li class="nav-item"><a href="src/ajuda/" class="nav-link">Suporte</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <?php if (isset($_SESSION['session_id'])): ?>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white" href="src/painel/">
                                    <i class="bi bi-arrow-return-left"></i> Voltar à sua conta
                                </a>
                            </li>
                            <li class="nav-item ms-2">
                                <a class="btn btn-danger rounded-pill px-4 py-2 text-white" href="src/scripts/sair.php">
                                    <i class="bi bi-box-arrow-left"></i> Sair
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item me-3">
                                <a class="btn btn-light text-primary rounded-pill px-4 py-2" href="src/auth/cadastro/">
                                    <i class="bi bi-person-plus"></i> CADASTRE-SE
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white" href="src/auth/entrar/">
                                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 75%; background: rgba(255, 255, 255, 0.8);">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between" style="height: 100%;">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="/#nossa-missao">Sobre</a></li>
                    <li class="nav-item"><a href="src/ajuda/" class="nav-link">Suporte</a></li>
                </ul>
                <div class="d-flex flex-column align-items-center gap-2 mt-3">
                    <?php if (isset($_SESSION['session_id'])): ?>
                        <a class="btn btn-primary rounded-pill px-4 py-2 text-white w-100 text-center" href="src/painel/">
                            <i class="bi bi-arrow-return-left"></i> Voltar à sua conta
                        </a>
                        <a class="btn btn-danger rounded-pill px-4 py-2 text-white w-100 text-center" href="src/scripts/sair.php">
                            <i class="bi bi-box-arrow-left"></i> Sair
                        </a>
                    <?php else: ?>
                        <a class="btn btn-light text-primary rounded-pill px-4 py-2 w-100 text-center" href="src/auth/cadastro/">
                            <i class="bi bi-person-plus"></i> CADASTRE-SE
                        </a>
                        <a class="btn btn-primary rounded-pill px-4 py-2 text-white w-100 text-center" href="src/auth/entrar/">
                            <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <section class="carrosel">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/familia-segura.jpg" class="d-block w-100" alt="Logo Vacinas" style="margin-top: 4%;">
                </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-4">Proteja-se com Minhas Vacinas</h1>
            <p class="lead text-muted mb-4">Mantenha seu histórico de vacinação sempre atualizado com praticidade.</p>
            <div class="d-flex flex-wrap justify-content-center gap-4">
                <div class="card p-2 border border-2 shadow-sm animate__animated animate__fadeIn"
                    style="max-width: 22%; min-width: 18rem; border-radius: 12px; transition: transform 0.3s;">
                    <img src="assets/img/iphone-mao.jpg" class="card-img-top rounded-top" alt="Gestão de Vacinas">
                    <div class="card-body text-center">
                        <h5 class="fw-semibold">Gestão de Vacinas</h5>
                        <p class="text-muted small">Controle suas vacinas de forma simples e organizada.</p>
                    </div>
                </div>
                <div class="card p-2 border border-2 shadow-sm animate__animated animate__fadeIn"
                    style="max-width: 22%; min-width: 18rem; border-radius: 12px; transition: transform 0.3s;">
                    <img src="assets/img/iphone-calendario.jpg" class="card-img-top rounded-top" alt="Lembretes Personalizados">
                    <div class="card-body text-center">
                        <h5 class="fw-semibold">Lembretes Personalizados</h5>
                        <p class="text-muted small">Receba notificações e nunca perca uma vacina!</p>
                    </div>
                </div>
                <div class="card p-2 border border-2 shadow-sm animate__animated animate__fadeIn"
                    style="max-width: 22%; min-width: 18rem; border-radius: 12px; transition: transform 0.3s;">
                    <img src="assets/img/vacina.jpg" class="card-img-top rounded-top" alt="Informações sobre Imunizações">
                    <div class="card-body text-center">
                        <h5 class="fw-semibold">Informações Atualizadas</h5>
                        <p class="text-muted small">Saiba tudo sobre vacinas e campanhas de imunização.</p>
                    </div>
                </div>
                <div class="card p-2 border border-2 shadow-sm animate__animated animate__fadeIn"
                    style="max-width: 22%; min-width: 18rem; border-radius: 12px; transition: transform 0.3s;">
                    <img src="assets/img/familia-segura.jpg" class="card-img-top rounded-top" alt="Proteja Sua Família">
                    <div class="card-body text-center">
                        <h5 class="fw-semibold">Proteja Sua Família</h5>
                        <p class="text-muted small">Mantenha todos seguros com um histórico atualizado.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div style="height: 50px;"></div>

    <section class="bg-secondary py-5">
        <div class="container text-center">
            <h2 class="mb-5 animate__animated animate__fadeInDown">Recursos Essenciais e Proteção</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="feature-block shadow-lg animate__animated animate__fadeInUp p-4 w-100 h-100 d-flex flex-column">
                        <div class="icon-container bg-success text-white">
                            <i class="bi bi-shield-lock" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mt-3">Registro Digital de Vacinas</h4>
                        <p class="text-muted flex-grow-1">Mantenha um digital seguro de todas as vacinas da sua família. Isso facilita o acompanhamento da imunização e o acesso a informações importantes.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="feature-block shadow-lg animate__animated animate__fadeInUp p-4 w-100 h-100 d-flex flex-column">
                        <div class="icon-container bg-warning text-white">
                            <i class="bi bi-bell" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mt-3">Alertas de Vacinação</h4>
                        <p class="text-muted flex-grow-1">Obtenha relatórios detalhados sobre o estado das suas vacinas, ajudando você a entender o que está em dia e o que precisa ser atualizado.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="feature-block shadow-lg animate__animated animate__fadeInUp p-4 w-100 h-100 d-flex flex-column">
                        <div class="icon-container bg-info text-white">
                            <i class="bi bi-file-earmark-text" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mt-3">Cartão de Vacinação Digital</h4>
                        <p class="text-muted flex-grow-1">Carregue seu cartão de vacinação no celular, facilitando o acesso às informações em qualquer lugar e a qualquer momento.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="feature-block shadow-lg animate__animated animate__fadeInUp p-4 w-100 h-100 d-flex flex-column">
                        <div class="icon-container bg-danger text-white">
                            <i class="bi bi-heart" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mt-3">Proteja Sua Família</h4>
                        <p class="text-muted flex-grow-1">Mantenha o histórico de vacinação da sua família sempre atualizado, organizado, acessível e seguro.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="feature-block shadow-lg animate__animated animate__fadeInUp p-4 w-100 h-100 d-flex flex-column">
                        <div class="icon-container bg-primary text-white">
                            <i class="bi bi-book" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mt-3">Dicas de Cuidados Pós-Vacinação</h4>
                        <p class="text-muted flex-grow-1">Receba dicas sobre cuidados pós-vacinação e garanta uma recuperação tranquila.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="feature-block shadow-lg animate__animated animate__fadeInUp p-4 w-100 h-100 d-flex flex-column">
                        <div class="icon-container bg-info text-white">
                            <i class="bi bi-calendar-event" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mt-3">Campanhas de Vacinação</h4>
                        <p class="text-muted flex-grow-1">Receba dicas sobre cuidados pós-vacinação para garantir uma recuperação tranquila e saudável.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-dark text-white py-5">
        <div class="container text-center">
            <h2 class="mb-5 animate__animated animate__fadeInDown">Recursos Essenciais e Proteção</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <div class="col">
                    <div class="resource-block shadow-lg animate__animated animate__fadeInUp">
                        <dotlottie-player
                            src="https://lottie.host/241a629f-5fb6-43f9-b6fe-8a45d8b3de5b/gQf9kyQpqN.lottie"
                            background="transparent"
                            speed="1"
                            style="width: 80px; height: 80px; margin: 0 auto;"
                            loop autoplay>
                        </dotlottie-player>
                        <h4 class="mt-3">Segurança de Dados</h4>
                        <p class="text-white">Protegemos suas informações com sistemas de segurança avançados para garantir que seus dados permaneçam seguros.</p>
                    </div>
                </div>

                <div class="col">
                    <div class="resource-block shadow-lg animate__animated animate__fadeInUp">
                        <dotlottie-player
                            src="https://lottie.host/30f70f44-49b1-4f1f-b679-3d722eba500c/AqWeHVKtjF.lottie"
                            background="transparent"
                            speed="1"
                            style="width: 80px; height: 80px; margin: 0 auto;"
                            loop autoplay>
                        </dotlottie-player>
                        <h4 class="mt-3">Criptografia de Dados</h4>
                        <p class="text-white">Utilizamos criptografia de ponta para garantir que seus dados sensíveis permaneçam confidenciais e protegidos.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="resource-block shadow-lg animate__animated animate__fadeInUp">
                        <dotlottie-player
                            src="https://lottie.host/3187dfa0-5b8a-42c3-83c1-de7a49a03c74/yfecr5ccaw.lottie"
                            background="transparent"
                            speed="1"
                            style="width: 80px; height: 80px; margin: 0 auto;"
                            loop autoplay>
                        </dotlottie-player>
                        <h4 class="mt-3">Armazenamento Seguro em Nuvem</h4>
                        <p class="text-white">Seus dados são armazenados em servidores seguros na nuvem, garantindo fácil acesso e proteção contínua.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="bg-success text-white py-5" id="nossa-missao">
        <div class="container text-center">
            <h2 class="mb-4">A Nossa Missão</h2>
            <p class="lead">Minhas Vacinas, nossa missão é promover a saúde e o bem-estar da comunidade através da
                conscientização sobre a importância da vacinação. Buscamos garantir que todos tenham acesso a
                informações atualizadas e precisas, facilitando o gerenciamento do histórico de vacinas e incentivando a
                proteção de todos.</p>
            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>Compromisso com a Educação</h5>
                    <p>Educamos sobre as vacinas e suas contribuições para a saúde pública, empoderando as pessoas a
                        tomarem decisões informadas.</p>
                </div>
                <div class="col-md-6">
                    <h5>Acesso a Informações</h5>
                    <p>Oferecemos uma plataforma acessível onde os usuários podem encontrar dados confiáveis sobre
                        vacinação e campanhas.</p>
                </div>
            </div>
        </div>
    </section>

    <button id="scrollToTopBtn" class="scroll-to-top">
        <span>&#8593;</span>
    </button>

    <div id="cookieNotice" class="cookie-notice">
        <p>Usamos cookies para melhorar sua experiência. Ao continuar, você aceita nossa <a href="docs/Politica-de-Privacidade.php">Política de privacidade</a>.
        <p>
            <button id="acceptCookies" class="cookie-accept-btn">Aceitar</button>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js').then((registration) => {
                    console.log('Service Worker registrado com sucesso:', registration);
                }).catch((error) => {
                    console.log('Erro ao registrar o Service Worker:', error);
                });
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <script src="script.js"></script>

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px;" id="footer">
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3" style="padding-bottom: 5%;">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="bi bi-gem me-2"></i>Minhas Vacinas
                    </h6>
                    <p>
                        <i class="bi bi-info-circle me-1"></i> Protegendo você e sua família com informações e
                        controle digital de vacinas.
                    </p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Serviços</h6>
                    <p>
                        <a href="/src/auth/cadastro/" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Cadastro</a>
                    </p>
                    <p>
                        <a href="/src/ajuda/" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Suporte</a>
                    </p>
                    <p>
                        <a href="/src/painel/" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Histórico</a>
                    </p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Links Úteis</h6>
                    <p>
                        <a href="docs/Politica-de-Privacidade.php" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Política de Privacidade</a>
                    </p>
                    <p>
                        <a href="docs/Termos-de-Servico.php" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Termos de Serviço</a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Receba novidades</h6>
                    <p>Inscreva-se para receber novidades sobre campanhas de vacinação, novidade e futuras atualizações.</p>
                    <form action="" method="POST">
                        <label for="">Seu-email</label>
                        <input type="email" name="email" class="form-control mb-2" style="background-color: #181a1b; color: #f8f9fa;" required>
                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                        <?php if (isset($_GET['status'])): ?>
                            <p style="color: <?php echo $_GET['status'] === 'sucesso' ? 'green' : 'red'; ?>; margin-top: 10px;">
                                <?php echo $_GET['status'] === 'sucesso' ? 'Sucesso!' : 'Erro! Tente novamente.'; ?>
                            </p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center p-4" style="background-color: #181a1b; color: #adb5bd;">
            © 2025 Minhas Vacinas. Todos os direitos reservados.
        </div>
    </footer>
</body>


</body>

</html>