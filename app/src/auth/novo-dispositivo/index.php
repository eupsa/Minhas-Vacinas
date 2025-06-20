<?php
require_once '../../utils/ConexaoDB.php';
session_start();

if (isset($_GET['deviceid']) && isset($_GET['userid'])) {
    $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE id = :deviceid AND id_usuario = :userid");
    $sql->bindValue(':deviceid', $_GET['deviceid']);
    $sql->bindValue(':userid', $_GET['userid']);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $dadosDispositivos = $sql->fetch();

        $dadosDispositivos['data_cadastro'] = DateTime::createFromFormat('Y-m-d H:i:s', $dadosDispositivos['data_cadastro']);
    }
} else {
    header("Location: /");
    exit;
}
?>



<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Novo Dispositivo</title>

    <!-- Meta Tags -->
    <meta name="description" content="Confirme seu novo dispositivo para acessar sua conta Minhas Vacinas com segurança.">
    <meta name="keywords" content="novo dispositivo, confirmação, segurança, acesso">
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
                        'float-slow': 'float 6s ease-in-out infinite',
                        'float-fast': 'float 4s ease-in-out infinite',
                        'slide-in-left': 'slideInLeft 0.8s ease-out',
                        'slide-in-right': 'slideInRight 0.8s ease-out',
                        'scale-in': 'scaleIn 0.6s ease-out',
                        'glow-pulse': 'glowPulse 2s ease-in-out infinite',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'slide-out': 'slideOut 0.3s ease-in',
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'spin-slow': 'spin 2s linear infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
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
                        slideIn: {
                            '0%': {
                                transform: 'translateX(100%)'
                            },
                            '100%': {
                                transform: 'translateX(0)'
                            }
                        },
                        slideOut: {
                            '0%': {
                                transform: 'translateX(0)'
                            },
                            '100%': {
                                transform: 'translateX(100%)'
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

        /* Navbar Styles */
        .navbar {
            background: rgba(10, 14, 26, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 123, 255, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-scrolled {
            background: rgba(10, 14, 26, 0.95) !important;
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-bottom: 1px solid rgba(0, 123, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        /* Off-canvas styles */
        .off-canvas-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .off-canvas-menu {
            background: linear-gradient(135deg, #1a1f2e 0%, #252b3d 100%);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.3);
        }

        /* Hamburger Animation */
        .hamburger-line {
            transition: all 0.3s ease;
            transform-origin: center;
        }

        .hamburger-active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .hamburger-active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger-active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }
    </style>
</head>

<body class="bg-dark text-white font-inter overflow-x-hidden">
    <!-- Header -->
    <header class="fixed top-0 w-full z-50" id="header">
        <nav class="navbar">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                            <img src="/app/public/img/logo-head.png" alt="">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">Minhas Vacinas</h1>
                            <p class="text-xs text-gray-400">Saúde Digital</p>
                        </div>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="/" class="text-gray-300 hover:text-primary transition-colors font-medium">Início</a>
                        <a href="/app/src/ajuda/" class="text-gray-300 hover:text-primary transition-colors font-medium">Suporte</a>
                        <a href="../cadastro/" class="text-gray-300 hover:text-primary transition-colors font-medium">Cadastro</a>
                    </div>

                    <!-- CTA Button -->
                    <div class="hidden md:block">
                        <a href="../entrar/" class="btn-primary px-6 py-2 rounded-full text-white font-medium">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Fazer Login
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-white relative z-50 p-2" id="mobile-menu-btn">
                        <div class="w-6 h-6 flex flex-col justify-center items-center space-y-1">
                            <span class="block w-6 h-0.5 bg-current hamburger-line"></span>
                            <span class="block w-6 h-0.5 bg-current hamburger-line"></span>
                            <span class="block w-6 h-0.5 bg-current hamburger-line"></span>
                        </div>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Off-Canvas Overlay -->
    <div class="fixed inset-0 off-canvas-overlay z-40 opacity-0 invisible transition-all duration-300" id="off-canvas-overlay"></div>

    <!-- Off-Canvas Menu -->
    <div class="fixed top-0 right-0 h-full w-80 max-w-sm off-canvas-menu z-50 transform translate-x-full transition-transform duration-300 ease-in-out" id="off-canvas-menu">
        <div class="flex flex-col h-full">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-600">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <img src="/app/public/img/logo-head.png" alt="">
                    </div>
                    <div>
                        <h2 class="font-bold text-white">Menu</h2>
                        <p class="text-xs text-gray-400">Navegação</p>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-white transition-colors p-2" id="close-menu-btn">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="space-y-2">
                    <a href="/" class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-home text-primary group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Início</h3>
                            <p class="text-xs text-gray-400">Página principal</p>
                        </div>
                    </a>

                    <a href="/app/src/ajuda/" class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-headset text-primary group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Suporte</h3>
                            <p class="text-xs text-gray-400">Central de ajuda</p>
                        </div>
                    </a>

                    <a href="../cadastro/" class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-user-plus text-primary group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Cadastro</h3>
                            <p class="text-xs text-gray-400">Criar conta</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="p-6 border-t border-gray-600 space-y-4">
                <a href="../entrar/" class="w-full btn-primary px-6 py-3 rounded-xl text-white font-semibold flex items-center justify-center space-x-2">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Fazer Login</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="min-h-screen flex items-center justify-center gradient-bg hero-pattern relative overflow-hidden">
        <!-- Floating Elements -->
        <div class="absolute top-10 left-10 w-16 h-16 bg-primary/20 rounded-full blur-lg animate-float-slow"></div>
        <div class="absolute top-20 right-20 w-20 h-20 bg-primary/10 rounded-full blur-xl animate-float-fast"></div>
        <div class="absolute bottom-10 left-1/4 w-12 h-12 bg-primary/15 rounded-full blur-lg animate-float-slow" style="animation-delay: 2s;"></div>

        <div class="container mx-auto px-6 pt-20">
            <div class="max-w-2xl mx-auto text-center">
                <div class="glass-card rounded-2xl p-8 md:p-12 animate-scale-in">

                    <!-- Device Icon -->
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-light rounded-xl flex items-center justify-center mx-auto mb-6 animate-glow-pulse">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>

                    <h1 class="text-2xl lg:text-3xl font-bold mb-6 leading-tight">
                        Confirmar <span class="text-gradient">Novo Dispositivo</span>
                    </h1>

                    <p class="text-base text-gray-300 mb-8 leading-relaxed">
                        Para sua segurança, precisamos confirmar este novo dispositivo antes de permitir o acesso à sua conta.
                    </p>

                    <!-- Device Info -->
                    <div class="bg-primary/10 rounded-xl p-4 border border-primary/20 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-globe text-primary"></i>
                                <span class="text-gray-300">IP: <span class="text-white font-mono"><?= $dadosDispositivos['ip'] ?></span></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-clock text-primary"></i>
                                <span class="text-gray-300"><?= $dadosDispositivos['data_cadastro']->format('d/m/Y H:i:s') ?></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-desktop text-primary"></i>
                                <span class="text-gray-300"><?= $dadosDispositivos['navegador'] ?></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                <span class="text-gray-300"><?= $dadosDispositivos['cidade'] . ', ' . $dadosDispositivos['pais'] ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Form -->
                    <form id="deviceForm" class="space-y-6" method="POST" action="../backend/novo-dispositivo.php">
                        <div>
                            <label for="deviceName" class="block text-xs font-medium text-gray-300 mb-2 text-left">
                                Nome do dispositivo (opcional)
                            </label>
                            <input
                                type="text"
                                id="deviceName"
                                name="deviceName"
                                class="w-full px-3 py-2.5 bg-dark border border-primary/30 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-200"
                                placeholder="<?= $dadosDispositivos['nome_dispositivo'] ?>">
                        </div>

                        <input type="hidden" name="btn_id" id="btn_id" value="">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                type="submit"
                                id="confirmBtn"
                                data-id="1"
                                class="flex-1 btn-primary px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary/50 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-check mr-2"></i>
                                <span id="confirm-text">Confirmar Dispositivo</span>
                                <div id="confirm-spinner" class="hidden inline-block ml-2">
                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                                </div>
                            </button>

                            <button
                                type="submit"
                                id="denyBtn"
                                data-id="0"
                                class="flex-1 bg-transparent border border-red-500 text-red-400 hover:bg-red-500 hover:text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-red-500/50">
                                <i class="fas fa-times mr-2"></i>
                                Negar Acesso
                            </button>
                        </div>
                    </form>

                    <!-- Security Info -->
                    <div class="mt-8 bg-dark/50 rounded-xl p-4 border border-primary/10">
                        <h3 class="text-sm font-semibold text-white mb-3 flex items-center">
                            <i class="fas fa-shield-alt text-primary mr-2"></i>
                            Informações de Segurança
                        </h3>
                        <div class="space-y-2 text-xs text-gray-400 text-left">
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-400 mt-0.5 text-xs"></i>
                                <span>Este dispositivo será lembrado até que você o exclua.</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-400 mt-0.5 text-xs"></i>
                                <span>Você pode revogar o acesso a qualquer momento.</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-400 mt-0.5 text-xs"></i>
                                <span>Receba notificações de novos acessos.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script>
        // Variables
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const offCanvasMenu = document.getElementById('off-canvas-menu');
        const offCanvasOverlay = document.getElementById('off-canvas-overlay');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const header = document.getElementById('header');
        const navbar = header.querySelector('.navbar');

        // Off-Canvas Menu Functions
        function openMenu() {
            offCanvasMenu.classList.remove('translate-x-full');
            offCanvasOverlay.classList.remove('opacity-0', 'invisible');
            document.body.classList.add('overflow-hidden');
            mobileMenuBtn.classList.add('hamburger-active');
        }

        function closeMenu() {
            offCanvasMenu.classList.add('translate-x-full');
            offCanvasOverlay.classList.add('opacity-0', 'invisible');
            document.body.classList.remove('overflow-hidden');
            mobileMenuBtn.classList.remove('hamburger-active');
        }

        // Event Listeners
        mobileMenuBtn.addEventListener('click', openMenu);
        closeMenuBtn.addEventListener('click', closeMenu);
        offCanvasOverlay.addEventListener('click', closeMenu);

        // Close menu when clicking on navigation links
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // Header Scroll Effect
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !offCanvasMenu.classList.contains('translate-x-full')) {
                closeMenu();
            }
        });


        // Data-id
        document.querySelectorAll('#deviceForm button[type="submit"]').forEach(button => {
            button.addEventListener('click', function(event) {
                // pega o data-id do botão clicado
                const dataId = this.getAttribute('data-id');

                // seta no input hidden
                document.getElementById('btn_id').value = dataId;
            });
        });
    </script>
</body>

</html>