<?php
session_start();
require_once '../../../../vendor/autoload.php';
require_once '../../../scripts/Conexao.php';

$sql = $pdo->prepare("SELECT email FROM 2FA WHERE email = :email");
$sql->bindValue(':email', $_SESSION['user_email']);
$sql->execute();

if ($sql->rowCount() === 1) {
    header('Location: ../');
}

$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

$secret = $g->generateSecret();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>2FA</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top"
            style="background-color: #007bff; z-index: 1100; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" id="sidebarToggle" type="button" data-bs-toggle="sidebar" data-bs-target="#sidebar" aria-controls="sidebar">
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

    <section class="pt-5 pb-5">
        <div class="container mt-5">
            <h4 class="mb-4 text-center" style="margin-top: 10%;">Ativar Verificação em Dois Fatores (2FA)</h4>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5 bg-light">
                            <form action="../../backend/ativar-2FA.php" class="needs-validation" id="form-2fa" method="post" novalidate>
                                <div class="mb-4">
                                    <h5 class="text-center text-dark">Passo a passo para ativar o 2FA:</h5>
                                    <ol class="text-dark">
                                        <li>Baixe um aplicativo autenticador, como Google Authenticator ou Authy.</li>
                                        <li>Abra o aplicativo autenticador.</li>
                                        <li>Selecione a opção para adicionar uma nova conta.</li>
                                        <li>Escolha a opção de escanear código QR ou inserir a chave manualmente.</li>
                                        <li>Se optar pelo código manual, cole o código acima.</li>
                                        <li>O aplicativo gerará um código de 6 dígitos.</li>
                                        <li>Digite o código abaixo e confirme.</li>
                                    </ol>
                                </div>
                                <div class="text-center mb-4">
                                    <img src="<?php echo $g->getUrl('Minhas Vacinas', '(' . $_SESSION['user_email'] . ')', $secret); ?>" alt="QR Code para autenticação" class="img-fluid">
                                </div>
                                <div class="mb-4 text-center">
                                    <h5 class="text-dark">Ou copie e cole este código manualmente:</h5>
                                    <p class="text-primary fw-bold" id="manualToken"> <?php echo $secret; ?> </p>
                                    <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyToken()">Copiar Código</button>
                                </div>
                                <div class="mb-3">
                                    <label for="codigo" class="form-label text-dark">Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" required autocomplete="off">
                                </div>
                                <div class="mb-3" style="display: none;">
                                    <label for="key" class="form-label text-dark">Key</label>
                                    <input type="text" class="form-control" id="key" name="key" value="<?php echo ($secret); ?>" required autocomplete="off">
                                </div>
                                <button class="btn btn-dark w-100 py-2 rounded-pill d-flex align-items-center justify-content-center" type="submit" id="submitBtn">
                                    <i class="bi bi-check-circle me-2"></i> CONFIRMAR
                                    <span class="spinner-border spinner-border-sm text-light ms-2" id="loadingSpinner" role="status" aria-hidden="true" style="display: none; border-width: 3px;"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function copyToken() {
            var tokenText = document.getElementById("manualToken").textContent;
            navigator.clipboard.writeText(tokenText).then(function() {
                alert("Código copiado para a área de transferência!");
            }, function(err) {
                console.error("Erro ao copiar: ", err);
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>