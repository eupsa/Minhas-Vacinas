<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../../painel/");
    exit();
}
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
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'bounce-slow': 'bounce 2s ease-in-out infinite',
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
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Minhas Vacinas - Confirmação de Cadastro</title>
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-full transition-all duration-200">
                                <i class="fas fa-user"></i>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-dark-light rounded-lg shadow-xl border border-primary/20 py-2">
                                <a href="../painel/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-home mr-2"></i>Painel
                                </a>
                                <a href="../painel/vacinas/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-syringe mr-2"></i>Vacinas
                                </a>
                                <a href="../painel/perfil/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-user-circle mr-2"></i>Perfil
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="../entrar/" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-full transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i>ENTRAR
                        </a>
                    <?php endif; ?>
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

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <div class="border-t border-primary/20 pt-4 mt-4">
                        <a href="../entrar/" class="bg-primary hover:bg-primary-dark text-white block text-center px-4 py-2 rounded-full transition-all duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>ENTRAR
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="pt-36 pb-12 bg-gradient-to-br from-dark via-dark-light to-dark relative overflow-hidden">
        <!-- Background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/10 rounded-full blur-2xl animate-bounce-slow"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-primary/10 rounded-full blur-2xl animate-bounce-slow" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse-slow">
                    <i class="fas fa-envelope-open-text text-xl text-white"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold mb-4 bg-gradient-to-r from-white via-primary to-white bg-clip-text text-transparent">
                    Confirme seu Cadastro
                </h1>
                <p class="text-base text-gray-300 mb-4 max-w-xl mx-auto">
                    Estamos quase lá! Verifique seu e-mail e digite o código de confirmação
                </p>
            </div>
        </div>
    </section>


    <!-- Confirmation Form Section -->
    <section class="py-16 bg-gradient-to-b from-dark to-dark-light">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-dark-light/50 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-primary/20 shadow-2xl">

                <!-- Instructions -->
                <div class="text-center mb-8">
                    <div class="bg-primary/10 rounded-2xl p-6 border border-primary/20 mb-6">
                        <i class="fas fa-info-circle text-primary text-2xl mb-3"></i>
                        <p class="text-gray-300 leading-relaxed">
                            Um código de <span class="text-primary font-semibold">6 dígitos</span> foi enviado para o seu e-mail.
                            Verifique sua caixa de entrada e digite o código abaixo para confirmar seu cadastro.
                        </p>
                    </div>
                </div>

                <!-- Confirmation Form -->
                <form action="../backend/confirmar-cadastro.php" method="post" id="form-conf-cad" class="space-y-8">
                    <!-- Code Input -->
                    <!-- Code Input -->
                    <!-- Code Input -->
                    <div class="space-y-4">
                        <label class="block text-center text-sm font-medium text-gray-300 mb-4">
                            Digite o código de confirmação
                        </label>
                        <div class="flex justify-center gap-2">
                            <input type="text" class="codigo-input w-9 h-16 text-center text-2xl font-bold bg-dark border border-primary/30 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                            <input type="text" class="codigo-input w-9 h-16 text-center text-2xl font-bold bg-dark border border-primary/30 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                            <input type="text" class="codigo-input w-9 h-16 text-center text-2xl font-bold bg-dark border border-primary/30 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                            <input type="text" class="codigo-input w-9 h-16 text-center text-2xl font-bold bg-dark border border-primary/30 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                            <input type="text" class="codigo-input w-9 h-16 text-center text-2xl font-bold bg-dark border border-primary/30 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                            <input type="text" class="codigo-input w-9 h-16 text-center text-2xl font-bold bg-dark border border-primary/30 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200" maxlength="1" inputmode="numeric" pattern="[0-9]*" required>
                        </div>
                        <input type="hidden" name="codigo" id="codigo-hidden">
                    </div>


                    <!-- Submit Button -->
                    <button
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-primary hover:bg-primary-dark text-white px-8 py-4 rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary/50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span id="btn-text">Confirmar Cadastro</span>
                        <div id="loading-spinner" class="hidden inline-block ml-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        </div>
                    </button>
                </form>

                <!-- Resend Code -->
                <div class="mt-8 text-center">
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-primary/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-dark-light text-gray-400">Não recebeu o código?</span>
                        </div>
                    </div>
                    <button
                        id="resend-btn"
                        class="text-primary hover:text-blue-400 font-medium transition-colors">
                        <i class="fas fa-redo mr-2"></i>Reenviar código
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Resend Email Modal -->
    <div id="resend-modal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-dark-light rounded-2xl p-8 max-w-md w-full border border-primary/20 shadow-2xl">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Reenviar Código</h3>
                    <p class="text-gray-400">Digite seu e-mail para receber um novo código</p>
                </div>

                <form id="form-reenviar-email" action="../backend/reenviar-email.php" method="post" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">E-mail</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="w-full px-4 py-3 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                            placeholder="seu@email.com">
                    </div>

                    <div class="flex space-x-4">
                        <button
                            type="button"
                            id="cancel-resend"
                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-medium transition-colors">
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            id="confirm-resend"
                            class="flex-1 bg-primary hover:bg-primary-dark text-white px-4 py-3 rounded-lg font-medium transition-colors">
                            <span id="resend-text">Reenviar</span>
                            <div id="resend-loading" class="hidden inline-block ml-2">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                            </div>
                        </button>
                    </div>
                </form>

                <div id="resend-response" class="mt-4"></div>
            </div>
        </div>
    </div>

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
                        <li><a href="../../painel/vacinas/" class="text-gray-400 hover:text-primary transition-colors">Histórico</a></li>
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

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Code input handling
        const codeInputs = document.querySelectorAll('.codigo-input');
        const hiddenCodeInput = document.getElementById('codigo-hidden');

        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');

                // Move to next input
                if (this.value.length === 1 && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }

                // Update hidden input
                updateHiddenCode();
            });

            input.addEventListener('keydown', function(e) {
                // Handle backspace
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                const numbers = paste.replace(/[^0-9]/g, '').slice(0, 6);

                numbers.split('').forEach((num, i) => {
                    if (codeInputs[i]) {
                        codeInputs[i].value = num;
                    }
                });

                updateHiddenCode();

                // Focus last filled input or next empty
                const lastIndex = Math.min(numbers.length - 1, codeInputs.length - 1);
                if (numbers.length < 6 && lastIndex < codeInputs.length - 1) {
                    codeInputs[lastIndex + 1].focus();
                } else {
                    codeInputs[lastIndex].focus();
                }
            });
        });

        function updateHiddenCode() {
            const code = Array.from(codeInputs).map(input => input.value).join('');
            hiddenCodeInput.value = code;
        }

        // Resend modal handling
        const resendBtn = document.getElementById('resend-btn');
        const resendModal = document.getElementById('resend-modal');
        const cancelResend = document.getElementById('cancel-resend');

        resendBtn.addEventListener('click', () => {
            resendModal.classList.remove('hidden');
        });

        cancelResend.addEventListener('click', () => {
            resendModal.classList.add('hidden');
        });

        codeInputs[0].focus();
    </script>
    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="reenviar-emai.js"></script>
    <script src="script.js"></script>
</body>

</html>