<!DOCTYPE html>
<html lang="pt-br">

<head>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const darkModePreference = localStorage.getItem('darkMode') === 'enabled';
            if (darkModePreference) {
                document.documentElement.style.backgroundColor = "#121212";
                document.documentElement.style.color = "#ffffff";
                document.body.classList.add('dark-mode');
            }
        });
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/assets/img/logo-head.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Minhas Vacinas - Ajuda</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            DarkReader.setFetchMethod(window.fetch);

            function toggleDarkMode(isChecked = null) {
                const darkModeSwitch = document.getElementById('darkModeSwitch');
                const enableDarkMode = isChecked !== null ? isChecked : darkModeSwitch.checked;

                if (enableDarkMode) {
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
            }

            // Aplica a preferência de modo escuro ao carregar a página
            const darkModePreference = localStorage.getItem('darkMode') === 'enabled';
            toggleDarkMode(darkModePreference);
            const darkModeSwitch = document.getElementById('darkModeSwitch');
            if (darkModeSwitch) {
                darkModeSwitch.checked = darkModePreference;
                darkModeSwitch.addEventListener('change', function() {
                    toggleDarkMode(darkModeSwitch.checked);
                });
            }
        });
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top"
            style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
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
                            <a href="" onclick="Location.reload()" class="nav-link">Suporte</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
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
                            <li class="nav-item">
                                <a class="btn btn-light text-primary rounded-pill px-4 py-2 transition-transform transform-hover" style="margin-right: 10px;" href="../auth/cadastro/">
                                    <i class="bi bi-person-plus"></i> CADASTRE-SE
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white transition-transform transform-hover" href="../auth/entrar/">
                                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav">
                        <li style="margin-left: 20px; margin-top: 2%;">
                            <div id="themeToggle" class="theme-toggle d-flex align-items-center" style="cursor: pointer;">
                                <i class="bi bi-sun" id="sunIcon" style="font-size: 1.2em;"></i>
                                <i class="bi bi-moon" id="moonIcon" style="font-size: 1.2em; display: none;"></i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel"
            style="position: fixed; top: 0; left: 0; z-index: 1100;">
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
                        <a href="src/ajuda/" class="nav-link">Suporte</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['session_id'])): ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="../painel/">
                                <i class="bi bi-arrow-return-left me-2"></i> Voltar à sua conta
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="../auth/cadastro/">CADASTRE-SE</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary w-100 mb-2 rounded-pill px-3 py-1 text-white transition-transform transform-hover" href="../auth/entrar/">ENTRAR</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>

    <section class="pt-5 pb-5">
        <div class="container mt-5">
            <h4 class="mb-4 text-center">Entre em contato</h4>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5" style="background-color: #f8f9fa;">
                            <form id="form_suporte" class="needs-validation" novalidate action="backend/suporte.php" method="post">
                                <div class="mb-4">
                                    <label for="suporte_nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control rounded-pill" id="suporte_nome" name="suporte_nome" required>
                                </div>
                                <div class="mb-4">
                                    <label for="suporte_email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control rounded-pill" id="suporte_email" name="suporte_email" required>
                                </div>
                                <div class="mb-4">
                                    <label for="motivo_contato" class="form-label">Motivo do Contato</label>
                                    <select class="form-select rounded-pill" id="motivo_contato" name="motivo_contato" required>
                                        <option value="" disabled selected>Selecione o motivo</option>
                                        <option value="problema_tecnico">Problema técnico</option>
                                        <option value="duvida">Dúvida</option>
                                        <option value="sugestao">Sugestão</option>
                                        <option value="reclamacao">Reclamação</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="mensagem" class="form-label">Mensagem</label>
                                    <textarea class="form-control rounded" id="mensagem" name="mensagem" rows="4" placeholder="Escreva sua mensagem aqui..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">
                                    <i class="bi bi-send"></i> Enviar
                                </button>
                            </form>
                            <div id="resposta-container"></div>
                        </div>
                    </div>
                    <p class="text-center text-white mt-4">Responderemos sua mensagem o mais rápido possível.</p>
                </div>
            </div>
        </div>
    </section>


    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px;">
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
    <script src="https://cdn.jsdelivr.net/npm/darkreader"></script>
    <script src="script.js"></script>
    <script src="../../assets/js/dark-reader.js"></script>
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