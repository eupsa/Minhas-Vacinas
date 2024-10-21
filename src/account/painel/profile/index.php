<?php
require '../../../backend/scripts/auth.php';
VefNoLogin();
CreateSessions($pdo);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Vacinas - Perfil</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="../../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 60px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

    <section>
        <div>
            <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
                <div class="d-flex align-items-center justify-content-center" style="height: 10vh;"></div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link text-white" aria-current="page">
                            <i class="bi bi-house-door"></i> Início
                        </a>
                    </li>
                    <li>
                        <a href="../vaccines/index.html" class="nav-link text-white">
                            <i class="fas fa-syringe"></i> Vacinas
                        </a>
                    </li>
                    <li>
                        <a href="/src/campaigns/index.html" class="nav-link text-white">
                            <i class="fas fa-bullhorn"></i> Campanhas
                        </a>
                    </li>
                    <li>
                        <a href="index.html" class="nav-link active">
                            <i class="bi bi-person"></i> Conta
                        </a>
                    </li>
                    <li>
                        <hr>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/img/ft-perfil.png" alt="sua foto aqui" class="rounded-circle me-2"
                            width="40" height="40">
                        <span><?php echo isset($_SESSION['user_nome']) ? $_SESSION['user_nome'] : 'Usuário'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="index.html">Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/src/backend/scripts/logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
            <div class="content flex-grow-1">
                <div class="container d-flex justify-content-start align-items-start mt-4" style="margin-left: -15px;">
                    <div class="card mb-4" style="width: 35rem;">
                        <div class="d-flex align-items-center p-3">
                            <img src="/assets/img/ft-perfil.png" class="rounded-circle" alt="Foto do Usuário" style="width: 100px; height: 100px; object-fit: cover; margin-right: 15px;">
                            <div>
                                <h5 class="card-title" style="font-size: 1.25rem;"><?php echo isset($_SESSION['user_nome']) ? $_SESSION['user_nome'] : 'Nome do Usuário'; ?></h5>
                                <p class="card-text" style="font-size: 0.875rem;"><?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'email@exemplo.com'; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section>
        <div class="content">
            <form id="profileForm">
                <div class="row mb-3">
                    <div class="col">
                        <label for="Nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            value="<?php echo isset($_SESSION['user_nome']) ? $_SESSION['user_nome'] : ''; ?>">
                    </div>
                    <div class="col">
                        <label for="E-Mail" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" id="E-Mail" name="E-Mail"
                            value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="idade" name="idade"
                            value="<?php echo isset($_SESSION['user_idade']) ? $_SESSION['user_idade'] : ''; ?>">
                    </div>
                    <div class="col">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone"
                            value="<?php echo isset($_SESSION['user_telefone']) ? $_SESSION['user_telefone'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf"
                            value="<?php echo isset($_SESSION['user_cpf']) ? $_SESSION['user_cpf'] : ''; ?>" disabled>
                    </div>
                    <div class="col">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado"
                            value="<?php echo isset($_SESSION['user_estado']) ? $_SESSION['user_estado'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="genero" class="form-label">Gênero</label>
                        <input type="text" class="form-control" id="genero" name="genero"
                            value="<?php echo isset($_SESSION['user_genero']) ? $_SESSION['user_genero'] : ''; ?>">
                    </div>
                    <div class="col">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade"
                            value="<?php echo isset($_SESSION['user_cidade']) ? $_SESSION['user_cidade'] : ''; ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                <button type="button" class="btn btn-danger" id="deleteAccountBtn">Excluir Conta</button>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>