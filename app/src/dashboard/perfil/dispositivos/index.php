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
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Dispositivos</title>

    <!-- Meta Tags -->
    <meta name="description" content="Gerencie os dispositivos conectados à sua conta do Minhas Vacinas.">
    <meta name="keywords" content="dispositivos, segurança, gerenciar, conectados">
    <meta name="theme-color" content="#007bff">

    <!-- Favicon -->
    <link rel="icon" href="/app/public/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="/app/public/css/sweetalert-styles.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#007bff',
                        'primary-dark': '#0056b3',
                        'primary-light': '#66b3ff',
                        dark: '#0a0e1a',
                        'dark-light': '#1a1f2e',
                        'dark-card': '#252b3d',
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        slideIn: {
                            '0%': {
                                transform: 'translateX(-100%)'
                            },
                            '100%': {
                                transform: 'translateX(0)'
                            }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0a0e1a 0%, #1a1f2e 50%, #252b3d 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #007bff 0%, #66b3ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.4);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.6);
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, #1a1f2e 0%, #252b3d 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(0, 123, 255, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-link {
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background: rgba(0, 123, 255, 0.1);
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        /* Header Styles */
        .header {
            background: rgba(0, 123, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Device Card Hover Effects */
        .device-card {
            transition: all 0.3s ease;
        }

        .device-card:hover {
            transform: translateY(-4px);
            border-color: #007bff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* Modal Styles */
        .modal {
            backdrop-filter: blur(10px);
        }

        .modal-content {
            animation: fadeInUp 0.3s ease-out;
        }

        /* Mobile Sidebar */
        @media (max-width: 1023px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }

        /* Responsive adjustments */
        @media (min-width: 1024px) {
            .main-content {
                margin-left: 16rem;
            }
        }
    </style>
</head>

<body class="bg-dark text-white font-inter overflow-x-hidden">
    <header class="fixed top-0 left-0 right-0 z-50 header">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-opacity-20 rounded-lg flex items-center justify-center">
                        <img src="/app/public/img/logo-head.png" alt="">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Minhas Vacinas</h1>
                        <p class="text-xs text-blue-100">Dashboard</p>
                    </div>
                </div>

                <button id="sidebarToggle" class="lg:hidden text-white hover:text-blue-200 transition-colors p-2">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </nav>
    </header>

    <aside id="sidebar" class="fixed left-0 top-16 h-full w-64 sidebar transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="p-6">
            <div class="flex flex-col space-y-4 h-full">
                <!-- Navigation Links -->
                <nav class="space-y-2">
                    <a href="../../" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-home text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="../../vacinas/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-syringe text-lg"></i>
                        <span>Minhas Vacinas</span>
                    </a>
                    <a href="../" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-user text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-laptop text-lg"></i>
                        <span>Dispositivos</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="mt-auto pt-6 border-t border-gray-600">
                    <div class="flex items-center space-x-3 p-4 rounded-lg bg-dark-light">
                        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate"><?php echo isset($_SESSION['user_nome']) ? explode(' ', $_SESSION['user_nome'])[0] : 'Usuário'; ?></p>
                            <button class="text-xs text-gray-400 hover:text-white transition-colors" id="btnLogout">
                                <i class="fas fa-sign-out-alt mr-1"></i>Sair
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    ''

    <!-- Main Content -->
    <main class="main-content pt-20 min-h-screen">
        <div class="container mx-auto px-6 py-8">
            <!-- Header Section -->
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-3xl font-bold text-white mb-2">Dispositivos Conectados</h1>
                <p class="text-gray-400">Gerencie os dispositivos conectados à sua conta do <strong>Minhas Vacinas</strong>. Caso reconheça alguma atividade suspeita, altere sua senha imediatamente.</p>
            </div>

            <!-- Security Alert -->
            <div class="bg-yellow-900 bg-opacity-20 border border-yellow-500 border-opacity-30 rounded-xl p-6 mb-8">
                <div class="flex items-start">
                    <i class="fas fa-shield-exclamation text-yellow-400 text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="text-yellow-400 font-semibold mb-2">Dica de Segurança</h3>
                        <p class="text-gray-300">Se você não reconhece algum dispositivo listado abaixo, remova-o imediatamente e altere sua senha. Mantenha sua conta sempre segura!</p>
                    </div>
                </div>
            </div>

            <!-- Devices Grid -->
            <?php if (!empty($dispositivos)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <?php
                    $user_ip = $_SESSION['user_ip'];
                    foreach ($dispositivos as $dispositivo):
                        $atual = $dispositivo['ip'] === $user_ip;
                        $icone = $dispositivo['tipo_dispositivo'] === 'Desktop' || $atual
                            ? 'fas fa-desktop'
                            : ($dispositivo['tipo_dispositivo'] === 'Mobile'
                                ? 'fas fa-mobile-alt'
                                : ($dispositivo['tipo_dispositivo'] === 'Tablet'
                                    ? 'fas fa-tablet-alt'
                                    : 'fas fa-server'));
                        $local = trim(implode(', ', array_filter([$dispositivo['cidade'], $dispositivo['estado'], $dispositivo['pais']])));
                    ?>
                        <div class="device-card bg-dark-card rounded-xl p-6 border border-gray-600 group">
                            <!-- Device Icon and Status -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-primary bg-opacity-20 rounded-lg p-3">
                                    <i class="<?php echo $icone; ?> text-primary text-2xl"></i>
                                </div>
                                <?php if ($atual): ?>
                                    <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-medium">
                                        <i class="fas fa-circle mr-1"></i>Atual
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
                                        <i class="fas fa-clock text-primary mr-3"></i>
                                        <div>
                                            <span class="text-xs text-gray-400 block">Último acesso</span>
                                            <span class="font-medium"><?php echo date("d/m/Y H:i", strtotime($dispositivo['data_cadastro'])); ?></span>
                                        </div>
                                    </div>

                                    <div class="flex items-center text-gray-300">
                                        <i class="fas fa-wifi text-primary mr-3"></i>
                                        <div>
                                            <span class="text-xs text-gray-400 block">Endereço IP</span>
                                            <span class="font-medium font-mono"><?php echo htmlspecialchars($dispositivo['ip']); ?></span>
                                        </div>
                                    </div>

                                    <?php if (!empty($local)): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-map-marker-alt text-primary mr-3"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Localização</span>
                                                <span class="font-medium"><?php echo htmlspecialchars($local); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="pt-4 border-t border-gray-600">
                                <?php if (!$atual): ?>
                                    <form action="../../backend/remover-dispositivo.php" method="POST" class="remove-device-form">
                                        <input type="hidden" name="dispositivo_id" value="<?php echo $dispositivo['id']; ?>" />
                                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors font-medium">
                                            <i class="fas fa-trash mr-2"></i>
                                            Remover Dispositivo
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="w-full flex items-center justify-center px-4 py-2 bg-gray-600 text-gray-300 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-shield-check mr-2"></i>
                                        Dispositivo Atual
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- No devices message -->
                <div class="bg-dark-800 rounded-xl p-12 text-center border border-dark-700">
                    <div class="bg-primary bg-opacity-20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-laptop text-primary text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Nenhum dispositivo encontrado</h3>
                    <p class="text-gray-400 max-w-md mx-auto">Não há dispositivos conectados à sua conta no momento.</p>
                </div>
            <?php endif; ?>

            <!-- Help Section -->
            <div class="bg-dark-card rounded-xl p-8 border border-gray-600">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-question-circle text-primary mr-3"></i>
                    Perguntas Frequentes
                </h3>

                <div class="space-y-4">
                    <div class="border-b border-gray-600 pb-4">
                        <h4 class="text-white font-medium mb-2">O que acontece quando removo um dispositivo?</h4>
                        <p class="text-gray-400 text-sm">O dispositivo será desconectado da sua conta e precisará fazer login novamente para acessar.</p>
                    </div>

                    <div class="border-b border-gray-600 pb-4">
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

    <!-- Remove Device Modal -->
    <div id="removeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 modal">
        <div class="bg-dark-card rounded-xl p-8 max-w-md w-full border border-gray-600 modal-content">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Remover Dispositivo</h3>
                <button onclick="closeRemoveModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <p class="text-gray-300 mb-6">Tem certeza que deseja remover este dispositivo? Esta ação não pode ser desfeita.</p>

            <div class="flex flex-col sm:flex-row gap-4">
                <button id="confirmRemove" class="flex-1 flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors font-medium">
                    <i class="fas fa-trash mr-2"></i>
                    Remover
                </button>
                <button onclick="closeRemoveModal()" class="flex-1 flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function toggleSidebar() {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        // Toggle no botão
        sidebarToggle.addEventListener('click', toggleSidebar);

        // Fecha ao clicar no overlay
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Fecha no ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        document.getElementById('btnLogout').addEventListener('click', () => {
            Swal.fire({
                title: 'Tem certeza que deseja sair?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, sair',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redireciona para a página PHP que destrói a sessão
                    window.location.href = '/app/src/utils/Sair.php';
                }
            });
        });
    </script>
    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="remover-dispositivo.js"></script>
</body>

</html>