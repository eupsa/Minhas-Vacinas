<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
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
    <title>Minhas Vacinas - Suporte</title>
</head>

<body class="bg-dark text-white min-h-screen">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-dark/95 backdrop-blur-md border-b border-primary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="/assets/img/logo-head.png" alt="Logo Vacinas" class="h-10 w-auto">
                        <span class="text-xl font-bold text-primary">Minhas Vacinas</span>
                    </a>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Início</a>
                        <a href="/#nossa-missao" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Sobre</a>
                        <a href="#" class="text-primary px-3 py-2 rounded-md text-sm font-medium">Suporte</a>
                        <a href="../FAQ/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">FAQ</a>
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
                        <a href="../auth/cadastro/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white px-6 py-2 rounded-full transition-all duration-200">
                            <i class="fas fa-user-plus mr-2"></i>CADASTRE-SE
                        </a>
                        <a href="../auth/entrar/" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-full transition-all duration-200">
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
                <a href="#" class="text-primary block px-3 py-2 rounded-md text-base font-medium">Suporte</a>
                <a href="../FAQ/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">FAQ</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-36 pb-6 bg-gradient-to-br from-dark via-dark-light to-dark">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-xl text-white"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold mb-4 bg-gradient-to-r from-white via-primary to-white bg-clip-text text-transparent">
                    Central de Suporte
                </h1>
                <p class="text-base text-gray-300 mb-4 max-w-xl mx-auto">
                    Estamos aqui para ajudar! Entre em contato conosco e nossa equipe responderá o mais rápido possível.
                </p>
            </div>
        </div>
    </section>


    <!-- Support Form Section -->
    <section class="py-16 bg-gradient-to-b from-dark to-dark-light">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Contact Info -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-primary/20">
                        <h3 class="text-xl font-semibold mb-4 text-white">Formas de Contato</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">E-mail</p>
                                    <p class="text-white">contato@minhasvacinas.online</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Horário de Atendimento</p>
                                    <p class="text-white">24/7 - Sempre disponível</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-reply text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Tempo de Resposta</p>
                                    <p class="text-white">Até 24 horas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-primary/20 to-blue-400/20 rounded-2xl p-6 border border-primary/30">
                        <h3 class="text-xl font-semibold mb-4 text-white">Dicas Rápidas</h3>
                        <ul class="space-y-2 text-gray-300">
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-primary mt-1 text-sm"></i>
                                <span class="text-sm">Descreva seu problema detalhadamente</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-primary mt-1 text-sm"></i>
                                <span class="text-sm">Inclua capturas de tela se possível</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-primary mt-1 text-sm"></i>
                                <span class="text-sm">Verifique sua caixa de spam</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Support Form -->
                <div class="lg:col-span-2">
                    <div class="bg-dark-light/50 backdrop-blur-sm rounded-2xl p-8 border border-primary/20">
                        <h2 class="text-2xl font-bold mb-6 text-white">Envie sua Mensagem</h2>

                        <form id="form_suporte" action="backend/suporte.php" method="post" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="suporte_nome" class="block text-sm font-medium text-gray-300 mb-2">
                                        Nome Completo <span class="text-red-400">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="suporte_nome"
                                        name="suporte_nome"
                                        required
                                        class="w-full px-4 py-3 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                                        placeholder="Seu nome completo">
                                </div>
                                <div>
                                    <label for="suporte_email" class="block text-sm font-medium text-gray-300 mb-2">
                                        E-mail <span class="text-red-400">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="suporte_email"
                                        name="suporte_email"
                                        required
                                        class="w-full px-4 py-3 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                                        placeholder="seu@email.com">
                                </div>
                            </div>

                            <div>
                                <label for="motivo_contato" class="block text-sm font-medium text-gray-300 mb-2">
                                    Motivo do Contato <span class="text-red-400">*</span>
                                </label>
                                <select
                                    name="motivo_contato"
                                    id="motivo_contato"
                                    multiple
                                    class="w-full px-4 py-3 bg-dark border border-primary/30 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200">
                                    <option value="Problema Técnico">Problema técnico</option>
                                    <option value="Dúvida">Dúvida</option>
                                    <option value="Sugestão">Sugestão</option>
                                    <option value="Reclamação">Reclamação</option>
                                    <option value="Outro">Outro</option>
                                </select>
                                <p class="text-xs text-gray-400 mt-1">Segure Ctrl (ou Cmd) para selecionar múltiplas opções</p>
                            </div>

                            <div>
                                <label for="mensagem" class="block text-sm font-medium text-gray-300 mb-2">
                                    Mensagem <span class="text-red-400">*</span>
                                </label>
                                <textarea
                                    id="mensagem"
                                    name="mensagem"
                                    rows="6"
                                    required
                                    class="w-full px-4 py-3 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200 resize-none"
                                    placeholder="Descreva detalhadamente sua solicitação, dúvida ou problema..."></textarea>
                            </div>

                            <button
                                type="submit"
                                id="submit-btn"
                                class="w-full bg-primary hover:bg-primary-dark text-white px-8 py-4 rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary/50">
                                <i class="fas fa-paper-plane mr-2"></i>
                                <span id="btn-text">Enviar Mensagem</span>
                            </button>
                        </form>

                        <!-- Response Container -->
                        <div id="resposta-container" class="mt-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Quick Links -->
    <section class="py-16 bg-gradient-to-b from-dark-light to-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">Perguntas Frequentes</h2>
                <p class="text-gray-300">Talvez sua dúvida já tenha sido respondida</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-dark-light/50 rounded-xl p-6 border border-primary/20 hover:border-primary/50 transition-all duration-300 group cursor-pointer">
                    <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary/30 transition-colors">
                        <i class="fas fa-user-plus text-primary"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Como me cadastrar?</h3>
                    <p class="text-gray-400 text-sm">Processo simples e rápido de cadastro na plataforma</p>
                </div>

                <div class="bg-dark-light/50 rounded-xl p-6 border border-primary/20 hover:border-primary/50 transition-all duration-300 group cursor-pointer">
                    <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary/30 transition-colors">
                        <i class="fas fa-syringe text-primary"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Como adicionar vacinas?</h3>
                    <p class="text-gray-400 text-sm">Guia completo para gerenciar seu histórico de vacinas</p>
                </div>

                <div class="bg-dark-light/50 rounded-xl p-6 border border-primary/20 hover:border-primary/50 transition-all duration-300 group cursor-pointer">
                    <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary/30 transition-colors">
                        <i class="fas fa-shield-alt text-primary"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Segurança dos dados</h3>
                    <p class="text-gray-400 text-sm">Como protegemos suas informações pessoais e de saúde</p>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="../FAQ/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white px-8 py-3 rounded-full transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-question-circle mr-2"></i>Ver Todas as Perguntas
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-lighter border-t border-primary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <img src="/assets/img/logo-head.png" alt="Logo" class="h-8 w-auto">
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
                        <li><a href="../../docs/Politica-de-Privacidade.php" class="text-gray-400 hover:text-primary transition-colors">Política de Privacidade</a></li>
                        <li><a href="../../docs/Termos-de-Servico.php" class="text-gray-400 hover:text-primary transition-colors">Termos de Serviço</a></li>
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
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Form handling with error management
        document.getElementById('form_suporte').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const responseContainer = document.getElementById('resposta-container');

            // Show loading state
            submitBtn.disabled = true;
            btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enviando...';

            // Clear previous responses
            responseContainer.innerHTML = '';

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.text();

                if (response.ok) {
                    // Success
                    responseContainer.innerHTML = `
                        <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4 animate-fade-in">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-400 mr-3"></i>
                                <div>
                                    <h4 class="text-green-400 font-semibold">Mensagem enviada com sucesso!</h4>
                                    <p class="text-green-300 text-sm mt-1">Responderemos em até 24 horas.</p>
                                </div>
                            </div>
                        </div>
                    `;

                    // Reset form
                    this.reset();
                } else {
                    throw new Error('Erro no servidor');
                }

            } catch (error) {
                // Error handling
                responseContainer.innerHTML = `
                    <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 animate-fade-in">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                            <div>
                                <h4 class="text-red-400 font-semibold">Erro ao enviar mensagem</h4>
                                <p class="text-red-300 text-sm mt-1">Tente novamente ou entre em contato por e-mail.</p>
                            </div>
                        </div>
                    </div>
                `;
            } finally {
                // Reset button state
                submitBtn.disabled = false;
                btnText.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Enviar Mensagem';
            }
        });

        // Form validation
        const form = document.getElementById('form_suporte');
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');

        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('border-red-500')) {
                    validateField(this);
                }
            });
        });

        function validateField(field) {
            const isValid = field.checkValidity();

            if (isValid) {
                field.classList.remove('border-red-500', 'focus:border-red-500');
                field.classList.add('border-primary/30', 'focus:border-primary');
            } else {
                field.classList.remove('border-primary/30', 'focus:border-primary');
                field.classList.add('border-red-500', 'focus:border-red-500');
            }
        }

        // Auto-hide response messages
        function autoHideMessage() {
            const responseContainer = document.getElementById('resposta-container');
            if (responseContainer.children.length > 0) {
                setTimeout(() => {
                    const message = responseContainer.firstElementChild;
                    if (message) {
                        message.style.opacity = '0';
                        message.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            message.remove();
                        }, 300);
                    }
                }, 8000);
            }
        }

        // Observer for auto-hide
        const observer = new MutationObserver(autoHideMessage);
        observer.observe(document.getElementById('resposta-container'), {
            childList: true
        });
    </script>
</body>

</html>