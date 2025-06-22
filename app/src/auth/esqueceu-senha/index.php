<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Recuperar Senha</title>

    <!-- Meta Tags -->
    <meta name="description" content="Recupere sua senha do Minhas Vacinas. Enviaremos um link seguro para redefinir sua senha.">
    <meta name="keywords" content="recuperar senha, esqueci senha, reset, redefinir">
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
                        <a href="#" class="text-gray-300 hover:text-primary transition-colors font-medium">FAQ</a>
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

    <!-- Hero Section -->
    <section class="pt-20 pb-8 gradient-bg hero-pattern relative overflow-hidden">
        <!-- Floating Elements -->
        <div class="absolute top-10 left-10 w-8 h-8 bg-primary/20 rounded-full blur-lg animate-float-slow"></div>
        <div class="absolute top-20 right-20 w-12 h-12 bg-primary/10 rounded-full blur-xl animate-float-fast"></div>

        <div class="container mx-auto px-6 pt-8">
            <div class="max-w-2xl mx-auto text-center">
                <div class="animate-fade-in-up">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-key text-white text-lg"></i>
                    </div>

                    <h1 class="text-2xl lg:text-3xl font-bold mb-4 leading-tight">
                        Esqueceu sua <span class="text-gradient">senha?</span>
                    </h1>

                    <p class="text-base text-gray-300 mb-6 leading-relaxed">
                        Não se preocupe! Vamos ajudá-lo a recuperar o acesso
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recovery Form Section -->
    <section class="py-12 bg-gradient-to-b from-dark to-dark-light">
        <div class="container mx-auto px-6">
            <div class="max-w-lg mx-auto">
                <div class="glass-card rounded-2xl p-6 md:p-8">

                    <!-- Instructions -->
                    <div class="text-center mb-6">
                        <div class="bg-primary/10 rounded-xl p-4 border border-primary/20 mb-4">
                            <i class="fas fa-info-circle text-primary text-lg mb-2"></i>
                            <p class="text-gray-300 text-sm leading-relaxed">
                                Digite seu e-mail e enviaremos um <span class="text-primary font-semibold">link seguro</span>
                                para redefinir sua senha.
                            </p>
                        </div>
                    </div>

                    <!-- Recovery Form -->
                    <form id="form_recovery" class="space-y-4" method="post" action="../backend/esqueceu_senha.php">
                        <div>
                            <label for="email" class="block text-xs font-medium text-gray-300 mb-1">
                                E-mail cadastrado <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                autocomplete="off"
                                class="w-full px-3 py-2.5 bg-dark border border-primary/30 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-200">
                            <p class="text-xs text-gray-400 mt-1">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Verificaremos se este e-mail está cadastrado
                            </p>
                        </div>

                        <button
                            type="submit"
                            id="submitBtn"
                            class="w-full btn-primary px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary/50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-paper-plane mr-2"></i>
                            <span id="btn-text">Enviar Link de Recuperação</span>
                            <div id="loading-spinner" class="hidden inline-block ml-2">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                            </div>
                        </button>
                    </form>

                    <!-- Back to Login -->
                    <div class="mt-6 text-center">
                        <div class="relative my-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-primary/20"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-3 bg-dark-card text-gray-400 text-xs">Lembrou da senha?</span>
                            </div>
                        </div>

                        <a href="../entrar/" class="inline-flex items-center text-primary hover:text-blue-400 transition-colors font-semibold text-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Voltar para o login
                        </a>
                    </div>

                    <!-- Security Info -->
                    <div class="mt-6 bg-dark/50 rounded-xl p-4 border border-primary/10">
                        <h3 class="text-sm font-semibold text-white mb-3 flex items-center">
                            <i class="fas fa-shield-alt text-primary mr-2"></i>
                            Informações de Segurança
                        </h3>
                        <div class="space-y-2 text-xs text-gray-400">
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-400 mt-0.5 text-xs"></i>
                                <span>O link expira em 1 hora por segurança</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-400 mt-0.5 text-xs"></i>
                                <span>Verifique sua caixa de spam</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-400 mt-0.5 text-xs"></i>
                                <span>Cada link só pode ser usado uma vez</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-card border-t border-primary/20">
        <div class="container mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-virus text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-primary">Minhas Vacinas</h3>
                            <p class="text-xs text-gray-400">Saúde Digital</p>
                        </div>
                    </div>
                    <p class="text-gray-400">Protegendo você e sua família com informações e controle digital de vacinas.</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Serviços</h3>
                    <ul class="space-y-2">
                        <li><a href="../cadastro/" class="text-gray-400 hover:text-primary transition-colors">Cadastro</a></li>
                        <li><a href="/app/src/ajuda/" class="text-gray-400 hover:text-primary transition-colors">Suporte</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Histórico</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Lembretes</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Links Úteis</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Política de Privacidade</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Termos de Serviço</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Contato</h3>
                    <div class="space-y-2">
                        <p class="text-gray-400 flex items-center">
                            <i class="fas fa-envelope mr-2 text-primary"></i>
                            contato@minhasvacinas.online
                        </p>
                        <p class="text-gray-400 flex items-center">
                            <i class="fas fa-clock mr-2 text-primary"></i>
                            24/7 Disponível
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-primary/20 bg-dark py-6">
            <div class="container mx-auto px-6">
                <p class="text-center text-gray-400">
                    © 2025 Minhas Vacinas. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

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
    </script>
    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>