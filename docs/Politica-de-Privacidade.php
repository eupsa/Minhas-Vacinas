<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<body>
    <div class="container my-5">
        <h1 class="mb-4">Política de Privacidade</h1>

        <section>
            <h2>1. Introdução</h2>
            <p>Esta Política de Privacidade descreve como coletamos, usamos e protegemos suas informações pessoais ao acessar o site <strong>minhasvacinas.online</strong>. O objetivo do Site é oferecer serviços relacionados à gestão de informações de vacinação. Ao utilizar o Site, você concorda com os termos desta Política.</p>
        </section>

        <section>
            <h2>2. Informações que coletamos</h2>
            <p>Coletamos informações para fornecer e melhorar nossos serviços. Elas podem ser divididas nas seguintes categorias:</p>
            <h3 class="text-center">2.1 Informações Fornecidas pelo Usuário</h3>
            <ul>
                <li><strong>Dados Pessoais:</strong> Nome completo, endereço de e-mail, CPF e data de nascimento, fornecidos durante o cadastro.</li>
                <li><strong>Dados de Vacinação:</strong> Nome da vacina, dose, lote, local de aplicação e observações relacionadas às vacinas registradas.</li>
                <li><strong>Comunicações:</strong> Informações compartilhadas ao entrar em contato conosco, como dúvidas ou feedbacks.</li>
            </ul>
            <h3 class="text-center">2.2 Informações Coletadas Automaticamente</h3>
            <ul>
                <li><strong>Dados Técnicos:</strong> Endereço IP, tipo de navegador, sistema operacional e páginas acessadas durante a navegação.</li>
                <li><strong>Cookies:</strong> Utilizamos cookies para autenticar usuários, melhorar a experiência do usuário e analisar o tráfego no site.</li>
                <li><strong>Dados de Uso:</strong> Informações sobre como você interage com o site, incluindo tempo de navegação e recursos mais acessados.</li>
            </ul>
            <p>Essas informações são essenciais para garantir a segurança do sistema e oferecer uma experiência personalizada.</p>
        </section>

        <section>
            <h2>3. Uso das Informações</h2>
            <p>Utilizamos suas informações para:</p>
            <ul>
                <li>Gerenciar o histórico de vacinação do usuário.</li>
                <li>Enviar comunicações relacionadas ao serviço, como notificações de vacinas ou atualizações no sistema.</li>
                <li>Melhorar o funcionamento do Site e personalizar a experiência do usuário.</li>
                <li>Atender solicitações de suporte ou dúvidas enviadas pelos usuários.</li>
            </ul>
        </section>

        <section>
            <h2>4. Compartilhamento de Informações</h2>
            <p>Não compartilhamos suas informações pessoais com terceiros, exceto:</p>
            <ul>
                <li>Quando exigido por lei ou por ordem judicial.</li>
                <li>Para proteger os direitos, a segurança e a integridade do Site.</li>
                <li>Com provedores de serviços contratados para operar e melhorar o Site, sujeitos a acordos de confidencialidade.</li>
            </ul>
        </section>

        <section>
            <h2>5. Proteção das Informações</h2>
            <p>Adotamos medidas técnicas e organizacionais para proteger suas informações contra acesso não autorizado, perda, uso indevido ou alteração. Essas medidas incluem:</p>
            <ul>
                <li>Criptografia de dados sensíveis durante a transmissão e armazenamento.</li>
                <li>Acesso restrito às informações apenas para pessoas autorizadas.</li>
                <li>Monitoramento constante e auditorias regulares para identificar vulnerabilidades.</li>
            </ul>
        </section>

        <section>
            <h2>6. Direitos dos Usuários</h2>
            <p>Você tem direito a:</p>
            <ul>
                <li>Acessar, corrigir ou excluir suas informações pessoais.</li>
                <li>Retirar o consentimento para o uso de suas informações.</li>
                <li>Solicitar informações sobre como seus dados estão sendo usados.</li>
                <li>Reclamar junto às autoridades competentes em caso de dúvidas ou insatisfações.</li>
            </ul>
            <p>Para exercer seus direitos, entre em contato pelo e-mail: <a href="">pedro@minhasvacinas.online</a>.</p>
        </section>

        <section>
            <h2>7. Cookies</h2>
            <p>Utilizamos cookies para:</p>
            <ul>
                <li>Autenticar usuários e manter sessões ativas.</li>
                <li>Analisar o tráfego no Site.</li>
                <li>Fornecer funcionalidades adicionais, como salvar preferências do usuário.</li>
            </ul>
            <p>Você pode gerenciar ou desativar cookies diretamente nas configurações do seu navegador.</p>
        </section>

        <section>
            <h2>8. Alterações na Política de Privacidade</h2>
            <p>Reservamo-nos o direito de atualizar esta Política de Privacidade a qualquer momento. Notificaremos os usuários sobre alterações significativas por meio do Site ou por e-mail.</p>
        </section>

        <section>
            <h2>9. Login com Google</h2>
            <p>Nosso site oferece a opção de login com Google para maior praticidade e segurança. Ao optar por este método, você autoriza o acesso às informações básicas da sua conta Google, como nome, e-mail e foto de perfil. Essas informações serão usadas exclusivamente para fins de autenticação e não serão compartilhadas com terceiros.</p>
            <p>Se desejar desconectar sua conta Google do nosso site, entre em contato pelo e-mail: <a href="">pedro@minhasvacinas.online</a>.</p>
        </section>

        <section>
            <h2>10. Contato</h2>
            <p>Se você tiver dúvidas ou preocupações sobre esta Política de Privacidade, entre em contato conosco pelo e-mail: <a href="">pedro@minhasvacinas.online</a>.</p>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>