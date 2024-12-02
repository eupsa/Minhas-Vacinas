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
    <link rel="stylesheet" href="https://unpkg.com/element-plus/dist/index.css">
    <title>Confirmação de Cadastro</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top rounded-pill shadow"
            style="background-color: #007bff; z-index: 1081; width: 85%; left: 50%; transform: translateX(-50%); margin-top: 10px;">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 40px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="btn btn-light btn-login" style="margin-left: 1900%;" href="../">Voltar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="position: fixed; top: 0; left: 0; z-index: 1100;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-secondary w-100" href="../../painel/">VOLTAR</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <section class="form-send-email">
        <div class="container d-flex justify-content-center align-items-center full-height" style="margin-top: 70px;">
            <div class="row w-100">
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <form action="../backend/conf_cad.php" class="needs-validation bg-light p-5 rounded shadow-lg"
                        id="form-send-email" method="post" novalidate>
                        <h4 class="mb-4 text-center">Exclusão de conta</h4>
                        <div class="mb-3">
                            <p class="mb-0">Um código será enviado para o seu e-mail, para prosseguir com a exclusão da conta, insira-o abaixo</p><br>
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                        </div>
                        <button class="btn btn-warning w-100" type="submit">Excluir Conta</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="form-code-email" style="display: none;">
        <div class="container d-flex justify-content-center align-items-center full-height">
            <div class="row w-100">
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <form action="../backend/conf_cad.php" class="needs-validation bg-light p-5 rounded shadow-lg"
                        id="form-excluir-conta" method="post" novalidate>
                        <h4 class="mb-4 text-center">Exclusão de conta</h4>
                        <div class="mb-3">
                            <p class="mb-0">Um código foi enviado para o seu e-mail, para prosseguir com a exclusão da conta, insira-o abaixo</p><br>
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email); ?>" required autocomplete="off" disabled>
                        </div>
                        <div class="mb-3" id="pinto">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required autocomplete="off">
                        </div>
                        <button class="btn btn-warning w-100" type="submit">Excluir Conta</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer text-center">
        <div class="container">
            <p class="mb-0">© 2024 Vacinas - Todos os direitos reservados</p>
            <a href="" class="text-white">Termos de Uso</a> |
            <a href="" class="text-white">Política de Privacidade</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>