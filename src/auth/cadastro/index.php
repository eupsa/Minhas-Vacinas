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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Minhas Vacinas - Cadastro</title>
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
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white" href="../entrar/">
                                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR
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
                        <a class="btn btn-primary rounded-pill px-4 py-2 text-white w-100 text-center" href="../entrar/">
                            <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <section class="form-log custom-section">
        <div class="container mt-5 rounded">
            <h4 class="mb-4 text-center" style="margin-top: 10%;">
                Faça seu cadastro <i class="bi bi-person-plus me-2"></i>
            </h4>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg shadow-lg p-3 mb-5 bg-white">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center align-items-center">
                                <div id="g_id_onload"
                                    data-client_id="14152276280-9pbtedkdibk5rsktetmnh32rap49a8jm.apps.googleusercontent.com"
                                    data-context="signup"
                                    data-ux_mode="redirect"
                                    data-login_uri="www.minhasvacinas.online\src\auth\backend\cadastro-google.php"
                                    data-nonce=""
                                    data-auto_prompt="false">
                                </div>
                                <div class="g_id_signin"
                                    data-type="icon"
                                    data-shape="circle"
                                    data-theme="outline"
                                    data-text="signup_with"
                                    data-size="large">
                                </div>
                            </div><br>
                            <div class="text-center mb-4">
                                <p class="text-muted">Cadastre-se com <i class="bi bi-google"></i></p>
                                <hr class="my-4">
                                <p class="text-muted">Ou preencha seus dados abaixo</p>
                            </div>
                            <?php
                            if (isset($_SESSION['erro_email'])) {
                                echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['erro_email'] . "</div>";
                                unset($_SESSION['erro_email']);
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['sucesso_email'])) {
                                echo "<div class='alert alert-success' role='alert'>Cadastro realizado com sucesso!</div>";
                                unset($_SESSION['sucesso_email']);
                            }
                            ?>
                            <form action="../backend/cadastro.php" class="needs-validation" id="formcad" method="post" novalidate>
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome<span class="required-asterisk">*</span></label>
                                    <input type="text" class="form-control" id="nome" name="nome" autocomplete="new-password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-dark font-weight-semibold">E-mail<span class="required-asterisk">*</span></label>
                                    <input type="email" class="form-control" name="email" required autocomplete="new-password">
                                </div>
                                <div class="mb-3">
                                    <label for="senha" class="form-label text-dark font-weight-semibold">Senha<span class="required-asterisk">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="senha" name="senha" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="confSenha" class="form-label text-dark font-weight-semibold">Confirme sua senha<span class="required-asterisk">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confSenha" name="confSenha" required>
                                        <button class="btn btn-outline-secondary" type="button" id="ConftogglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="estado" class="form-label">Estado<span class="required-asterisk">*</span></label>
                                    <input class="form-control" list="datalistOptions" id="exampleDataList" name="estado" placeholder="Selecione seu estado...">
                                    <datalist id="datalistOptions" name="estado">
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </datalist>
                                </div>
                                <div class="form-check mt-4 mb-4">
                                    <input type="checkbox" class="form-check-input" id="termsCheckbox" style="margin-top: 5px;" required>
                                    <label class="form-check-label text-dark ms-2" for="termsCheckbox">
                                        Eu li e aceito os <a href="/docs/Termos-de-Servico.php" class="text-primary" target="_blank" style="text-decoration: none;">Termos de Serviço</a> e a <a href="/docs/Politica-de-Privacidade.php" class="text-primary" target="_blank" style="text-decoration: none;">Política de Privacidade</a>.
                                    </label>
                                </div>
                                <button class="btn btn-dark w-100 py-2 text-uppercase font-weight-bold" type="submit">
                                    <i class="bi bi-person-plus"></i> CADASTRAR
                                    <span class="spinner-border spinner-border-sm text-light" id="loadingSpinner" role="status" aria-hidden="true" style="display: none;"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <hr class="custom-hr">
                        <p class="mb-1 text-dark">Já tem uma conta?</p>
                        <a href="../entrar/" class="text-primary" style="text-decoration: none;">
                            <i class="bi bi-door-open"></i> Entrar
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="script.js"></script>
</body>

</html>