<?php
session_start();
if (isset($_SESSION['session_id'])) {
    header("Location: ../../painel/");
    exit();
}

$repoOwner = 'psilvagg';
$repoName = 'app-minhas-vacinas';
$token = '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';

$url = "https://api.github.com/repos/$repoOwner/$repoName/releases/latest";

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'User-Agent: MinhasVacinas-App',
    "Authorization: Bearer $token"
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode === 200 && $response) {
    $data = json_decode($response, true);
    $latestVersion = $data['tag_name'] ?? 'Versão não encontrada';
} elseif ($httpCode === 401) {
    $latestVersion = 'Erro: Não autorizado. Verifique o token.';
} elseif ($httpCode === 404) {
    $latestVersion = 'Erro: Repositório não encontrado.';
} else {
    $latestVersion = 'Erro ao buscar versão';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Minhas Vacinas - Cadastro</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                            <a href="../../ajuda/" class="nav-link">Suporte</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-download"></i> Baixe o App
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="https://github.com/psilvagg/app-minhas-vacinas/releases/latest" target="_blank">
                                        <i class="bi bi-github"></i> Release no GitHub
                                        <span class="badge bg-warning text-dark ms-2"><?php echo htmlspecialchars($latestVersion); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <?php if (isset($_SESSION['session_id'])): ?>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white transition-transform transform-hover" href="../../painel/">
                                    <i class="bi bi-arrow-return-left"></i> Voltar à sua conta
                                </a>
                            </li>
                            <li class="nav-item" style="margin-left: 10px;">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white transition-transform transform-hover" href="../../scripts/sair.php">
                                    <i class="bi bi-box-arrow-left"></i>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white transition-transform transform-hover" href="../entrar/">
                                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="form-log custom-section">
        <div class="container mt-5">
            <h4 class="mb-4 text-center" style="margin-top: 10%;">Faça seu cadastro</h4>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body p-5" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-center align-items-center">
                                <div id="g_id_onload"
                                    data-client_id="14152276280-9pbtedkdibk5rsktetmnh32rap49a8jm.apps.googleusercontent.com"
                                    data-login_uri="https://minhasvacinas.online/src/auth/backend/cadastro-google.php"
                                    data-auto_prompt="false">
                                </div>
                                <div class="g_id_signin custom-google-btn"
                                    data-type="standard"
                                    data-size="large"
                                    data-theme="filled_blue"
                                    data-text="signu_with_google"
                                    data-shape="circle"
                                    data-logo_alignment="left"
                                    style="transform: scale(1.1);">
                                </div>
                            </div><br>
                            <?php
                            if (isset($_SESSION['erro_email'])) {
                                echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['erro_email'] . "</div>";
                                unset($_SESSION['erro_email']);
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['sucesso_email'])) {
                                echo "<div class='alert alert-success' role='alert'>Cadastro realizado com sucesso!</div>";
                                unset($_SESSION['sucesso_email']);
                            }
                            ?>
                            <form action="../backend/cadastro.php" class="needs-validation" id="formcad" method="post" novalidate>
                                <div class="mb-4">
                                    <label for="nome" class="form-label text-dark font-weight-semibold">Nome<span class="required-asterisk">*</span></label>
                                    <input type="text" class="form-control rounded-pill" id="nome" name="nome" autocomplete="off" required>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label text-dark font-weight-semibold">E-mail<span class="required-asterisk">*</span></label>
                                    <input type="email" class="form-control rounded-pill" id="email" name="email" required autocomplete="off">
                                </div>
                                <div class="mb-4">
                                    <label for="senha" class="form-label text-dark font-weight-semibold">Senha<span class="required-asterisk">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control rounded-pill" id="senha" name="senha" required>
                                        <button class="btn btn-outline-secondary rounded-pill" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="confSenha" class="form-label text-dark font-weight-semibold">Confirme sua senha<span class="required-asterisk">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control rounded-pill" id="confSenha" name="confSenha" required>
                                        <button class="btn btn-outline-secondary rounded-pill" type="button" id="ConftogglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="estado" class="form-label">Selecione um estado<span class="required-asterisk">*</span></label>
                                    <select class="form-select rounded-pill" id="estado" name="estado" required>
                                        <option value="" selected disabled>Selecione um estado</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                                <div class="form-check mt-4 mb-4">
                                    <input type="checkbox" class="form-check-input" id="termsCheckbox" style="margin-top: 5px;" required>
                                    <label class="form-check-label text-dark ms-2" for="termsCheckbox">
                                        Eu li e aceito os <a href="/docs/Termos-de-Servico.php" class="text-primary" target="_blank" style="text-decoration: none;">Termos de Serviço</a> e a <a href="/docs/Politica-de-Privacidade.php" class="text-primary" target="_blank" style="text-decoration: none;">Política de Privacidade</a>.
                                    </label>
                                </div>
                                <button class="btn btn-dark w-100 py-2 rounded-pill text-uppercase font-weight-bold" type="submit">
                                    <i class="bi bi-person-plus"></i> CADASTRAR
                                    <span class="spinner-border spinner-border-sm text-light" id="loadingSpinner" role="status" aria-hidden="true" style="display: none;"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <hr class="custom-hr">
                        <p class="mb-1 text-dark">Já tem uma conta?</p>
                        <a href="../entrar/" class="text-primary" style="text-decoration: none;">
                            <i class="bi bi-door-open"></i> Faça login aqui
                        </a>
                    </div>
                    <div class="text-center mt-4">
                        <p class="mb-1 text-dark">Ainda não confirmou o cadastro?</p>
                        <a href="../confirmar-cadastro/" class="text-primary" style="text-decoration: none;">
                            <i class="bi bi-check-circle"></i> Confirmar cadastro
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const passwordInput = document.getElementById('senha');
        const checklist = document.getElementById('passwordChecklist');
        const length = document.getElementById('length');
        const uppercase = document.getElementById('uppercase');
        const number = document.getElementById('number');
        const special = document.getElementById('special');

        passwordInput.addEventListener('focus', function() {
            checklist.classList.remove('d-none');
        });

        passwordInput.addEventListener('blur', function() {
            if (passwordInput.value === '') {
                checklist.classList.add('d-none');
            }
        });

        passwordInput.addEventListener('input', function() {
            const value = passwordInput.value;

            // Verificação de comprimento
            if (value.length >= 8) {
                length.classList.remove('text-muted');
                length.classList.add('text-success');
            } else {
                length.classList.remove('text-success');
                length.classList.add('text-muted');
            }

            // Verificação de letra maiúscula
            if (/[A-Z]/.test(value)) {
                uppercase.classList.remove('text-muted');
                uppercase.classList.add('text-success');
            } else {
                uppercase.classList.remove('text-success');
                uppercase.classList.add('text-muted');
            }

            // Verificação de número
            if (/\d/.test(value)) {
                number.classList.remove('text-muted');
                number.classList.add('text-success');
            } else {
                number.classList.remove('text-success');
                number.classList.add('text-muted');
            }

            // Verificação de caractere especial
            if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
                special.classList.remove('text-muted');
                special.classList.add('text-success');
            } else {
                special.classList.remove('text-success');
                special.classList.add('text-muted');
            }
        });
    </script>

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px; margin-top: 3%;">
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
                        <a href="../../../docs/Politica-de-Privacidade.php"
                            style="text-decoration: none; color: #adb5bd;" class="text-reset">Política de
                            Privacidade</a>
                    </p>
                    <p>
                        <a href="../../../docs/Termos-de-Servico.php" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Termos de Serviço</a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Contato</h6>
                    <p><i class="bi bi-envelope me-2"></i>contato@minhasvacinas.online</p>
                </div>
            </div>
        </div>

        <div class="text-center p-4" style="background-color: #181a1b; color: #adb5bd;">
            © 2025 Minhas Vacinas. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async></script>
    <script src="script.js"></script>
    <script src="../../../block.js"></script>
</body>

</html>