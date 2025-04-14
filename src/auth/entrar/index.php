<?php
require_once '../../../vendor/autoload.php';

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../../painel/");
    exit();
}


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Minhas Vacinas - Entrar</title>
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
                        <li class="nav-item"><a href="../../ajuda/" class="nav-link">Suporte</a></li>
                        <li class="nav-item"><a href="../../FAQ/" class="nav-link">FAQ</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-primary rounded-pill px-4 py-2 text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person text-dark"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="../painel/"><i class="bi bi-house-door text-dark me-2"></i>Painel</a></li>
                                    <li><a class="dropdown-item" href="../painel/vacinas/"><i class="bi bi-heart-pulse-fill text-dark me-2"></i>Vacinas</a></li>
                                    <li><a class="dropdown-item" href="../painel/perfil/"><i class="bi bi-person-circle text-dark me-2"></i>Perfil</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white" href="../cadastro/">
                                    <i class="bi bi-person-plus"></i> CADASTRE-SE
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 75%; background: rgba(255, 255, 255, 0.95);">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between" style="height: 100%;">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/" style="font-weight: 500;">
                            <i class="bi bi-house-door text-dark me-2"></i>Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/#nossa-missao" style="font-weight: 500;">
                            <i class="bi bi-info-circle text-dark me-2"></i>Sobre
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../ajuda/" class="nav-link text-dark" style="font-weight: 500;">
                            <i class="bi bi-question-circle text-dark me-2"></i>Suporte
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../FAQ/" class="nav-link text-dark" style="font-weight: 500;">
                            <i class="bi bi-file-earmark-text text-dark me-2"></i>FAQ
                        </a>
                    </li>
                </ul>
                <div class="d-flex flex-column align-items-center gap-3 mt-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="nav-link dropdown-toggle btn btn-outline-primary rounded-pill px-4 py-2 w-100 text-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person text-dark"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../painel/"><i class="bi bi-house-door text-dark me-2"></i>Painel</a></li>
                            <li><a class="dropdown-item" href="../painel/vacinas/"><i class="bi bi-heart-pulse-fill text-dark me-2"></i>Vacinas</a></li>
                            <li><a class="dropdown-item" href="../painel/perfil/"><i class="bi bi-person-circle text-dark me-2"></i>Perfil</a></li>
                        </ul>
                    <?php else: ?>
                        <a class="btn btn-primary rounded-pill px-4 py-2 text-white w-100 text-center" href="../cadastro/">
                            <i class="bi bi-person-plus"></i> CADASTRE-SE
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <section class="form-log custom-section">
        <div class="container mt-5 rounded-pill">
            <h4 class="mb-4 text-center" style="margin-top: 10%;">
                Entre na sua conta <i class="bi bi-box-arrow-in-right me-2"></i>
            </h4>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <p class="text-muted mb-0 me-3">Entre com:</p>
                                <div id="g_id_onload"
                                    data-client_id="<?= $_ENV['GOOGLE_ID_CLIENT'] ?>"
                                    data-context="signup"
                                    data-ux_mode="redirect"
                                    data-login_uri="<?= $_ENV['GOOGLE_REDIRECT_LOGIN_DEV'] ?>"
                                    data-nonce=""
                                    data-auto_prompt="false">
                                </div>
                                <div class="g_id_signin"
                                    data-type="icon"
                                    data-shape="circle"
                                    data-theme="outline"
                                    data-size="large">
                                </div>
                            </div>
                            <hr class="my-3 mx-4" style="border-top: 2px solid #353535;" />
                            <p class="text-muted text-center mb-0">Ou preencha seus dados abaixo</p>
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
                                    <label for="email" class="form-label text-dark font-weight-semibold">E-mail<span class="required-asterisk">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                                </div>
                                <div class=" mb-4">
                                    <label for="senha" class="form-label text-dark font-weight-semibold">Senha<span class="required-asterisk">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="senha" name="senha" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <a href="../esqueceu-senha/" class="text-dark font-weight-medium">
                                            <i class="bi bi-question-circle me-1"></i>ESQUECEU A SENHA?
                                        </a>
                                    </div>
                                </div>
                                <button class="btn btn-dark w-100 py-2 text-uppercase font-weight-bold" type="submit" id="submitBtn">
                                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                                    <span class="spinner-border spinner-border-sm text-light" id="loadingSpinner" role="status" aria-hidden="true" style="display: none;"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <hr class="custom-hr">
                        <p class="mb-1 text-dark">Ainda não tem uma conta?</p>
                        <a href="../cadastro/" class="text-primary" style="text-decoration: none;">
                            <i class="bi bi-person-plus me-2"></i> Cadastre-se
                        </a>
                    </div>
                    <div class="text-center mt-4">
                        <p class="mb-1 text-dark">Precisa confirmar o cadastro?</p>
                        <a href="../confirmar-cadastro/" class="text-primary" style="text-decoration: none;">
                            <i class="bi bi-check-circle"></i> Confirme o cadastro
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
                        <a href="../../../docs/Politica-de-Privacidade.php"
                            style="text-decoration: none; color: #adb5bd;" class="text-reset">Política de
                            Privacidade</a>
                    </p>
                    <p>
                        <a href="../../../docs/Termos-de-Servico.php" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Termos de Serviço</a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Contato</h6>
                    <p><i class="bi bi-envelope me-2"></i>contato@minhasvacinas.online</p>
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
</body>

</html>