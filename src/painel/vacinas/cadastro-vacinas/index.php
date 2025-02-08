<?php
require '../../../scripts/conn.php';
require '../../../scripts/User-Information.php';

session_start();
if (!isset($_SESSION['session_id'])) {
    header("Location: ../../../auth/entrar/");
    exit();
} else {
    Sessions($pdo);
    $sql = $pdo->prepare("SELECT * FROM vacinas_existentes");
    $sql->execute();
    $vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($vacinas) > 0) {
        $_SESSION['vacinas'] = $vacinas;
    } else {
        $_SESSION['vacinas'] = [];
    }
}


$sql = $pdo->prepare("SELECT * FROM dispositivos WHERE ip = :ip");
$sql->bindValue(':ip', $_SESSION['session_ip']);
$sql->execute();

if ($sql->rowCount() != 1) {
    $sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario AND ip_cadastro = :ip_cadastro");
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->bindValue(':ip_cadastro', $_SESSION['session_ip']);
    $sql->execute();

    if ($sql->rowCount() != 1) {

        $_SESSION = [];
        session_destroy();

        header("Location: ../../../auth/entrar/");
        exit();
    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Cadastro de Vacinas</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top"
            style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="../../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-left: 90%;">
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
    </header>

    <section>
        <div>
            <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
                <div class="d-flex align-items-center justify-content-center" style="height: 10vh;">
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="../../" class="nav-link text-white" aria-current="page">
                            <i class="bi bi-house-door"></i>
                            Início
                        </a>
                    </li>
                    <li>
                        <a href="../" class="nav-link active">
                            <i class="fas fa-syringe"></i>
                            Vacinas
                        </a>
                    </li>
                    <li>
                        <a href="" onclick="alert('Indisponível')" class="nav-link text-white">
                            <i class="fas fa-bullhorn"></i>
                            Campanhas
                        </a>
                    </li>
                    <li>
                        <a href="../../perfil/" class="nav-link text-white">
                            <i class="bi bi-person"></i>
                            Conta
                        </a>
                    </li>
                    <li>
                        <hr>
                    </li>
                </ul>
                <hr>
                <?php if (isset($_SESSION['session_fotourl'])): ?>
                    <p class="text-success">
                        <img src="https://img.icons8.com/?size=512&id=17949&format=png" alt="Ícone Google" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 2px;">
                        <small>Conectado com Google</small>
                    </p>
                <?php endif; ?>
                <div class="dropdown">
                    <a href="" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (isset($_SESSION['session_fotourl'])): ?>
                            <img src="<?php echo $_SESSION['session_fotourl']; ?>" alt="Foto do Usuário" class="rounded-circle me-2"
                                width="40" height="40">
                        <?php elseif (isset($_SESSION['session_foto_perfil']) && !empty($_SESSION['session_foto_perfil'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['session_foto_perfil']); ?>" alt="Foto do Usuário" class="rounded-circle me-2"
                                width="40" height="40">
                        <?php else: ?>
                            <img src="/assets/img/bx-user.svg" alt="Foto do Usuário" class="rounded-circle me-2"
                                width="40" height="40">
                        <?php endif; ?>
                        <span><?php echo isset($_SESSION['session_nome']) ? explode(' ', $_SESSION['session_nome'])[0] : 'Usuário'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="perfil/"><i class="fas fa-user"></i> Minha conta</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../../../scripts/sair.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                    </ul>
                </div>
            </div>
    </section>

    <section>
        <div class="content">
            <h2 class="fw-light mb-5 text-center">Cadastro de Vacinas</h2>
            <form action="../../backend/cadastro-vacina.php" method="post" id="form_vacina">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 mb-4">
                        <label for="vacina" class="form-label">Vacina<span class="required-asterisk">*</span></label>
                        <select class="form-select" id="nomeVac" name="nomeVac" aria-label="Selecione a vacina">
                            <option value="" disabled selected>Selecione uma vacina</option>
                            <?php if (count($vacinas) > 0): ?>
                                <?php foreach ($vacinas as $vacina): ?>
                                    <option value="<?= $vacina['nome_vac'] ?>"><?= htmlspecialchars($vacina['nome_vac']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Nenhuma vacina disponível</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-8 mb-4">
                        <label for="dataAplicacao" class="form-label">Data da Aplicação<span class="required-asterisk">*</span></label>
                        <input type="date" class="form-control" id="dataAplicacao" name="dataAplicacao" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-8 mb-4">
                        <label for="proxima_dose" class="form-label">Próxima Dose<span class="required-asterisk">*</span></label>
                        <input type="date" class="form-control" id="proxima_dose" name="proxima_dose" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-8 mb-4">
                        <label for="localAplicacao" class="form-label">Local de Aplicação<span class="required-asterisk">*</span></label>
                        <input type="text" class="form-control" id="localAplicacao" name="localAplicacao" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-8 mb-4" id="outroLocalDiv" style="display: none;">
                        <label for="outro_local" class="form-label">Local de Aplicação<span class="required-asterisk">*</span></label>
                        <input type="text" class="form-control" id="outro_local" name="outro_local" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-8 mb-4">
                        <label for="tipo" class="form-label">Tipo da Vacina<span class="required-asterisk">*</span></label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="" disabled selected>Selecione o tipo</option>
                            <option value="Imunização">Imunização</option>
                            <option value="Vacina de Vírus Vivo Atenuado">Vacina de Vírus Vivo Atenuado</option>
                            <option value="Vacina de Vírus Inativado">Vacina de Vírus Inativado</option>
                            <option value="Vacina Subunitária">Vacina Subunitária</option>
                            <option value="Vacina de RNA Mensageiro (mRNA)">Vacina de RNA Mensageiro (mRNA)</option>
                            <option value="Vacina de Vetor Viral">Vacina de Vetor Viral</option>
                            <option value="Vacina de Proteína Recombinante">Vacina de Proteína Recombinante</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-8 mb-4">
                        <label for="dose" class="form-label">Dose<span class="required-asterisk">*</span></label>
                        <select class="form-select" id="dose" name="dose">
                            <option value="" disabled selected>Selecione a dose</option>
                            <option value="1ª Dose">1ª Dose</option>
                            <option value="2ª Dose">2ª Dose</option>
                            <option value="Reforço">Reforço</option>
                            <option value="Dose Única">Dose Única</option>
                            <option value="Dose de Manutenção">Dose de Manutenção</option>
                            <option value="Dose Adicional">Dose Adicional</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-8 mb-4">
                        <label for="imagem" class="form-label">Imagem da Vacina</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" onchange="previewImage(event)">
                        <div id="imagePreview" style="margin-top: 10px;">
                            <img id="preview" src="" alt="Prévia da Imagem" style="max-width: 150px; display: none;" />
                        </div>
                    </div>

                    <script>
                        function previewImage(event) {
                            const file = event.target.files[0];
                            const reader = new FileReader();

                            reader.onload = function() {
                                const preview = document.getElementById('preview');
                                preview.src = reader.result;
                                preview.style.display = 'block';
                            }

                            if (file) {
                                reader.readAsDataURL(file);
                            }
                        }
                    </script>

                    <div class="col-12 col-md-8 mb-4">
                        <label for="lote" class="form-label">Lote</label>
                        <input type="text" class="form-control" id="lote" name="lote" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-8 mb-2">
                        <label for="obs" class="form-label">Observações</label>
                        <textarea class="form-control" id="obs" name="obs" rows="3" autocomplete="off"></textarea>
                    </div>
                    <div class="col-12 text-center mt-5">
                        <button type="submit" class="btn btn-primary w-50 rounded-pill shadow-sm text-white">
                            <i class="fa fa-plus-circle me-2"></i>Cadastrar Vacina
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.getElementById('localAplicacao').addEventListener('change', function() {
            var outroLocalDiv = document.getElementById('outroLocalDiv');
            if (this.value === 'outro') {
                outroLocalDiv.style.display = 'block';
            } else {
                outroLocalDiv.style.display = 'none';
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script src="../../../../block.js"></script>
</body>

</html>