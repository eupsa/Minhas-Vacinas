<?php
// require '../../scripts/Conexao.php';

// $token = $_GET['token'];

// $sql = $pdo->prepare("SELECT * FROM esqueceu_senha WHERE token = :token");
// $sql->bindValue(':token', $token);
// $sql->execute();

// if ($sql->rowCount() != 1) {
//     header('Location: ../esqueceu-senha/');
// }

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Nova Senha</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="/">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="/#nossa-missao">Sobre</a></li>
                        <li class="nav-item"><a href="../../ajuda/" class="nav-link">Suporte</a></li>
                        <li class="nav-item"><a href="../../FAQ/" class="nav-link">FAQ</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-primary rounded-pill px-4 py-2 text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person text-dark"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="../painel/"><i class="bi bi-house-door text-dark me-2"></i>Painel</a></li>
                                    <li><a class="dropdown-item" href="../painel/vacinas/"><i class="bi bi-heart-pulse-fill text-dark me-2"></i>Vacinas</a></li>
                                    <li><a class="dropdown-item" href="../painel/perfil/"><i class="bi bi-person-circle text-dark me-2"></i>Perfil</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-pill px-4 py-2 text-white" href="../entrar/">
                                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 75%; background: rgba(255, 255, 255, 0.95);">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between" style="height: 100%;">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/" style="font-weight: 500;">
                            <i class="bi bi-house-door text-dark me-2"></i>Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/#nossa-missao" style="font-weight: 500;">
                            <i class="bi bi-info-circle text-dark me-2"></i>Sobre
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../ajuda/" class="nav-link text-dark" style="font-weight: 500;">
                            <i class="bi bi-question-circle text-dark me-2"></i>Suporte
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../FAQ/" class="nav-link text-dark" style="font-weight: 500;">
                            <i class="bi bi-file-earmark-text text-dark me-2"></i>FAQ
                        </a>
                    </li>
                </ul>
                <div class="d-flex flex-column align-items-center gap-3 mt-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="nav-link dropdown-toggle btn btn-outline-primary rounded-pill px-4 py-2 w-100 text-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person text-dark"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../painel/"><i class="bi bi-house-door text-dark me-2"></i>Painel</a></li>
                            <li><a class="dropdown-item" href="../painel/vacinas/"><i class="bi bi-heart-pulse-fill text-dark me-2"></i>Vacinas</a></li>
                            <li><a class="dropdown-item" href="../painel/perfil/"><i class="bi bi-person-circle text-dark me-2"></i>Perfil</a></li>
                        </ul>
                    <?php else: ?>
                        <a class="btn btn-primary rounded-pill px-4 py-2 text-white w-100 text-center" href="../entrar/">
                            <i class="bi bi-box-arrow-in-right"></i> ENTRAR
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <section class="form-resetPassword">
        <div class="container mt-5">
            <div class="row justify-content-center" style="margin-top: 9%;">
                <h4 class="mb-4 text-center text-dark">Crie sua nova senha</h4>
                <div class="col-12 col-md-8 col-lg-6">
                    <form action="../backend/nova-senha.php" class="needs-validation bg-light p-5 rounded shadow-lg" id="form_reset" method="post" novalidate>
                        <p class="text-muted text-center mb-4">
                            <i class="bi bi-info-circle me-2"></i> Sua senha precisa atender aos requisitos abaixo:
                        </p>
                        <ul id="passwordChecklist" class="text-muted mb-3">
                            <li><i class="bi bi-check-circle me-2" id="checkLength"></i>Pelo menos 8 caracteres</li>
                            <li><i class="bi bi-check-circle me-2" id="checkUppercase"></i>Uma letra maiúscula</li>
                            <li><i class="bi bi-check-circle me-2" id="checkNumber"></i>Um número</li>
                            <li><i class="bi bi-check-circle me-2" id="checkSpecial"></i>Um caractere especial (@$!%*?&)</li>
                        </ul>
                        <div class="mb-4">
                            <label for="senha" class="form-label text-dark">Crie sua Senha <span class="required-asterisk">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="senha" name="senha" required oninput="validatePassword()" autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div id="passwordStrength" class="form-text mt-2 text-muted"></div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div id="passwordProgress" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="confSenha" class="form-label text-dark">Confirme sua senha <span class="required-asterisk">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confSenha" name="confSenha" required oninput="checkPasswordMatch()" autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" id="ConftogglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div id="passwordMatch" class="form-text mt-2 text-muted"></div>
                        </div>
                        <input type="hidden" name="token" value="<?php echo !empty($_GET['token']) ? $_GET['token'] : null; ?>">
                        <button class="btn btn-dark w-100 py-2 rounded-pill" type="submit" id="submitBtn" disabled>
                            <i class="bi bi-check-circle me-2"></i> CRIAR SENHA
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function validatePassword() {
            const password = document.getElementById("senha").value;
            const progressBar = document.getElementById("passwordProgress");
            const strengthText = document.getElementById("passwordStrength");
            const submitBtn = document.getElementById("submitBtn");
            const checklist = document.getElementById("passwordChecklist");

            const lengthCheck = document.getElementById("checkLength");
            const uppercaseCheck = document.getElementById("checkUppercase");
            const numberCheck = document.getElementById("checkNumber");
            const specialCheck = document.getElementById("checkSpecial");

            let strength = 0;

            // Verificação de requisitos de senha
            if (password.length >= 8) {
                lengthCheck.classList.add("text-success");
                strength++;
            } else {
                lengthCheck.classList.remove("text-success");
            }

            if (/[A-Z]/.test(password)) {
                uppercaseCheck.classList.add("text-success");
                strength++;
            } else {
                uppercaseCheck.classList.remove("text-success");
            }

            if (/\d/.test(password)) {
                numberCheck.classList.add("text-success");
                strength++;
            } else {
                numberCheck.classList.remove("text-success");
            }

            if (/[@$!%*?&]/.test(password)) {
                specialCheck.classList.add("text-success");
                strength++;
            } else {
                specialCheck.classList.remove("text-success");
            }

            // Atualização da barra de progresso
            const progress = (strength * 25);
            progressBar.style.width = progress + "%";
            progressBar.setAttribute("aria-valuenow", progress);

            // Condição para habilitar o botão de submit
            if (strength === 4) {
                strengthText.textContent = "Senha forte!";
                strengthText.style.color = "green";
                submitBtn.disabled = false;
                submitBtn.classList.add("btn-success");
            } else {
                strengthText.textContent = "A senha é fraca.";
                strengthText.style.color = "red";
                submitBtn.disabled = true;
                submitBtn.classList.remove("btn-success");
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById("senha").value;
            const confirmPassword = document.getElementById("confSenha").value;
            const matchText = document.getElementById("passwordMatch");

            if (password !== confirmPassword) {
                matchText.textContent = "As senhas não coincidem.";
                matchText.style.color = "red";
                document.getElementById("submitBtn").disabled = true;
            } else {
                matchText.textContent = "As senhas coincidem.";
                matchText.style.color = "green";
                if (document.getElementById("passwordStrength").style.color === "green") {
                    document.getElementById("submitBtn").disabled = false;
                }
            }
        }
    </script>

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px; margin-top: 6%;">
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="../../../block.js"></script>
</body>

</html>