<?php
session_start();
require_once '../../../scripts/User-Auth.php';
require_once '../../../scripts/conn.php';

Auth($pdo);
Gerar_Session($pdo);

$sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id_usuario = :id_usuario AND confirmado = 1");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();

$dispositivos = $sql->fetchAll(PDO::FETCH_ASSOC);

if (count($dispositivos) > 0) {
    $_SESSION['dispositivos'] = $dispositivos;
} else {
    $_SESSION['dispositivos'] = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../../../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Minhas Vacinas - Seus Dispositivos</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #007bff; z-index: 1100; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="../../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" id="sidebarToggle" type="button" data-bs-toggle="sidebar" data-bs-target="#sidebar" aria-controls="sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-left: 90%;">
                    <a href="javascript:history.back()" class="btn btn-light w-100 d-flex align-items-center" style="margin-left: 20px;">
                        <i class="bi bi-arrow-left" style="margin-right: 8px;"></i> VOLTAR
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <hr>

    <!-- Dispositivos -->
    <section class="profile-section py-5" style="background-color: #f4f4f4;" id="dispositivos">
        <div class="container" style="margin-top: 3%;">
            <h2 class="text-center mb-5 text-dark">Dispositivos Conectados</h2>
            <p class="text-center mt-4">Aqui estão todos os dispositivos conectados à sua conta do <strong>Minhas Vacinas</strong>. Você pode sair de cada um individualmente.</p>
            <p class="text-center">Se você não reconhecer algum dispositivo conectado à sua conta, saia do dispositivo e altere a sua senha do <strong>Minhas Vacinas</strong> imediatamente.</p>
            <div class="row justify-content-center g-4">
                <?php
                $user_ip = $_SESSION['user_ip'];
                if (count($dispositivos) > 0):
                    foreach ($dispositivos as $dispositivo):
                        $atual = $dispositivo['ip'] === $user_ip;
                        $icone = $dispositivo['tipo_dispositivo'] === 'Desktop' || $atual
                            ? 'bi bi-pc-display'
                            : ($dispositivo['tipo_dispositivo'] === 'Mobile'
                                ? 'bi bi-phone'
                                : ($dispositivo['tipo_dispositivo'] === 'Tablet'
                                    ? 'bi bi-tablet'
                                    : 'bi bi-device-hdd'));
                        $local = trim(implode(', ', array_filter([$dispositivo['cidade'], $dispositivo['estado'], $dispositivo['pais']]))); ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card border-0 shadow-sm" style="background-color: #ffffff;">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="<?php echo $icone; ?>" style="font-size: 2.5rem; color: #007bff;"></i>
                                    </div>
                                    <h5 class="card-title text-dark">
                                        <?php echo $dispositivo['nome_dispositivo']; ?>
                                        <?php if ($atual): ?>
                                            <span class="badge bg-success ms-2">Atual</span>
                                        <?php endif; ?>
                                    </h5>
                                    <p class="text-muted mb-2">
                                        <strong>Último login:</strong> <?php echo date("d/m/Y H:i", strtotime($dispositivo['data_cadastro'])); ?>
                                    </p>
                                    <p class="text-muted mb-2">
                                        <strong>IP:</strong> <?php echo $dispositivo['ip']; ?>
                                    </p>
                                    <?php if (!empty($local)): ?>
                                        <p class="text-muted mb-2">
                                            <strong>Local:</strong> <?php echo $local; ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer bg-light text-center">
                                    <form action="../backend/remover-dispositivo.php" id="form-remover-dispositivo" method="POST">
                                        <input type="hidden" name="dispositivo_id" value="<?php echo $dispositivo['id']; ?>" />
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted fs-5">Nenhum dispositivo encontrado</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px; margin-top: 7%;">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script.js"></script>
    <script src="../mudar-email.js"></script>
    <script src="../confirmar-email.js"></script>
    <script src="../excluir-conta.js"></script>
    <script src="../confirmar-exclusao.js"></script>
    <script src="../api-ibge.js"></script>
</body>

</html>