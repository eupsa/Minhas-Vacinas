<?php
session_start();
require 'src/scripts/conn.php';

// $host = $_SERVER['HTTP_HOST'];

// if ($host === 'minhasvacinas.online' || $host === 'www.minhasvacinas.online') {
//     echo '
//     <!DOCTYPE html>
//     <html lang="pt-BR">
//     <head>
//         <meta charset="UTF-8">
//         <meta name="viewport" content="width=device-width, initial-scale=1.0">
//         <title>Redirecionando...</title>
//         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
//     </head>
//     <body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
//         <div class="text-center p-5 bg-white rounded shadow-sm">
//             <h1 class="text-danger">Atenção!</h1>
//             <p class="lead">Você está sendo redirecionado para o novo site: <strong>vacinasdigital.com</strong>.</p>
//             <p>Se não for redirecionado automaticamente, <a href="https://vacinasdigital.com" class="btn btn-primary">clique aqui</a>.</p>
//             <p class="text-muted">Aguarde <span id="countdown">3</span> segundos...</p>
//         </div>

//         <script>
//             var countdown = document.getElementById("countdown");
//             var seconds = 3;
//             var interval = setInterval(function() {
//                 seconds--;
//                 countdown.textContent = seconds;
//                 if (seconds <= 0) {
//                     clearInterval(interval);
//                     window.location.href = "https://vacinasdigital.com";
//                 }
//             }, 1000);
//         </script>
//     </body>
//     </html>
//     ';

//     exit();
// }

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



$repoOwner = 'psilvagg';
$repoName = 'app-minhas-vacinas';
$token = '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';

$url = "https://api.github.com/repos/$repoOwner/$repoName/releases/latest";

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'User-Agent: MinhasVacinas-App',
    "Authorization: Bearer $token"
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode === 200 && $response) {
    $data = json_decode($response, true);
    $latestVersion = $data['tag_name'] ?? 'Versão não encontrada';
} elseif ($httpCode === 401) {
    $latestVersion = 'Erro: Não autorizado. Verifique o token.';
} elseif ($httpCode === 404) {
    $latestVersion = 'Erro: Repositório não encontrado.';
} else {
    $latestVersion = 'Erro ao buscar versão';
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="manifest" href="manifest.json">
    <!-- SEO Metadata -->
    <meta name="description" content="Minhas Vacinas - A plataforma para gestão e controle do histórico de vacinação. Organize suas vacinas, receba alertas e informações sobre imunizações." />
    <link rel="canonical" href="https://www.minhasvacinas.online/" />
    <meta property="og:locale" content="pt_BR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Minhas Vacinas - Gestão de Vacinas" />
    <meta property="og:description" content="Minhas Vacinas - A plataforma para gestão e controle do histórico de vacinação. Organize suas vacinas, receba alertas e informações sobre imunizações." />
    <meta property="og:url" content="https://www.minhasvacinas.online/" />
    <meta property="og:site_name" content="Minhas Vacinas" />
    <meta property="article:publisher" content="https://facebook.com/minhasvacinas" />
    <meta property="article:modified_time" content="2025-01-13T00:00:00+00:00" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@pssilvagg" />
    <meta name="twitter:title" content="Minhas Vacinas - Gestão de Vacinas" />
    <meta name="twitter:description" content="Minhas Vacinas - A plataforma para gestão e controle do histórico de vacinação. Organize suas vacinas, receba alertas e informações sobre imunizações." />
    <meta name="twitter:image" content="https://vacinasdigital.com/assets/img/banner-coracao.png" />
    <meta name="robots" content="index, follow">
    <title>Minhas Vacinas</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#nossa-missao">Sobre</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="Swal.fire({
                            title: '🚧 O site está passando por modificações importantes!',
                            text: 'Algumas funcionalidades podem não estar disponíveis. Por favor, tente novamente mais tarde.',
                            icon: 'warning'
                        }); return false;" class="nav-link">Campanhas</a>
                        </li>
                        <li class="nav-item">
                            <a href="src/ajuda/" class="nav-link">Suporte</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-download"></i> Baixe o App
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="https://github.com/psilvagg/app-minhas-vacinas/releases/latest" target="_blank">
                                        <i class="bi bi-github"></i> Release no GitHub
                                        <span class="badge bg-warning text-dark ms-2"><?php echo htmlspecialchars($latestVersion); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <?php if (isset($_SESSION['session_id'])): ?>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white transition-transform transform-hover" href="src/painel/">
                                    <i class="bi bi-arrow-return-left"></i> Voltar à sua conta
                                </a>
                            </li>
                            <li class="nav-item" style="margin-left: 10px;">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white transition-transform transform-hover" href="src/scripts/sair.php">
                                    <i class="bi bi-box-arrow-left"></i>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item me-3">
                                <a class="btn btn-light text-primary rounded-pill px-4 py-2 transition-transform transform-hover" href="src/auth/cadastro/">
                                    <i class="bi bi-person-plus"></i> CADASTRE-SE
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white transition-transform transform-hover" href="src/auth/entrar/">
                                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="carrosel">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/familia-segura.jpg" class="d-block w-100" alt="Logo Vacinas" style="margin-top: 4%;">
                </div>
    </section>

    <section>
        <h1 class="text-center my-4 display-4">Proteja-se com Minhas Vacinas: Vacinas na Palma da Sua Mão!</h1>
        <p class="text-center lead">Descubra a importância de manter seu histórico de vacinação sempre atualizado.</p>
        <div class="d-flex flex-wrap justify-content-center">
            <div class="card m-2 animate__animated animate__fadeIn" style="width: 18rem;">
                <img src="assets/img/iphone-mao.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Gestão de Vacinas</h5>
                    <p class="card-text">Mantenha o controle de todas as suas vacinas em um só lugar.</p>
                </div>
            </div>
            <div class="card m-2 animate__animated animate__fadeIn" style="width: 18rem;">
                <img src="assets/img/iphone-calendario.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Lembretes Personalizados</h5>
                    <p class="card-text">Receba notificações sobre suas próximas vacinas para não perder nenhuma!</p>
                </div>
            </div>
            <div class="card m-2 animate__animated animate__fadeIn" style="width: 18rem;">
                <img src="assets/img/vacina.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Informações sobre Imunizações</h5>
                    <p class="card-text">Acesse informações atualizadas e confiáveis sobre as vacinas e receba alertas
                        sobre campanhas de vacinação perto de você.</p>
                </div>
            </div>
            <div class="card m-2 animate__animated animate__fadeIn" style="width: 18rem;">
                <img src="assets/img/familia-segura.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Proteja Sua Família</h5>
                    <p class="card-text">Garanta a saúde de quem você ama com um histórico de vacinação sempre
                        atualizado.</p>
                </div>
            </div>
        </div>
    </section>

    <div style="height: 50px;"></div>

    <section class="bg-secondary py-5">
        <div class="container text-center">
            <h2 class="mb-4 text-white animate__animated animate__fadeInDown">O que a nossa plataforma oferta?</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <div class="col">
                    <div class="card h-100 shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-shield-lock text-success" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Registro Digital de Vacinas</h5>
                            <p class="card-text">Mantenha digital seguro de todas as vacinas de sua família.
                                Isso facilita o acompanhamento da imunização e o acesso a informações importantes.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-bell text-warning" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Alertas de Vacinação</h5>
                            <p class="card-text">Obtenha relatórios detalhados sobre o estado das suas vacinas, ajudando
                                você a entender o que está em dia e o que precisa ser atualizado.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-file-earmark-text text-info" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Cartão de Vacinação Digital</h5>
                            <p class="card-text">Carregue seu cartão de vacinação no celular, facilitando o acesso às
                                informações em qualquer lugar e a qualquer momento.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-heart text-danger" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Proteja Sua Família</h5>
                            <p class="card-text">Mantenha o histórico de vacinação da sua família sempre atualizado,
                                organizado, acessível e seguro.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-book text-primary" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Dicas de Cuidados Pós-Vacinação</h5>
                            <p class="card-text">Receba dicas sobre cuidados pós-vacinação e garanta uma recuperação
                                tranquila.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-calendar-event text-info" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Campanhas de Vacinação</h5>
                            <p class="card-text">Receba dicas sobre cuidados pós-vacinação para garantir uma recuperação
                                tranquila e saudável.
                            </p>
                        </div>
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

    <script src="assets/js/script.js"></script>

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

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px;" id="footer">
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">
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
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Seu e-mail" style="background-color: #181a1b; color: #f8f9fa;" required>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
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