<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termos e Condições de Uso</title>
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin-top: 7%;
        }

        h1,
        h2 {
            text-align: center;
            color: #343a40;
        }

        section {
            background-color: #ffffff;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        p,
        ul {
            margin: 10px 0;
        }

        ul {
            padding-left: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

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
                        <a href="src/ajuda/" class="nav-link">Suporte</a>
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
                            <a class="btn btn-light text-primary rounded-pill px-4 py-2 transition-transform transform-hover" style="margin-right: 10px;" href="src/auth/cadastro/">
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
                <!-- <li class="nav-item">
                        <a class="nav-link" href="">Blog<span class="badge bg-success">novo</span></a>
                    </li> -->
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
                        <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="src/painel/">
                            <i class="bi bi-arrow-return-left me-2"></i> Voltar à sua conta
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="src/auth/cadastro/">CADASTRE-SE</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary w-100 mb-2 rounded-pill px-3 py-1 text-white transition-transform transform-hover" href="src/auth/entrar/">ENTRAR</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>

<body>
    <div class="container my-5">
        <h1 class="mb-4">Termos e Condições de Uso</h1>

        <section>
            <h2>1. Aceitação dos Termos</h2>
            <p>Bem-vindo ao site <strong>minhasvacinas.online</strong>. Ao acessar ou utilizar nossos serviços, você concorda em cumprir estes Termos e Condições de Uso. Caso não concorde com os Termos, não utilize o Site.</p>
        </section>

        <section>
            <h2>2. Objetivo do Site</h2>
            <p>O <strong>minhasvacinas.online</strong> é uma plataforma destinada à gestão de informações de vacinação. Os serviços oferecidos incluem o registro, consulta e gerenciamento de dados de imunização.</p>
        </section>

        <section>
            <h2>3. Cadastro</h2>
            <h3 class="text-center">3.1 Elegibilidade</h3>
            <ul>
                <li>Ter pelo menos 18 anos ou estar sob a supervisão de um responsável legal.</li>
                <li>Fornecer informações verdadeiras, completas e atualizadas durante o cadastro.</li>
            </ul>
            <h3 class="text-center">3.2 Responsabilidade do Usuário</h3>
            <ul>
                <li>Garantir a segurança das credenciais de acesso.</li>
                <li>Informar imediatamente qualquer uso não autorizado de sua conta.</li>
            </ul>
        </section>

        <section>
            <h2>4. Uso do Site</h2>
            <h3 class="text-center">4.1 Restrições</h3>
            <ul>
                <li>É proibido utilizar o Site para fins ilegais ou não autorizados.</li>
                <li>Transmitir vírus ou outros códigos maliciosos.</li>
                <li>Realizar atividades que prejudiquem o funcionamento do site ou a experiência de outros usuários.</li>
            </ul>
            <h3 class="text-center">4.2 Suspensão ou Encerramento</h3>
            <p>Podemos suspender ou encerrar o acesso ao Site caso identifiquemos violações destes Termos.</p>
        </section>

        <section>
            <h2>5. Propriedade Intelectual</h2>
            <p>Todo o conteúdo do Site, incluindo textos, imagens, logos e códigos, é protegido por leis de propriedade intelectual. É proibido reproduzir, distribuir ou modificar qualquer conteúdo sem autorização prévia.</p>
        </section>

        <section>
            <h2>6. Limitação de Responsabilidade</h2>
            <p>O <strong>minhasvacinas.online</strong> não se responsabiliza por:</p>
            <ul>
                <li>Erros ou interrupções no serviço.</li>
                <li>Perdas ou danos causados pelo uso ou incapacidade de usar o Site.</li>
                <li>Dados incorretos fornecidos pelos usuários.</li>
            </ul>
        </section>

        <section>
            <h2>7. Privacidade</h2>
            <p>O uso do Site está sujeito à nossa <a href="Politica-de-Privacidade.php">Política de Privacidade</a>, que descreve como coletamos, usamos e protegemos suas informações pessoais.</p>
        </section>

        <section>
            <h2>8. Modificações nos Termos</h2>
            <p>Reservamo-nos o direito de alterar estes Termos a qualquer momento. As alterações serão notificadas aos usuários por meio do Site ou por e-mail. O uso continuado do Site após as alterações implica a aceitação dos novos Termos.</p>
        </section>

        <section>
            <h2>9. Lei Aplicável e Foro</h2>
            <p>Estes Termos são regidos pelas leis brasileiras. Qualquer disputa relacionada a estes Termos será resolvida no foro da comarca de São Paulo, SP.</p>
        </section>

        <section>
            <h2>10. Contato</h2>
            <p>Se você tiver dúvidas ou preocupações sobre estes Termos, entre em contato conosco pelo e-mail: <a href="">pedro@minhasvacinas.online</a>.</p>
        </section>

        <section>
            <h2>Agradecimentos</h2>
            <p>Obrigado por escolher o <strong>minhasvacinas.online</strong>. Esperamos que nossa plataforma ajude a simplificar e organizar suas informações de vacinação!</p>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>