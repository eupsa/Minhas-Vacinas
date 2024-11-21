<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/assets/img/logo-head.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Minhas Vacinas - Ajuda</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top rounded-pill shadow"
            style="background-color: #007bff; z-index: 1081; width: 85%; left: 50%; transform: translateX(-50%); margin-top: 10px;">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 40px;">
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Baixe o App
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="https://www.apple.com/br/app-store/">
                                        <img src="https://api.iconify.design/logos:apple-app-store.svg" alt="App Store"
                                            style="width: 20px; height: 20px;" class="me-2">
                                        App Store
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="https://play.google.com/">
                                        <img src="https://api.iconify.design/logos:google-play-icon.svg"
                                            alt="Google Play" style="width: 20px; height: 20px;" class="me-2">
                                        Google Play
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="../auth/cadastro/">CADASTRE-SE</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-secondary btn-login" href="../auth/entrar/">ENTRAR</a>
                        </li>
                        <li class="nav-item">
                            <button id="theme-toggle" class="btn btn-outline-warning"
                                style="margin-left: 10px;">🌙</button>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Baixe o App
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="https://www.apple.com/br/app-store/">
                                    <img src="https://api.iconify.design/logos:apple-app-store.svg" alt="App Store"
                                        style="width: 20px; height: 20px;" class="me-2">
                                    App Store
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="https://play.google.com/">
                                    <img src="https://api.iconify.design/logos:google-play-icon.svg" alt="Google Play"
                                        style="width: 20px; height: 20px;" class="me-2">
                                    Google Play
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary w-100 mb-2" href="src/auth/cadastro/">CADASTRE-SE</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary w-100" href="src/auth/entrar/">ENTRAR</a>
                    </li>
                    <li class="nav-item">
                        <button id="theme-toggle" class="btn btn-outline-warning w-100 mb-2"
                            style="margin-top: 2%;">🌙</button>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <section class="pt-5">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Suporte</h2>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <form id="form_suporte" class="needs-validation" novalidate action="backend/suporte.php" method="post">
                        <div class="mb-3">
                            <label for="suporte_nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="suporte_nome" name="suporte_nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="suporte_email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="suporte_email" name="suporte_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="data" class="form-label">Data do Ocorrido</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>
                        <div class="mb-3">
                            <label for="motivo_contato" class="form-label">Motivo do Contato</label>
                            <select class="form-control" id="motivo_contato" name="motivo_contato" required>
                                <option value="" disabled selected>Selecione o motivo</option>
                                <option value="problema_tecnico">Problema técnico</option>
                                <option value="duvida">Dúvida</option>
                                <option value="sugestao">Sugestão</option>
                                <option value="reclamacao">Reclamação</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mensagem" class="form-label">Mensagem</label>
                            <textarea class="form-control" id="mensagem" name="mensagem" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>