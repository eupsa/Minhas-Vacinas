<?php
session_start();
if (isset($_SESSION['session_id'])) {
    header("Location: ../../painel/index.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Minhas Vacinas - Login</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/index.html">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.html#nossa-missao">Sobre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="" onclick="alert('Página indisponível.');" ;>Campanhas</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://help.minhasvacinas.online" class="nav-link">
                                Suporte
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Baixe o App
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="">
                                        <img src="https://api.iconify.design/logos:apple-app-store.svg" alt="App Store"
                                            style="width: 20px; height: 20px;" class="me-2">
                                        App Store
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
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
                            <a class="btn btn-outline-light btn-login" href="../cadastro/index.php">CADASTRE-SE</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="form-log">
        <div class="container d-flex justify-content-center align-items-center full-height" style="margin-top: 70px;">
            <div class="row w-100">
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <form action="../backend/entrar.php" class="needs-validation bg-light p-5 rounded shadow-lg"
                        id="form_login" method="post" novalidate>
                        <h4 class="mb-4 text-center">Entre na sua conta</h4>

                        <!-- Campo de E-mail -->
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                        </div>

                        <!-- Campo de Senha -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="senha" name="senha" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="mt-2 text-end">
                                <a href="../esqueceu-senha/index.php" class="text-muted">
                                    <i class="bi bi-question-circle me-1"></i> Esqueceu a senha?
                                </a>
                            </div>
                        </div>

                        <!-- Lembrar Senha -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="lembrarSenha" name="lembrarSenha">
                            <label class="form-check-label" for="lembrarSenha">Lembrar senha</label>
                        </div>

                        <!-- Botão de Login -->
                        <button class="btn btn-success w-100" type="submit">Entrar</button>
                    </form>

                    <hr class="custom-hr">

                    <!-- Link para cadastro -->
                    <div class="text-center mt-3">
                        <p class="mb-1">Ainda não tem uma conta?</p>
                        <a href="../cadastro/index.php" class="btn btn-primary">Faça seu registro aqui</a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <footer class="footer text-center">
        <div class="container">
            <p class="mb-0">© 2024 Minhas Vacinas - Todos os direitos reservados</p>
            <a href="/assets/docs/Termos-de-Serviço.pdf" class="text-white">Termos de Serviço</a> |
            <a href="/assets\docs\Política-de-Privacidade.pdf" class="text-white">Política de Privacidade</a>
        </div>
    </footer>

    <!-- 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>