<?php
session_start();
require_once '../../../scripts/User-Auth.php';
require_once '../../../scripts/Conexao.php';

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
                <!-- O botão de toggler estará visível no mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <a href="javascript:history.back()" class="btn btn-light d-flex align-items-center px-4 py-2" style="font-size: 1rem; background-color: #ffffff; border-radius: 25px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">
                        <i class="bi bi-arrow-left" style="margin-right: 8px; font-size: 1.2rem;"></i> VOLTAR
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <style>
        .btn {
            transition: 0.5s;
        }

        .btn:hover {
            background-color: #f0f0f0;
            color: rgb(0, 0, 0);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            transition: 0.5s;
        }

        .navbar {
            padding: 10px 0;
        }

        @media (max-width: 767px) {
            .navbar-nav {
                display: flex;
                justify-content: flex-end;
                width: 100%;
            }
        }
    </style>

    <section class="profile-section py-5" id="dispositivos">
        <div class="container">
            <h2 class="text-center mb-4 text-dark">Dispositivos Conectados</h2>
            <p class="text-center text-muted mb-4">Gerencie os dispositivos conectados à sua conta do <strong>Minhas Vacinas</strong>. Caso reconheça alguma atividade suspeita, altere sua senha imediatamente.</p>
            <div class="row justify-content-center g-4">
                <?php
                $user_ip = $_SESSION['user_ip'];
                if (!empty($dispositivos)):
                    foreach ($dispositivos as $dispositivo):
                        $atual = $dispositivo['ip'] === $user_ip;
                        $icone = $dispositivo['tipo_dispositivo'] === 'Desktop' || $atual
                            ? 'bi bi-pc-display'
                            : ($dispositivo['tipo_dispositivo'] === 'Mobile'
                                ? 'bi bi-phone'
                                : ($dispositivo['tipo_dispositivo'] === 'Tablet'
                                    ? 'bi bi-tablet'
                                    : 'bi bi-device-hdd'));
                        $local = trim(implode(', ', array_filter([$dispositivo['cidade'], $dispositivo['estado'], $dispositivo['pais']])));
                ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                            <div class="card border-0 shadow-lg rounded-4 w-100" style="background-color: #f9f9f9; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="<?php echo $icone; ?> text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h6 class="card-title text-dark fw-bold text-wrap" style="font-size: 1.1rem;">
                                        <?php echo htmlspecialchars($dispositivo['nome_dispositivo']); ?>
                                        <?php if ($atual): ?>
                                            <span class="badge bg-success ms-2">Atual</span>
                                        <?php endif; ?>
                                    </h6>
                                    <p class="text-muted small mb-1"><strong>Último login:</strong> <?php echo date("d/m/Y H:i", strtotime($dispositivo['data_cadastro'])); ?></p>
                                    <p class="text-muted small mb-1"><strong>IP:</strong> <?php echo htmlspecialchars($dispositivo['ip']); ?></p>
                                    <?php if (!empty($local)): ?>
                                        <p class="text-muted small mb-1"><strong>Local:</strong> <?php echo htmlspecialchars($local); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer bg-white text-center border-0 p-3">
                                    <form action="../../backend/remover-dispositivo.php" method="POST" class="d-inline">
                                        <input type="hidden" name="dispositivo_id" value="<?php echo $dispositivo['id']; ?>" />
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-4 py-2 rounded-pill">
                                            <i class="bi bi-x-circle"></i> Remover
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

    <style>
        /* Estilos para um design mais bonito e responsivo */
        @media (max-width: 767px) {
            .card {
                width: 100%;
                /* Cards ocuparão toda a largura da coluna */
                margin: 0 auto;
            }
        }

        .card {
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: 0.5s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
            /* Garante que a área do corpo ocupe o espaço disponível */
        }

        .btn-outline-danger {
            border-radius: 30px;
            font-size: 0.9rem;
            padding: 0.5rem 1.5rem;
            transition: background-color 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .card-title {
            white-space: normal;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>


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
    <script src="remover-dispositivo.js"></script>

</html>