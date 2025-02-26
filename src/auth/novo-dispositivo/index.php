<?php
require_once '../../scripts/Conexao.php';
$id_usuario = isset($_GET['id']) ? $_GET['id'] : '';
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$erro = '';

if (empty($id_usuario) || empty($ip)) {
    echo json_encode(['status' => false, 'msg' => "Variável IP ou ID não definida."]);
    exit();
}

$retorna = null;
try {
    $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE ip = :ip AND id_usuario = :id_usuario");
    $sql->bindValue(':ip', $ip);
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->execute();

    if ($sql->rowCount() === 0) {
        $retorna = ['status' => false, 'msg' => "Nenhum dispositivo encontrado com o IP e ID fornecidos."];
    } else {
        $sql = $pdo->prepare("UPDATE dispositivos SET confirmado = 1 WHERE ip = :ip AND id_usuario = :id_usuario");
        $sql->bindValue(':ip', $ip);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $retorna = ['status' => true, 'msg' => "Dispositivo adicionado à sua conta."];
        } else {
            $retorna = ['status' => false, 'msg' => "Erro ao adicionar dispositivo."];
        }
    }
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "Erro ao adicionar dispositivo: " . $e->getMessage()];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Minhas Vacinas - Novo dispositivo</title>
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

    <?php if ($retorna): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    text: '<?php echo $retorna['msg']; ?>',
                    icon: '<?php echo $retorna['status'] ? 'success' : 'error'; ?>',
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Fechar",
                }).then(() => {
                    window.location.href = "../entrar/";
                });
            });
        </script>
    <?php else: ?>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div id="loadingAnimation" style="text-align: center; border: 3px solid #007bff; padding: 40px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); width: 400px; height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: -10%;">
                <div class="spinner-border text-primary" role="status" style="animation: spin 1.5s linear infinite;">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p class="mt-3" id="loadingText" style="font-size: 18px; font-weight: bold; color: #333;">Confirmando seu dispositivo...</p>
            </div>
        </div>

        <script>
            const loadingText = document.getElementById("loadingText");
            const messages = [
                "Confirmando seu dispositivo...",
                "Verificando dados...",
                "Conectando ao servidor...",
                "Por favor, aguarde...",
                "Processando suas informações..."
            ];

            let currentMessageIndex = 0;

            setInterval(() => {
                currentMessageIndex = (currentMessageIndex + 1) % messages.length;
                loadingText.textContent = messages[currentMessageIndex];
            }, 3000);

            setInterval(() => {
                loadingText.classList.toggle("pulse");
            }, 2000);

            const style = document.createElement('style');
            style.innerHTML = `
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }

                @keyframes pulse {
                    0% { transform: scale(1); opacity: 1; }
                    50% { transform: scale(1.1); opacity: 0.8; }
                    100% { transform: scale(1); opacity: 1; }
                }

                .pulse {
                    animation: pulse 2s ease-in-out infinite;
                }
            `;
            document.head.appendChild(style);
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="../../../block.js"></script>
</body>

</html>