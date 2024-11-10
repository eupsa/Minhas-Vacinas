<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Admin - Minhas Vacinas</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="">
                    <img src="../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 60px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Acesso Rápido
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item py-2 px-3" href="https://www.apple.com/br/app-store/">
                                        <i class="fas fa-user-plus me-2" style="font-size: 20px;"></i>
                                        Cadastro de Pacientes
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-3" href="https://play.google.com/">
                                        <i class="fas fa-syringe me-2" style="font-size: 20px;"></i>
                                        Atribuição de Vacinas
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-3" href="https://play.google.com/">
                                        <i class="fas fa-edit me-2" style="font-size: 20px;"></i>
                                        Alteração de Cadastro
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-3" href="https://play.google.com/">
                                        <i class="fas fa-file-export me-2" style="font-size: 20px;"></i>
                                        Exportação de dados de Pacientes
                                    </a>
                                </li>
                            </ul>

                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-login" href="src/account/auth/login/login.php">SAIR</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>