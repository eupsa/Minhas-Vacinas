<?php
session_start();
require_once __DIR__ . '../../../../../libs/autoload.php';

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../../painel/");
    exit();
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
$dotenv->load();
?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/app/public/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="/app/public/css/sweetalert-styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#007bff',
                        'primary-dark': '#0056b3',
                        dark: '#0f172a',
                        'dark-light': '#1e293b',
                        'dark-lighter': '#334155'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'bounce-slow': 'bounce 2s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        slideUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(40px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        glow: {
                            '0%': {
                                boxShadow: '0 0 20px rgba(0, 123, 255, 0.5)'
                            },
                            '100%': {
                                boxShadow: '0 0 30px rgba(0, 123, 255, 0.8)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Minhas Vacinas - Entrar</title>
</head>

<body class="bg-dark text-white min-h-screen">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-dark/95 backdrop-blur-md border-b border-primary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="/app/public/img/logo-head.png" alt="Logo Vacinas" class="h-10 w-auto">
                        <span class="text-xl font-bold text-primary">Minhas Vacinas</span>
                    </a>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Início</a>
                        <a href="/#nossa-missao" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Sobre</a>
                        <a href="../../ajuda/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Suporte</a>
                        <a href="../../FAQ/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">FAQ</a>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="../cadastro/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white px-6 py-2 rounded-full transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>CADASTRE-SE
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white hover:text-primary focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-dark-light border-t border-primary/20">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Início</a>
                <a href="/#nossa-missao" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Sobre</a>
                <a href="../../ajuda/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Suporte</a>
                <a href="../../FAQ/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">FAQ</a>

                <div class="border-t border-primary/20 pt-4 mt-4">
                    <a href="../cadastro/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white block text-center px-4 py-2 rounded-full transition-all duration-200">
                        <i class="fas fa-user-plus mr-2"></i>CADASTRE-SE
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-36 pb-6 bg-gradient-to-br from-dark via-dark-light to-dark relative overflow-hidden">
        <!-- Background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/10 rounded-full blur-2xl animate-bounce-slow"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-primary/10 rounded-full blur-2xl animate-bounce-slow" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-400 rounded-full flex items-center justify-center mx-auto mb-4 animate-glow">
                    <i class="fas fa-sign-in-alt text-xl text-white"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold mb-4 bg-gradient-to-r from-white via-primary to-white bg-clip-text text-transparent">
                    Entre na sua Conta
                </h1>
                <p class="text-base text-gray-300 mb-4 max-w-xl mx-auto">
                    Acesse sua conta e mantenha o controle da saúde da sua família
                </p>
            </div>
        </div>
    </section>

    <!-- Login Form Section -->
    <section class="py-16 bg-gradient-to-b from-dark to-dark-light">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-dark-light/50 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-primary/20 shadow-2xl">

                <!-- Google Sign In -->
                <div class="text-center mb-8" style="align-items: center; justify-content: center; justify-items: center;">
                    <div id="g_id_onload"
                        data-client_id="<?= $_ENV['GOOGLE_ID_CLIENT'] ?>"
                        data-context="signin"
                        data-ux_mode="redirect"
                        data-login_uri="<?= $_ENV['GOOGLE_REDIRECT_LOGIN'] ?>"
                        data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin"
                        data-type="standard"
                        data-shape="rectangular"
                        data-theme="filled_blue"
                        data-size="large"
                        data-text="signin_with"
                        data-width="300">
                    </div>
                </div>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-primary/30"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-dark-light text-gray-400">Ou entre com e-mail</span>
                    </div>
                </div>

                <!-- Error/Success Messages -->
                <?php if (isset($_SESSION['erro_email'])): ?>
                    <div class="mb-6 bg-red-500/20 border border-red-500/30 rounded-lg p-4 animate-fade-in">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                            <span class="text-red-300"><?= $_SESSION['erro_email'] ?></span>
                        </div>
                    </div>
                    <?php unset($_SESSION['erro_email']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['sucesso-email'])): ?>
                    <div class="mb-6 bg-green-500/20 border border-green-500/30 rounded-lg p-4 animate-fade-in">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 mr-3"></i>
                            <span class="text-green-300"><?= $_SESSION['sucesso-email'] ?></span>
                        </div>
                    </div>
                    <?php unset($_SESSION['sucesso-email']); ?>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="../backend/entrar.php" method="post" id="form_login" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            E-mail <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full px-4 py-3 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                            placeholder="seu@email.com">
                    </div>

                    <div>
                        <label for="senha" class="block text-sm font-medium text-gray-300 mb-2">
                            Senha <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="senha"
                                name="senha"

                                class="w-full px-4 py-3 pr-12 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                                placeholder="Sua senha">
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="w-4 h-4 text-primary bg-dark border-primary/30 rounded focus:ring-primary focus:ring-2">
                            <label for="remember" class="ml-2 text-sm text-gray-300">Lembrar de mim</label>
                        </div>
                        <a href="../esqueceu-senha/" class="text-primary hover:text-blue-400 text-sm transition-colors">
                            <i class="fas fa-question-circle mr-1"></i>Esqueceu a senha?
                        </a>
                    </div>

                    <button
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-primary hover:bg-primary-dark text-white px-8 py-4 rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary/50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        <span id="btn-text">Entrar</span>
                        <div id="loading-spinner" class="hidden inline-block ml-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        </div>
                    </button>
                </form>

                <!-- Additional Links -->
                <div class="mt-8 text-center space-y-4">
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-primary/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-dark-light text-gray-400">Ainda não tem conta?</span>
                        </div>
                    </div>

                    <a href="../cadastro/" class="inline-flex items-center text-primary hover:text-blue-400 transition-colors font-semibold">
                        <i class="fas fa-user-plus mr-2"></i>
                        Criar conta gratuita
                    </a>

                    <div class="pt-4">
                        <p class="text-gray-400 mb-2">Precisa confirmar o cadastro?</p>
                        <a href="../confirmar-cadastro/" class="text-primary hover:text-blue-400 transition-colors">
                            <i class="fas fa-envelope-open mr-2"></i>
                            Confirmar cadastro
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-lighter border-t border-primary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <img src="/app/public/img/logo-head.png" alt="Logo" class="h-8 w-auto">
                        <span class="text-xl font-bold text-primary">Minhas Vacinas</span>
                    </div>
                    <p class="text-gray-400">Protegendo você e sua família com informações e controle digital de vacinas.</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Serviços</h3>
                    <ul class="space-y-2">
                        <li><a href="/src/auth/cadastro/" class="text-gray-400 hover:text-primary transition-colors">Cadastro</a></li>
                        <li><a href="/src/ajuda/" class="text-gray-400 hover:text-primary transition-colors">Suporte</a></li>
                        <li><a href="/src/painel/" class="text-gray-400 hover:text-primary transition-colors">Histórico</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Links Úteis</h3>
                    <ul class="space-y-2">
                        <li><a href="/docs/privacidade.php" class="text-gray-400 hover:text-primary transition-colors">Política de Privacidade</a></li>
                        <li><a href="/docs/termos.php" class="text-gray-400 hover:text-primary transition-colors">Termos de Serviço</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Contato</h3>
                    <p class="text-gray-400">
                        <i class="fas fa-envelope mr-2 text-primary"></i>
                        contato@minhasvacinas.online
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-primary/20 bg-dark py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-400">
                    © 2025 Minhas Vacinas. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('senha');
            const icon = this.querySelector('i');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>