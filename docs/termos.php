<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/app/public/img/img-web.png" type="image/x-icon">
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
                        'float': 'float 3s ease-in-out infinite',
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
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
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

    <!-- SEO Meta Tags -->
    <meta name="description" content="Termos de Serviço - Minhas Vacinas. Conheça os termos e condições de uso da nossa plataforma de gestão de vacinas.">
    <meta name="author" content="Minhas Vacinas Inc">
    <meta name="keywords" content="termos de serviço, condições de uso, termos legais">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#007bff">

    <title>Termos de Serviço - Minhas Vacinas</title>
</head>

<body class="bg-dark text-white overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-dark/95 backdrop-blur-md border-b border-primary/20 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="/app/public/img/logo-head.png" alt="Logo Vacinas" class="h-10 w-auto">
                        <span class="text-xl font-bold text-primary">Minhas Vacinas</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Início</a>
                        <a href="/#nossa-missao" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Sobre</a>
                        <a href="/app/src/ajuda/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Suporte</a>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-full transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-user"></i>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-dark-light rounded-lg shadow-xl border border-primary/20 py-2">
                                <a href="/app/src/dashboard/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-home mr-2"></i>Painel
                                </a>
                                <a href="/app/src/dashboard/vacinas/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-syringe mr-2"></i>Vacinas
                                </a>
                                <a href="/app/src/dashboard/perfil/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-user-circle mr-2"></i>Perfil
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/app/src/auth/cadastro/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white px-6 py-2 rounded-full transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-user-plus mr-2"></i>CADASTRE-SE
                        </a>
                        <a href="/app/src/auth/entrar/" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-full transition-all duration-200 transform hover:scale-105 animate-glow">
                            <i class="fas fa-sign-in-alt mr-2"></i>ENTRAR
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
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
                <a href="/app/src/ajuda/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Suporte</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-24 pb-16 overflow-hidden">
        <!-- Background with gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-dark via-dark-light to-dark-lighter"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-primary/10 via-transparent to-primary/10"></div>

        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-primary/20 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-contract text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-white via-primary to-white bg-clip-text text-transparent">
                    Termos de Serviço
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Condições de Uso da Plataforma
                </p>
                <p class="text-lg text-gray-400 mb-8 max-w-2xl mx-auto">
                    Última atualização: <?php echo date('d/m/Y'); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-gradient-to-b from-dark to-dark-light">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Introduction -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8 animate-slide-up">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-400 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-handshake text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Aceitação dos Termos</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            Bem-vindo ao <strong class="text-primary">Minhas Vacinas</strong>. Ao acessar e usar nossa plataforma, você concorda em cumprir e estar vinculado aos seguintes termos e condições de uso.
                        </p>
                        <p class="text-gray-300 leading-relaxed">
                            Se você não concordar com qualquer parte destes termos, não deve usar nossos serviços. Recomendamos que leia atentamente este documento antes de utilizar a plataforma.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service Description -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-syringe text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Descrição do Serviço</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            O Minhas Vacinas é uma plataforma digital que oferece:
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-dark/50 rounded-lg p-4 border border-primary/10">
                                <h3 class="text-lg font-semibold text-primary mb-2">Funcionalidades Principais</h3>
                                <ul class="text-gray-300 space-y-1 text-sm">
                                    <li>• Gestão de histórico de vacinação</li>
                                    <li>• Lembretes automáticos</li>
                                    <li>• Relatórios personalizados</li>
                                    <li>• Cartão digital de vacinação</li>
                                </ul>
                            </div>
                            
                            <div class="bg-dark/50 rounded-lg p-4 border border-primary/10">
                                <h3 class="text-lg font-semibold text-primary mb-2">Recursos Adicionais</h3>
                                <ul class="text-gray-300 space-y-1 text-sm">
                                    <li>• Informações sobre campanhas</li>
                                    <li>• Suporte técnico</li>
                                    <li>• Sincronização entre dispositivos</li>
                                    <li>• Backup seguro na nuvem</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Responsibilities -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-check text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Responsabilidades do Usuário</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            Ao usar nossa plataforma, você se compromete a:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-400 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-white">Informações Precisas</h3>
                                    <p class="text-gray-400 text-sm">Fornecer dados verdadeiros e atualizados sobre seu histórico de vacinação</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-400 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-white">Uso Adequado</h3>
                                    <p class="text-gray-400 text-sm">Utilizar a plataforma apenas para fins legítimos e de acordo com estes termos</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-400 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-white">Segurança da Conta</h3>
                                    <p class="text-gray-400 text-sm">Manter suas credenciais de acesso seguras e não compartilhá-las</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-400 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-white">Respeito às Leis</h3>
                                    <p class="text-gray-400 text-sm">Cumprir todas as leis e regulamentações aplicáveis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prohibited Uses -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-red-500/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-ban text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Usos Proibidos</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            É expressamente proibido:
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-times-circle text-red-400 mt-1"></i>
                                    <span class="text-gray-300 text-sm">Usar a plataforma para fins ilegais</span>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-times-circle text-red-400 mt-1"></i>
                                    <span class="text-gray-300 text-sm">Compartilhar informações falsas</span>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-times-circle text-red-400 mt-1"></i>
                                    <span class="text-gray-300 text-sm">Tentar acessar contas de terceiros</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-times-circle text-red-400 mt-1"></i>
                                    <span class="text-gray-300 text-sm">Interferir no funcionamento da plataforma</span>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-times-circle text-red-400 mt-1"></i>
                                    <span class="text-gray-300 text-sm">Distribuir malware ou vírus</span>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-times-circle text-red-400 mt-1"></i>
                                    <span class="text-gray-300 text-sm">Violar direitos de propriedade intelectual</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Limitations -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Limitações e Isenções</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            Importante compreender as seguintes limitações:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-yellow-400 mb-2">
                                    <i class="fas fa-info-circle mr-2"></i>Informações Médicas
                                </h3>
                                <p class="text-gray-300 text-sm">
                                    Nossa plataforma não substitui consultas médicas. Sempre consulte profissionais de saúde para orientações específicas sobre vacinação.
                                </p>
                            </div>
                            
                            <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-blue-400 mb-2">
                                    <i class="fas fa-server mr-2"></i>Disponibilidade do Serviço
                                </h3>
                                <p class="text-gray-300 text-sm">
                                    Embora nos esforcemos para manter alta disponibilidade, não garantimos que o serviço estará sempre acessível sem interrupções.
                                </p>
                            </div>
                            
                            <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-green-400 mb-2">
                                    <i class="fas fa-shield-alt mr-2"></i>Responsabilidade por Dados
                                </h3>
                                <p class="text-gray-300 text-sm">
                                    Você é responsável pela precisão dos dados inseridos. Recomendamos manter backups independentes de informações importantes.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modifications -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-edit text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Modificações dos Termos</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            Reservamo-nos o direito de modificar estes termos a qualquer momento. As alterações entrarão em vigor imediatamente após a publicação na plataforma.
                        </p>
                        
                        <div class="bg-primary/10 border border-primary/20 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-primary mb-2">Como você será notificado:</h3>
                            <ul class="text-gray-300 space-y-1 text-sm">
                                <li>• Notificação por e-mail para mudanças significativas</li>
                                <li>• Aviso na plataforma sobre atualizações</li>
                                <li>• Data de última modificação sempre visível</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="bg-gradient-to-br from-primary/20 to-blue-400/20 rounded-2xl p-8 border border-primary/30 backdrop-blur-sm">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-blue-400 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-gavel text-2xl text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold mb-4 text-white">Dúvidas Legais?</h2>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Se você tiver dúvidas sobre estes termos ou precisar de esclarecimentos legais, entre em contato conosco.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="mailto:juridico@minhasvacinas.online" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-full font-semibold transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-envelope mr-2"></i>juridico@minhasvacinas.online
                        </a>
                        <a href="/app/src/ajuda/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white px-6 py-3 rounded-full font-semibold transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-headset mr-2"></i>Central de Ajuda
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
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <img src="/app/public/img/logo-head.png" alt="Logo" class="h-8 w-auto">
                        <span class="text-xl font-bold text-primary">Minhas Vacinas</span>
                    </div>
                    <p class="text-gray-400">Protegendo você e sua família com informações e controle digital de vacinas.</p>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Serviços</h3>
                    <ul class="space-y-2">
                        <li><a href="/app/src/auth/cadastro/" class="text-gray-400 hover:text-primary transition-colors">Cadastro</a></li>
                        <li><a href="/app/src/ajuda/" class="text-gray-400 hover:text-primary transition-colors">Suporte</a></li>
                        <li><a href="/app/src/dashboard/" class="text-gray-400 hover:text-primary transition-colors">Painel</a></li>
                    </ul>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Links Úteis</h3>
                    <ul class="space-y-2">
                        <li><a href="/docs/Politica-de-Privacidade.php" class="text-gray-400 hover:text-primary transition-colors">Política de Privacidade</a></li>
                        <li><a href="/docs/Termos-de-Servico.php" class="text-primary font-semibold">Termos de Serviço</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Contato</h3>
                    <div class="space-y-2">
                        <p class="text-gray-400">
                            <i class="fas fa-envelope mr-2 text-primary"></i>
                            contato@minhasvacinas.online
                        </p>
                    </div>
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

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-dark/98');
                navbar.classList.remove('bg-dark/95');
            } else {
                navbar.classList.add('bg-dark/95');
                navbar.classList.remove('bg-dark/98');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe all sections
        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>

</html>
