<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    header("Location: ../auth/login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Cadastro de Vacinas</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="../../../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 60px;">
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
                <div class="d-flex align-items-center justify-content-center" style="height: 10vh;">
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link text-white" aria-current="page">
                            <i class="bi bi-house-door"></i>
                            Início
                        </a>
                    </li>
                    <li>
                        <a href="../index.php" class="nav-link active">
                            <i class="fas fa-syringe"></i>
                            Vacinas
                        </a>
                    </li>
                    <li>
                        <a href="/src/campaigns/index.html" class="nav-link text-white">
                            <i class="fas fa-bullhorn"></i>
                            Campanhas
                        </a>
                    </li>
                    <li>
                        <a href="../profile/index.php" class="nav-link text-white">
                            <i class="bi bi-person"></i>
                            Conta
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
                        <img src="/assets/img/bx-user.svg" alt="Foto do Usuário" class="rounded-circle me-2"
                        width="40" height="40">
                        <span><?php echo isset($_SESSION['session_nome']) ? $_SESSION['session_nome'] : 'Usuário'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <!-- <li><a class="dropdown-item" href="">Novo projeto...</a></li>
                        <li><a class="dropdown-item" href="">Configurações</a></li> -->
                        <li><a class="dropdown-item" href="../profile/index.php">Conta</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/src/backend/scripts/logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
    </section>

    <section>
        <div class="content">
            <h2 class="fw-light">Cadastro de Vacinas</h2>
            <form action="../../../../backend/register_vac.php" method="post" id="form_vacina">
                <div class="mb-3">
                    <label for="nomeVac" class="form-label">Nome da Vacina</label>
                    <input type="text" class="form-control" id="nomeVac" name="nomeVac" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="dataAplicacao" class="form-label">Data da Aplicação</label>
                    <input type="date" class="form-control" id="dataAplicacao" name="dataAplicacao" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="localAplicacao" class="form-label">Local de Aplicação</label>
                    <input type="text" class="form-control" id="localAplicacao" name="localAplicacao" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Vacina</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="" selected>Selecione o tipo</option>
                        <option value="Imunização">Imunização</option>
                        <option value="Vacina de Vírus Vivo Atenuado">Vacina de Vírus Vivo Atenuado</option>
                        <option value="Vacina de Vírus Inativado">Vacina de Vírus Inativado</option>
                        <option value="Vacina Subunitária">Vacina Subunitária</option>
                        <option value="Vacina de RNA Mensageiro (mRNA)">Vacina de RNA Mensageiro (mRNA)</option>
                        <option value="Vacina de Vetor Viral">Vacina de Vetor Viral</option>
                        <option value="Vacina de Proteína Recombinante">Vacina de Proteína Recombinante</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dose" class="form-label">Dose</label>
                    <select class="form-select" id="dose" name="dose">
                        <option value="" selected>Selecione a dose</option>
                        <option value="1ª Dose">1ª Dose</option>
                        <option value="2ª Dose">2ª Dose</option>
                        <option value="Reforço">Reforço</option>
                        <option value="Dose Única">Dose Única</option>
                        <option value="Dose de Manutenção">Dose de Manutenção</option>
                        <option value="Dose Adicional">Dose Adicional</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="lote" class="form-label">Lote</label>
                    <input type="text" class="form-control" id="lote" name="lote" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="obs" class="form-label">Observações</label>
                    <textarea class="form-control" id="obs" name="obs" rows="3"></textarea autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar Vacina</button>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script src="../../../../../assets/js/sweetalert2.js"></script>
</body>

</html>