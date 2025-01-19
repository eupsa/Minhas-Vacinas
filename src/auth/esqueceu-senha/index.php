<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3472234536437513"
        crossorigin="anonymous"></script>
    <title>Minhas Vacinas - Recuperação de Senha</title>
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
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white transition-transform transform-hover" href="../entrar/">
                                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR
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

    <section class="form-log">
        <div class="container d-flex justify-content-center align-items-center full-height" style="margin-top: 30px;" style="background-color: #f8f9fa;">
            <div class="row w-100">
                <h4 class="mb-4 text-center"> Redefina sua senha</h4>
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <form action="../backend/esqueceu-senha.php" class="needs-validation bg-light p-5 rounded shadow-lg" id="form_recovery" method="post" novalidate>
                        </h4>
                        <div id="passwordHelpBlock" class="form-text mb-3">
                            <i class="bi bi-info-circle me-2"></i> Após o envio do formulário, você receberá um e-mail com instruções para redefinir sua senha.
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark font-weight-semibold">E-mail</label>
                            <div class="input-group">
                                <input type="email" class="form-control rounded-pill" id="email" name="email" required" autocomplete="off">
                            </div>
                        </div>
                        <div class="mt-2 text-end">
                            <a href="../entrar/" class="text-muted">
                                <i class="bi bi-arrow-left-circle me-1"></i> Voltar para login?
                            </a>
                        </div>
                        <button class="btn btn-dark w-100 py-2 rounded-pill mt-3" type="submit">
                            <i class="bi bi-key-fill me-2"></i> Redefinir senha
                        </button>
                    </form>
                    <hr class="custom-hr">
                </div>
            </div>
        </div>
    </section>

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px; margin-top: -5%;">
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
            © 2024 Minhas Vacinas. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="../../../assets/js/dark-reader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/darkreader"></script>
    <script src="../../../block.js"></script>

    <script>
        DarkReader.setFetchMethod(window.fetch);

        const checkDarkModePreference = () => {
            return localStorage.getItem('darkMode') === 'enabled';
        };

        const darkModeSwitch = document.getElementById('darkModeSwitch');

        if (checkDarkModePreference()) {
            DarkReader.enable({
                brightness: 90,
                contrast: 110,
                sepia: 0
            });
            darkModeSwitch.checked = true;
        }

        darkModeSwitch.addEventListener('change', (e) => {
            if (e.target.checked) {
                DarkReader.enable({
                    brightness: 90,
                    contrast: 110,
                    sepia: 0
                });
                localStorage.setItem('darkMode', 'enabled');
            } else {
                DarkReader.disable();
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    </script>
</body>

</html>