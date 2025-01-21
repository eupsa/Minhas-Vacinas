<?php
session_start();
if (isset($_SESSION['session_id'])) {
    header("Location: ../../painel/");
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
                            <a href="../../ajuda/" class="nav-link">Suporte</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['session_id'])): ?>
                            <li class="nav-item">
                                <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="/painel/">
                                    <i class="bi bi-arrow-return-left me-2"></i> Voltar à sua conta
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
                            <a class="btn btn-outline-primary w-100 mb-2 rounded-pill px-3 py-1 text-primary transition-transform transform-hover" href="../painel/">
                                <i class="bi bi-arrow-return-left me-2"></i> Voltar à sua conta
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-primary w-100 mb-2 rounded-pill px-3 py-1 text-white transition-transform transform-hover" href="../auth/entrar/">ENTRAR</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>

    <section class="pt-5 pb-5">
        <div class="container mt-5">
            <h4 class="mb-4 text-center">Faça seu cadastro</h4>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5" style="background-color: #f8f9fa;">
                            <div class="card-body p-5" style="background-color: #f8f9fa;">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div id="g_id_onload"
                                        data-client_id="14152276280-9pbtedkdibk5rsktetmnh32rap49a8jm.apps.googleusercontent.com"
                                        data-login_uri="https://minhasvacinas.online/src/auth/backend/cadastro-google.php"
                                        data-auto_prompt="false">
                                    </div>
                                    <div class="g_id_signin custom-google-btn"
                                        data-type="standard"
                                        data-size="medium"
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
                                    echo '
<div class="alert alert-success" role="alert">
    Cadastro realizado com sucesso! Você será redirecionado para o login em <span id="contador">5</span> segundos.
</div>
<script>
    let countdown = 5;
    const contador = document.getElementById("contador");

    const redirectToLogin = () => {
        window.location.href = "../entrar/"; // Altere o link conforme necessário
    };

    setInterval(function() {
        if (countdown > 0) {
            contador.textContent = countdown;
            countdown--;
        } else {
            redirectToLogin(); // Redireciona quando o contador chega a zero
        }
    }, 1000);
</script>';

                                    unset($_SESSION['sucesso_email']);
                                }
                                ?>
                                <form action="../backend/cadastro.php" class="needs-validation" id="formcad" method="post" novalidate>
                                    <div class="mb-4">
                                        <label for="nome" class="form-label">Nome<span class="required-asterisk">*</span></label>
                                        <input type="text" class="form-control rounded-pill" id="nome" name="nome" autocomplete="off" required>
                                        <div class="invalid-feedback">Por favor, insira seu nome.</div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label">E-mail<span class="required-asterisk">*</span></label>
                                        <input type="email" class="form-control rounded-pill" id="email" name="email" required autocomplete="off">
                                        <div class="invalid-feedback">Por favor, insira um e-mail válido.</div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="senha" class="form-label">Senha<span class="required-asterisk">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control rounded-pill" id="senha" name="senha" autocomplete="new-password" required>
                                            <button class="btn btn-outline-secondary rounded-pill" type="button" id="togglePassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">Por favor, insira uma senha.</div>
                                        <ul id="passwordChecklist" class="d-none" style="list-style-type: none; padding-left: 0; margin-top: 10px; font-size: 14px;">
                                            <li id="length" class="text-muted"><i class="bi bi-check-circle-fill"></i> Mínimo 8 caracteres</li>
                                            <li id="uppercase" class="text-muted"><i class="bi bi-check-circle-fill"></i> Pelo menos uma letra maiúscula</li>
                                            <li id="number" class="text-muted"><i class="bi bi-check-circle-fill"></i> Pelo menos um número</li>
                                            <li id="special" class="text-muted"><i class="bi bi-check-circle-fill"></i> Pelo menos um caractere especial</li>
                                        </ul>
                                    </div>
                                    <div class="mb-4">
                                        <label for="confSenha" class="form-label">Confirme sua senha<span class="required-asterisk">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control rounded-pill" id="confSenha" name="confSenha" autocomplete="new-password" required>
                                            <button class="btn btn-outline-secondary rounded-pill" type="button" id="ConftogglePassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">As senhas não coincidem.</div>
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
                                        <div class="invalid-feedback">Por favor, selecione um estado.</div>
                                    </div>
                                    <div class="form-check mb-4">
                                        <label class="form-check-label" for="termsCheckbox" style="padding-bottom: 2%;">Ao clicar em cadastrar, você concorda com os <a href="../../../docs/Termos-de-Servico.pdf" target="_blank">Termos de Serviço</a> e <a href="../../../docs/Política-de-Privacidade.pdf" target="_blank">Política de Privacidade</a>.</label>
                                    </div>
                                    <button class="btn btn-primary w-100 py-2 rounded-pill d-flex align-items-center justify-content-center" type="submit">
                                        <i class="bi bi-person-plus me-2"></i> CADASTRAR
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="text-center text-dark mt-4">
                            <p class="mb-1">Já tem uma conta?</p>
                            <a href="../entrar/" style="text-decoration: none;">
                                <i class="bi bi-arrow-right-circle me-2"></i> Entre na sua conta
                            </a>
                        </div>
                        <div class="text-center mt-4">
                            <p class="mb-1">Já tem cadastro, mas ainda não confirmou?</p>
                            <a href="../confirmar-cadastro/" style="text-decoration: none;">
                                <i class="bi bi-envelope-check me-2"></i> Confirmar e-mail
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

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px;">
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