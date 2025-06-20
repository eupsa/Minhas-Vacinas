<?php
session_start();
require_once '../utils/ConexaoDB.php';
require_once '../utils/UsuarioAuth.php';

Auth($pdo);

$sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario ORDER BY id_vac DESC LIMIT 3");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();
$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);


$sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario ORDER BY id_vac DESC LIMIT 3");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();
$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();
$totalCount = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $pdo->prepare("
    SELECT
        id_usuario,
        nome,
        email,
        estado,
        senha,
        data_nascimento,
        genero,
        cpf,
        telefone,
        cidade,
        foto_perfil,
        ROUND(
            (
                (nome IS NOT NULL AND nome != '') +
                (email IS NOT NULL AND email != '') +
                (estado IS NOT NULL AND email != '') +
                (senha IS NOT NULL AND senha != '') +
                (data_nascimento IS NOT NULL) + -- Simplified check for DATE column
                (genero IS NOT NULL AND genero != 'Não Informado') +
                (cpf IS NOT NULL AND cpf != '') +
                (telefone IS NOT NULL AND telefone != '') +
                (cidade IS NOT NULL AND cidade != 'Não informado') +
                (foto_perfil IS NOT NULL AND foto_perfil != '')
            ) / 10 * 100, 0
        ) AS percentual_completo
    FROM usuario
    WHERE id_usuario = :id
");
$sql->bindValue(':id', $_SESSION['user_id']);
$sql->execute();
$usuario = $sql->fetch(PDO::FETCH_ASSOC);


$_SESSION['vacinas'] = $vacinas ?: [];
?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Dashboard</title>

    <!-- Meta Tags -->
    <meta name="description" content="Dashboard do Minhas Vacinas - Gerencie suas vacinas e mantenha seu histórico sempre atualizado.">
    <meta name="keywords" content="dashboard, vacinas, saúde, controle, histórico">
    <meta name="theme-color" content="#007bff">

    <!-- Favicon -->
    <link rel="icon" href="/app/public/img/img-web.png" type="image/x-icon">

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
                        'float-slow': 'float 6s ease-in-out infinite',
                        'float-fast': 'float 4s ease-in-out infinite',
                        'slide-in-left': 'slideInLeft 0.8s ease-out',
                        'slide-in-right': 'slideInRight 0.8s ease-out',
                        'scale-in': 'scaleIn 0.6s ease-out',
                        'glow-pulse': 'glowPulse 2s ease-in-out infinite',
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            }
                        },
                        slideInLeft: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(-50px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
                        },
                        slideInRight: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(50px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
                        },
                        scaleIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.8)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            }
                        },
                        glowPulse: {
                            '0%, 100%': {
                                boxShadow: '0 0 20px rgba(0, 123, 255, 0.4)'
                            },
                            '50%': {
                                boxShadow: '0 0 40px rgba(0, 123, 255, 0.8)'
                            }
                        },
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
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

        .glass-card {
            background: rgba(37, 43, 61, 0.3);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 123, 255, 0.2);
        }

        .hero-pattern {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(0, 123, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(0, 123, 255, 0.1) 0%, transparent 50%);
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

        /* Card Hover Effects */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-2px);
            border-color: #007bff;
        }
    </style>
</head>

<body class="bg-dark text-white font-inter overflow-x-hidden">
    <!-- Header -->
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

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-16 h-full w-64 sidebar transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="p-6">
            <div class="flex flex-col space-y-4 h-full">
                <!-- Navigation Links -->
                <nav class="space-y-2">
                    <a href="#" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-home text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="vacinas/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-syringe text-lg"></i>
                        <span>Minhas Vacinas</span>
                    </a>
                    <a href="perfil/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-user text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="perfil/dispositivos/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
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
                            <button class="text-xs text-gray-400 hover:text-white transition-colors">
                                <i class="fas fa-sign-out-alt mr-1"></i>Sair
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div class="container mx-auto px-6 py-8">
            <!-- Welcome Section -->
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-3xl font-bold text-white mb-2">
                    Bem-vindo, <span class="text-gradient"><?php echo isset($_SESSION['user_nome']) ? explode(' ', $_SESSION['user_nome'])[0] : 'Usuário'; ?></span>! 👋
                </h1>
                <p class="text-gray-400 text-lg">Gerencie suas vacinas e mantenha seu histórico sempre atualizado.</p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stat-card bg-gradient-to-r from-primary to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total de Vacinas</p>
                            <p class="text-3xl font-bold"><?= count($totalCount) ?></p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <i class="fas fa-syringe text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Perfil Completo</p>
                            <p class="text-3xl font-bold"><?= ($usuario['percentual_completo']) ?>%</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <i class="fas fa-user-check text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Conta Segura</p>
                            <p class="text-3xl font-bold">
                                <i class="fas fa-shield-check"></i>
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <i class="fas fa-lock text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-6">Ações Rápidas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="vacinas/nova-vacina/" class="feature-card bg-dark-card rounded-xl p-6 border border-gray-600 hover:border-primary transition-all duration-300 group">
                        <div class="flex items-center mb-4">
                            <div class="bg-primary bg-opacity-20 rounded-lg p-3 mr-3 group-hover:bg-primary group-hover:bg-opacity-100 transition-all duration-300">
                                <i class="fas fa-plus text-primary group-hover:text-white text-xl"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Nova Vacina</h3>
                        <p class="text-gray-400 text-sm">Registre uma nova vacina aplicada</p>
                    </a>

                    <a href="vacinas/" class="feature-card bg-dark-card rounded-xl p-6 border border-gray-600 hover:border-primary transition-all duration-300 group">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500 bg-opacity-20 rounded-lg p-3 mr-3 group-hover:bg-green-500 group-hover:bg-opacity-100 transition-all duration-300">
                                <i class="fas fa-list text-green-400 group-hover:text-white text-xl"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Ver Histórico</h3>
                        <p class="text-gray-400 text-sm">Visualize todas suas vacinas</p>
                    </a>

                    <a href="perfil/" class="feature-card bg-dark-card rounded-xl p-6 border border-gray-600 hover:border-primary transition-all duration-300 group">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-500 bg-opacity-20 rounded-lg p-3 mr-3 group-hover:bg-yellow-500 group-hover:bg-opacity-100 transition-all duration-300">
                                <i class="fas fa-user-edit text-yellow-400 group-hover:text-white text-xl"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Editar Perfil</h3>
                        <p class="text-gray-400 text-sm">Atualize suas informações</p>
                    </a>

                    <a href="perfil/dispositivos/" class="feature-card bg-dark-card rounded-xl p-6 border border-gray-600 hover:border-primary transition-all duration-300 group">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-500 bg-opacity-20 rounded-lg p-3 mr-3 group-hover:bg-purple-500 group-hover:bg-opacity-100 transition-all duration-300">
                                <i class="fas fa-shield-alt text-purple-400 group-hover:text-white text-xl"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Segurança</h3>
                        <p class="text-gray-400 text-sm">Gerencie dispositivos e 2FA</p>
                    </a>
                </div>
            </section>

            <!-- Recent Vaccines -->
            <section class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Últimas Vacinas</h2>
                    <a href="vacinas/" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                        <i class="fas fa-eye mr-2"></i>
                        Ver todas
                    </a>
                </div>

                <?php if (count($vacinas) > 0): ?>
                    <?php foreach ($vacinas as $vacina): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="feature-card bg-dark-card rounded-xl overflow-hidden border border-gray-600 hover:border-primary transition-all duration-300 group">
                                <?php if (isset($vacina['path_card'])): ?>
                                    <img src="<?php echo $vacina['path_card']; ?>" alt="Vacina" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                <?php else: ?>
                                    <div class="w-full h-32 bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center">
                                        <i class="fas fa-syringe text-white text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-white mb-4"><?= htmlspecialchars($vacina['nome_vac']) ?></h3>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-calendar text-primary mr-2"></i>
                                            <span><?= date('d/m/Y', strtotime($vacina['data_aplicacao'])) ?></span>
                                        </div>
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                            <span><?= htmlspecialchars($vacina['local_aplicacao']) ?></span>
                                        </div>
                                        <?php if (!empty($vacina['dose'])): ?>
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-syringe text-primary mr-2"></i>
                                                <span><?= htmlspecialchars($vacina['dose']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-400 text-center mt-6">Nenhuma vacina registrada até o momento.</p>
                <?php endif; ?>
            </section>

            <!-- Updates Section -->
            <section>
                <h2 class="text-2xl font-bold text-white mb-6">Atualizações e Novidades</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Available Updates -->
                    <div class="feature-card bg-dark-card rounded-xl p-6 border border-gray-600 hover:border-primary transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="fas fa-check-circle text-green-400 text-xl"></i>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Disponível</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Exportar PDF</h3>
                        <p class="text-gray-400 mb-4 text-sm">Exporte seu histórico de vacinas em PDF</p>
                        <button class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                            <i class="fas fa-download mr-2"></i>
                            Usar agora
                        </button>
                    </div>

                    <div class="feature-card bg-dark-card rounded-xl p-6 border border-gray-600 hover:border-primary transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="fas fa-check-circle text-green-400 text-xl"></i>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Disponível</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Lembretes</h3>
                        <p class="text-gray-400 mb-4 text-sm">Receba notificações de próximas doses</p>
                        <button class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                            <i class="fas fa-bell mr-2"></i>
                            Configurar
                        </button>
                    </div>

                    <!-- In Development -->
                    <div class="feature-card bg-dark-card rounded-xl p-6 border border-gray-600 hover:border-yellow-500 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="fas fa-clock text-yellow-400 text-xl"></i>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Em breve</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">App Mobile</h3>
                        <p class="text-gray-400 mb-4 text-sm">Aplicativo para iOS e Android</p>
                        <button class="inline-flex items-center px-4 py-2 bg-gray-600 text-gray-400 rounded-lg cursor-not-allowed text-sm">
                            <i class="fas fa-mobile-alt mr-2"></i>
                            Indisponível
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    <!-- JavaScript -->
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        sidebarToggle.addEventListener('click', openSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Close sidebar when clicking on navigation links on mobile
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        // Animate stats on load
        function animateStats() {
            const statNumbers = document.querySelectorAll('.stat-card .text-3xl');

            statNumbers.forEach((stat, index) => {
                const finalValue = stat.textContent;
                if (!isNaN(finalValue)) {
                    let currentValue = 0;
                    const increment = finalValue / 50;

                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            stat.textContent = finalValue;
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(currentValue);
                        }
                    }, 30);
                }
            });
        }

        // Run animations when page loads
        window.addEventListener('load', () => {
            setTimeout(animateStats, 500);
        });
    </script>
</body>

</html>