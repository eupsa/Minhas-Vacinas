<?php
require '../../scripts/conn.php';

$id = $_GET['id'];
$email = $_GET['email'];

$sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
$sql->bindValue(':id', $id);
$sql->execute();

if ($sql->rowCount() === 1) {
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    $email_atual = $usuario['email'];
} else {
    header('Location: ../../painel/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3472234536437513"
        crossorigin="anonymous"></script>
    <title>Vacinas - Alterar e-mail</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top"
            style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);" id="navi">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
            </div>
        </nav>
    </header>

    <section>
        <section class="form-conf-cad">
            <div class="container d-flex justify-content-center align-items-center full-height" style="margin-top: 70px;">
                <div class="row w-100">
                    <div class="col-12 col-md-8 col-lg-6 mx-auto">
                        <form action="../backend/novo-email" class="needs-validation bg-light p-5 rounded shadow-lg"
                            id="form-alterar-email" method="post" novalidate>
                            <h4 class="mb-4 text-center">Confirmação de e-mail</h4>
                            <div class="mb-3">
                                <label for="email-atual" class="form-label">E-mail atual</label>
                                <input type="email" class="form-control" id="email-atual" name="email-atual" required autocomplete="off" disabled value="<?php echo isset($email_atual) ? $email_atual : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="novo-email" class="form-label">Novo e-mail</label>
                                <input type="email" class="form-control" id="novo-email" name="novo-email" required autocomplete="off" disabled value="<?php echo isset($email) ? $email : ''; ?>">
                            </div>
                            <input type="hidden" name="id" value="<?php echo !empty($_GET['id']) ? $_GET['id'] : null; ?>">
                            <button class="btn btn-success w-100" type="submit" id="submitBtn">
                                CONFIRMAR NOVO E-MAIL <span class="spinner-border spinner-border-sm text-light" id="loadingSpinner" role="status"
                                    aria-hidden="true" style="display: none;"></span>
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="" data-bs-toggle="modal" data-bs-target="#emailModal" style="text-decoration: none;">Reenviar e-mail de confirmação</a>
                        </div>
                        <hr class="custom-hr">
                        <div class="text-center mt-3">
                            <p class="mb-1">Ainda não tem uma conta?</p>
                            <a href="../cadastro/" style="text-decoration: none;">Faça seu registro aqui</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px; margin-top: -7%;">
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
                        <a href="/assets/docs/Política-de-Privacidade.pdf" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Política de Privacidade</a>
                    </p>
                    <p>
                        <a href="/assets/docs/Termos-de-Serviço.pdf" style="text-decoration: none; color: #adb5bd;"
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
            © 2024 Minhas Vacinas. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>