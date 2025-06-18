<?php
session_start();
require_once '../../../utils/ConexaoDB.php';
require_once '../../../utils/UsuarioAuth.php';

Auth($pdo);
Gerar_Session($pdo);

$sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id_usuario = :id_usuario AND confirmado = 1");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();

$dispositivos = $sql->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['dispositivos'] = $dispositivos ?: [];
?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/app/public/img/img-web.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/app/public/css/sweetalert-styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#007bff',
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <title>Minhas Vacinas - Dispositivos</title>
</head>

<body class="bg-dark-900 text-white min-h-screen">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-primary shadow-lg">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center">
                    <img src="/app/public/img/logo-head.png" alt="Logo Vacinas" class="h-12">
                </a>
                <div class="flex items-center space-x-4">
                    <a href="../" class="hidden md:flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-colors">
                        <i class="bi bi-arrow-left mr-2"></i>
                        Perfil
                    </a>
                    <button id="mobileMenuToggle" class="md:hidden text-white hover:text-gray-200 transition-colors">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>
            <div id="mobileMenu" class="hidden md:hidden absolute top-full left-0 right-0 bg-primary shadow-lg border-t border-white border-opacity-20">
                <div class="container mx-auto px-4 py-4">
                    <a href="../" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                        <i class="bi bi-arrow-left mr-3"></i>
                        Perfil
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-20 min-h-screen">
        <div class="container mx-auto px-6 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Dispositivos Conectados</h1>
                <p class="text-gray-400">Gerencie os dispositivos conectados à sua conta do <strong>Minhas Vacinas</strong>. Caso reconheça alguma atividade suspeita, altere sua senha imediatamente.</p>
            </div>

            <!-- Security Alert -->
            <div class="bg-yellow-900 bg-opacity-20 border border-yellow-500 border-opacity-30 rounded-xl p-6 mb-8">
                <div class="flex items-start">
                    <i class="bi bi-shield-exclamation text-yellow-400 text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="text-yellow-400 font-semibold mb-2">Dica de Segurança</h3>
                        <p class="text-gray-300">Se você não reconhece algum dispositivo listado abaixo, remova-o imediatamente e altere sua senha. Mantenha sua conta sempre segura!</p>
                    </div>
                </div>
            </div>

            <!-- Devices Grid -->
            <?php if (!empty($dispositivos)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    $user_ip = $_SESSION['user_ip'];
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
                        <div class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-primary transition-all duration-300 group">
                            <!-- Device Icon and Status -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-primary bg-opacity-20 rounded-lg p-3">
                                    <i class="<?php echo $icone; ?> text-primary text-2xl"></i>
                                </div>
                                <?php if ($atual): ?>
                                    <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-medium">
                                        <i class="bi bi-circle-fill mr-1"></i>Atual
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Device Info -->
                            <div class="space-y-3 mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-1"><?php echo htmlspecialchars($dispositivo['nome_dispositivo']); ?></h3>
                                    <p class="text-sm text-gray-400"><?php echo ucfirst($dispositivo['tipo_dispositivo']); ?></p>
                                </div>

                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center text-gray-300">
                                        <i class="bi bi-clock text-primary mr-3"></i>
                                        <div>
                                            <span class="text-xs text-gray-400 block">Último acesso</span>
                                            <span class="font-medium"><?php echo date("d/m/Y H:i", strtotime($dispositivo['data_cadastro'])); ?></span>
                                        </div>
                                    </div>

                                    <div class="flex items-center text-gray-300">
                                        <i class="bi bi-router text-primary mr-3"></i>
                                        <div>
                                            <span class="text-xs text-gray-400 block">Endereço IP</span>
                                            <span class="font-medium font-mono"><?php echo htmlspecialchars($dispositivo['ip']); ?></span>
                                        </div>
                                    </div>

                                    <?php if (!empty($local)): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="bi bi-geo-alt text-primary mr-3"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Localização</span>
                                                <span class="font-medium"><?php echo htmlspecialchars($local); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="pt-4 border-t border-dark-700">
                                <?php if (!$atual): ?>
                                    <form action="../../backend/remover-dispositivo.php" method="POST" class="remove-device-form">
                                        <input type="hidden" name="dispositivo_id" value="<?php echo $dispositivo['id']; ?>" />
                                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors font-medium">
                                            <i class="bi bi-trash mr-2"></i>
                                            Remover Dispositivo
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="w-full flex items-center justify-center px-4 py-2 bg-gray-600 text-gray-300 rounded-lg cursor-not-allowed">
                                        <i class="bi bi-shield-check mr-2"></i>
                                        Dispositivo Atual
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-dark-800 rounded-xl p-12 text-center border border-dark-700">
                    <div class="bg-primary bg-opacity-20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="bi bi-laptop text-primary text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Nenhum dispositivo encontrado</h3>
                    <p class="text-gray-400 max-w-md mx-auto">Não há dispositivos conectados à sua conta no momento.</p>
                </div>
            <?php endif; ?>

            <!-- Help Section -->
            <div class="mt-12 bg-dark-800 rounded-xl p-8 border border-dark-700">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="bi bi-question-circle text-primary mr-3"></i>
                    Perguntas Frequentes
                </h3>

                <div class="space-y-4">
                    <div class="border-b border-dark-700 pb-4">
                        <h4 class="text-white font-medium mb-2">O que acontece quando removo um dispositivo?</h4>
                        <p class="text-gray-400 text-sm">O dispositivo será desconectado da sua conta e precisará fazer login novamente para acessar.</p>
                    </div>

                    <div class="border-b border-dark-700 pb-4">
                        <h4 class="text-white font-medium mb-2">Por que não consigo remover o dispositivo atual?</h4>
                        <p class="text-gray-400 text-sm">Por segurança, você não pode remover o dispositivo que está usando atualmente. Use outro dispositivo para removê-lo.</p>
                    </div>

                    <div>
                        <h4 class="text-white font-medium mb-2">Como posso melhorar a segurança da minha conta?</h4>
                        <p class="text-gray-400 text-sm">Ative a verificação em duas etapas, use senhas fortes e monitore regularmente os dispositivos conectados.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Código JavaScript para abrir/fechar o menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');

                    // Alterar ícone do botão
                    const icon = mobileMenuToggle.querySelector('i');
                    if (mobileMenu.classList.contains('hidden')) {
                        icon.className = 'bi bi-list text-2xl';
                    } else {
                        icon.className = 'bi bi-x text-2xl';
                    }
                });

                // Fechar menu ao clicar fora dele
                document.addEventListener('click', function(event) {
                    if (!mobileMenuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                        const icon = mobileMenuToggle.querySelector('i');
                        icon.className = 'bi bi-list text-2xl';
                    }
                });
            }
        });
    </script>

    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="remover-dispositivo.js"></script>
</body>

</html>