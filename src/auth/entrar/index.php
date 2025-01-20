<?php
session_start();
if (isset($_SESSION['session_id'])) {
    header("Location: ../../painel/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Minhas Vacinas - Entrar</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
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
                            <a href="../../ajuda/" class="nav-link">Suporte</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['session_id'])): ?>
                            <li class="nav-item">
                                <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="../../painel/">
                                    <i class="bi bi-arrow-return-left me-2"></i> Voltar à sua conta
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="btn btn-light text-primary rounded-pill px-4 py-2 transition-transform transform-hover" style="margin-right: 10px;" href="../cadastro/">
                                    <i class="bi bi-person-plus"></i> CADASTRE-SE
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
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

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="position: fixed; top: 0; left: 0; z-index: 1100;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#nossa-missao">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="Swal.fire({
                        title: '🚧 O site está passando por modificações importantes!',
                        text: 'Algumas funcionalidades podem não estar disponíveis. Por favor, tente novamente mais tarde.',
                        icon: 'warning'
                    }); return false;" class="nav-link">Campanhas</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../ajuda/" class="nav-link">Suporte</a>
                    </li>
                    <li class="nav-item dropdown">
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="https://www.apple.com/br/app-store/">
                                    <img src="https://api.iconify.design/logos:apple-app-store.svg" alt="App Store" style="width: 20px; height: 20px;" class="me-2"> App Store
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="https://play.google.com/">
                                    <img src="https://api.iconify.design/logos:google-play-icon.svg" alt="Google Play" style="width: 20px; height: 20px;" class="me-2"> Google Play
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['session_id'])): ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="../../painel/">
                                <i class="bi bi-arrow-return-left me-2"></i> Voltar à sua conta
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="../cadastro/">CADASTRE-SE</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary w-100 mb-2 rounded-pill px-3 py-1 text-white transition-transform transform-hover" href="../entrar/">ENTRAR</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>

    <section class="form-log custom-section">
        <div class="container mt-5">
            <h4 class="mb-4 text-center" style="margin-top: 10%;">Entre na sua conta</h4>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body p-5" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-center align-items-center">
                                <div id="g_id_onload"
                                    data-client_id="14152276280-9pbtedkdibk5rsktetmnh32rap49a8jm.apps.googleusercontent.com"
                                    data-login_uri="https://vacinasdigital.com/src/auth/backend/login-google.php"
                                    data-auto_prompt="false">
                                </div>
                                <div class="g_id_signin custom-google-btn"
                                    data-type="standard"
                                    data-size="medium"
                                    data-theme="filled_blue"
                                    data-text="signu_with_google"
                                    data-shape="circle"
                                    data-logo_alignment="left"
                                    style="transform: scale(1.1);">
                                </div>
                            </div><br>
                            <?php
                            if (isset($_SESSION['erro_email'])) {
                                echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['erro_email'] . "</div>";
                                unset($_SESSION['erro_email']);
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['sucesso-email'])) {
                                echo "<div class='alert alert-sucess' role='alert'>" . $_SESSION['sucesso-email'] . "</div>";
                                unset($_SESSION['sucesso-email']);
                            }
                            ?>
                            <form action="../backend/entrar.php" class="needs-validation" id="form_login" method="post" novalidate>
                                <div class="mb-4">
                                    <label for="email" class="form-label text-dark font-weight-semibold">E-mail</label>
                                    <input type="email" class="form-control rounded-pill" id="email" name="email" required autocomplete="off">
                                </div>
                                <div class=" mb-4">
                                    <label for="senha" class="form-label text-dark font-weight-semibold">Senha</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control rounded-pill" id="senha" name="senha" required>
                                        <button class="btn btn-outline-secondary rounded-pill" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <a href="../esqueceu-senha/" class="text-dark font-weight-medium">
                                            <i class="bi bi-question-circle me-1"></i> Esqueceu a senha?
                                        </a>
                                    </div>
                                </div>
                                <button class="btn btn-dark w-100 py-2 rounded-pill text-uppercase font-weight-bold" type="submit" id="submitBtn">
                                    <i class="fas fa-door-open"></i> ENTRAR
                                    <span class="spinner-border spinner-border-sm text-light" id="loadingSpinner" role="status" aria-hidden="true" style="display: none;"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <hr class="custom-hr">
                        <p class="mb-1 text-dark">Ainda não tem uma conta?</p>
                        <a href="../cadastro/" class="text-primary" style="text-decoration: none;">
                            <i class="bi bi-person-plus me-2"></i> Faça seu registro aqui
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px; margin-top: 3%;">
        <div class="me-5 d-none d-lg-block"></div>
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
                        <a href="/src/auth/cadastro/" style="text-decoration: none; color: #adb5bd;" class="text-reset">Cadastro</a>
                    </p>
                    <p>
                        <a href="/src/ajuda/" style="text-decoration: none; color: #adb5bd;" class="text-reset">Suporte</a>
                    </p>
                    <p>
                        <a href="/src/painel/" style="text-decoration: none; color: #adb5bd;" class="text-reset">Histórico</a>
                    </p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Links Úteis</h6>
                    <p>
                        <a href="../../../docs/Política-de-Privacidade.pdf"
                            style="text-decoration: none; color: #adb5bd;" class="text-reset">Política de
                            Privacidade</a>
                    </p>
                    <p>
                        <a href="../../../docs/Termos-de-Servico.pdf" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Termos de Serviço</a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Contato</h6>
                    <p><i class="bi bi-envelope me-2"></i>minhasvacinas@hotmail.com</p>
                </div>
            </div>
        </div>

        <div class="text-center p-4" style="background-color: #181a1b; color: #adb5bd;">
            © 2025 Minhas Vacinas. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://accounts.google.com/gsi/client" async></script>
    <script src="script.js"></script>
    <script src="../../../block.js"></script>
</body>

</html>