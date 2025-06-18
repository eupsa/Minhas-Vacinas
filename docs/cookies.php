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
    <meta name="description" content="Política de Cookies - Minhas Vacinas. Saiba como utilizamos cookies e tecnologias similares em nossa plataforma.">
    <meta name="author" content="Minhas Vacinas Inc">
    <meta name="keywords" content="política de cookies, cookies, rastreamento, tecnologias web">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#007bff">

    <title>Política de Cookies - Minhas Vacinas</title>
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
                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-cookie-bite text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-white via-primary to-white bg-clip-text text-transparent">
                    Política de Cookies
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Como Utilizamos Cookies e Tecnologias Similares
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
            
            <!-- What are Cookies -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8 animate-slide-up">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-400 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-question-circle text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">O que são Cookies?</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            Cookies são pequenos arquivos de texto que são armazenados no seu dispositivo quando você visita um site. Eles são amplamente utilizados para fazer os sites funcionarem de forma mais eficiente, bem como para fornecer informações aos proprietários do site.
                        </p>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            No <strong class="text-primary">Minhas Vacinas</strong>, utilizamos cookies para melhorar sua experiência, personalizar conteúdo e analisar como nosso site é usado.
                        </p>
                        
                        <div class="bg-primary/10 border border-primary/20 rounded-lg p-4 mt-4">
                            <h3 class="text-lg font-semibold text-primary mb-2">
                                <i class="fas fa-lightbulb mr-2"></i>Tecnologias Similares
                            </h3>
                            <p class="text-gray-300 text-sm">
                                Além de cookies, também utilizamos tecnologias similares como Local Storage, Session Storage e Web Beacons para aprimorar sua experiência.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Types of Cookies -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-layer-group text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Tipos de Cookies Utilizados</h2>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Utilizamos diferentes tipos de cookies em nossa plataforma:
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Essential Cookies -->
                            <div class="bg-dark/50 rounded-lg p-6 border border-green-500/20">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-cog text-white text-sm"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-green-400">Cookies Essenciais</h3>
                                </div>
                                <p class="text-gray-300 text-sm mb-3">
                                    Necessários para o funcionamento básico do site. Não podem ser desabilitados.
                                </p>
                                <ul class="text-gray-400 text-xs space-y-1">
                                    <li>• Autenticação de usuário</li>
                                    <li>• Segurança da sessão</li>
                                    <li>• Preferências de idioma</li>
                                    <li>• Carrinho de compras</li>
                                </ul>
                            </div>

                            <!-- Performance Cookies -->
                            <div class="bg-dark/50 rounded-lg p-6 border border-blue-500/20">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-chart-line text-white text-sm"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-blue-400">Cookies de Performance</h3>
                                </div>
                                <p class="text-gray-300 text-sm mb-3">
                                    Coletam informações sobre como você usa nosso site para melhorar o desempenho.
                                </p>
                                <ul class="text-gray-400 text-xs space-y-1">
                                    <li>• Análise de tráfego</li>
                                    <li>• Páginas mais visitadas</li>
                                    <li>• Tempo de carregamento</li>
                                    <li>• Erros de navegação</li>
                                </ul>
                            </div>

                            <!-- Functional Cookies -->
                            <div class="bg-dark/50 rounded-lg p-6 border border-purple-500/20">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-sliders-h text-white text-sm"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-purple-400">Cookies Funcionais</h3>
                                </div>
                                <p class="text-gray-300 text-sm mb-3">
                                    Permitem funcionalidades aprimoradas e personalização da experiência.
                                </p>
                                <ul class="text-gray-400 text-xs space-y-1">
                                    <li>• Lembrar preferências</li>
                                    <li>• Personalização de interface</li>
                                    <li>• Configurações salvas</li>
                                    <li>• Chat de suporte</li>
                                </ul>
                            </div>

                            <!-- Marketing Cookies -->
                            <div class="bg-dark/50 rounded-lg p-6 border border-orange-500/20">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-bullhorn text-white text-sm"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-orange-400">Cookies de Marketing</h3>
                                </div>
                                <p class="text-gray-300 text-sm mb-3">
                                    Utilizados para exibir anúncios relevantes e medir a eficácia das campanhas.
                                </p>
                                <ul class="text-gray-400 text-xs space-y-1">
                                    <li>• Publicidade direcionada</li>
                                    <li>• Rastreamento de conversões</li>
                                    <li>• Análise de campanhas</li>
                                    <li>• Remarketing</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cookie Purposes -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-target text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Finalidades dos Cookies</h2>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Utilizamos cookies para as seguintes finalidades específicas:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-shield text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Autenticação e Segurança</h3>
                                    <p class="text-gray-400 text-sm">
                                        Manter você logado com segurança, proteger contra ataques e verificar sua identidade.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-cogs text-green-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Funcionalidade do Site</h3>
                                    <p class="text-gray-400 text-sm">
                                        Lembrar suas preferências, configurações e escolhas para uma experiência personalizada.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-chart-bar text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Análise e Melhoria</h3>
                                    <p class="text-gray-400 text-sm">
                                        Entender como você usa nosso site para melhorar continuamente nossos serviços.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-bell text-purple-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Comunicação Personalizada</h3>
                                    <p class="text-gray-400 text-sm">
                                        Enviar notificações relevantes sobre vacinas e lembretes importantes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Third Party Cookies -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-external-link-alt text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Cookies de Terceiros</h2>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Alguns cookies são definidos por serviços de terceiros que utilizamos:
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-dark/50 rounded-lg p-4 border border-primary/10">
                                <h3 class="text-lg font-semibold text-primary mb-2">Google Analytics</h3>
                                <p class="text-gray-300 text-sm mb-2">
                                    Análise de tráfego e comportamento dos usuários
                                </p>
                                <a href="https://policies.google.com/privacy" target="_blank" class="text-blue-400 text-xs hover:underline">
                                    <i class="fas fa-external-link-alt mr-1"></i>Política do Google
                                </a>
                            </div>
                            
                            <div class="bg-dark/50 rounded-lg p-4 border border-primary/10">
                                <h3 class="text-lg font-semibold text-primary mb-2">Hotjar</h3>
                                <p class="text-gray-300 text-sm mb-2">
                                    Análise de experiência do usuário e mapas de calor
                                </p>
                                <a href="https://www.hotjar.com/legal/policies/privacy/" target="_blank" class="text-blue-400 text-xs hover:underline">
                                    <i class="fas fa-external-link-alt mr-1"></i>Política do Hotjar
                                </a>
                            </div>
                            
                            <div class="bg-dark/50 rounded-lg p-4 border border-primary/10">
                                <h3 class="text-lg font-semibold text-primary mb-2">Facebook Pixel</h3>
                                <p class="text-gray-300 text-sm mb-2">
                                    Rastreamento de conversões e publicidade
                                </p>
                                <a href="https://www.facebook.com/privacy/policy/" target="_blank" class="text-blue-400 text-xs hover:underline">
                                    <i class="fas fa-external-link-alt mr-1"></i>Política do Facebook
                                </a>
                            </div>
                            
                            <div class="bg-dark/50 rounded-lg p-4 border border-primary/10">
                                <h3 class="text-lg font-semibold text-primary mb-2">Intercom</h3>
                                <p class="text-gray-300 text-sm mb-2">
                                    Chat de suporte e comunicação com usuários
                                </p>
                                <a href="https://www.intercom.com/legal/privacy" target="_blank" class="text-blue-400 text-xs hover:underline">
                                    <i class="fas fa-external-link-alt mr-1"></i>Política do Intercom
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cookie Management -->
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sliders-h text-xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-white">Como Gerenciar Cookies</h2>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Você tem controle total sobre os cookies. Aqui estão suas opções:
                        </p>
                        
                        <div class="space-y-6">
                            <!-- Browser Settings -->
                            <div class="bg-primary/10 border border-primary/20 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-primary mb-4">
                                    <i class="fas fa-browser mr-2"></i>Configurações do Navegador
                                </h3>
                                <p class="text-gray-300 mb-4">
                                    Você pode configurar seu navegador para aceitar, rejeitar ou notificá-lo sobre cookies:
                                </p>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                            <i class="fab fa-chrome text-white"></i>
                                        </div>
                                        <p class="text-sm text-gray-300">Chrome</p>
                                        <a href="https://support.google.com/chrome/answer/95647" target="_blank" class="text-xs text-blue-400 hover:underline">Configurar</a>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                            <i class="fab fa-firefox-browser text-white"></i>
                                        </div>
                                        <p class="text-sm text-gray-300">Firefox</p>
                                        <a href="https://support.mozilla.org/kb/enhanced-tracking-protection-firefox-desktop" target="_blank" class="text-xs text-blue-400 hover:underline">Configurar</a>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                            <i class="fab fa-safari text-white"></i>
                                        </div>
                                        <p class="text-sm text-gray-300">Safari</p>
                                        <a href="https://support.apple.com/guide/safari/manage-cookies-and-website-data-sfri11471/mac" target="_blank" class="text-xs text-blue-400 hover:underline">Configurar</a>
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-700 rounded-lg flex items-center justify-center mx-auto mb-2">
                                            <i class="fab fa-edge text-white"></i>
                                        </div>
                                        <p class="text-sm text-gray-300">Edge</p>
                                        <a href="https://support.microsoft.com/help/4027947/microsoft-edge-delete-cookies" target="_blank" class="text-xs text-blue-400 hover:underline">Configurar</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Cookie Preferences -->
                            <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-green-400 mb-4">
                                    <i class="fas fa-cog mr-2"></i>Central de Preferências
                                </h3>
                                <p class="text-gray-300 mb-4">
                                    Gerencie suas preferências de cookies diretamente em nossa plataforma:
                                </p>
                                <button onclick="openCookiePreferences()" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-sliders-h mr-2"></i>Gerenciar Preferências
                                </button>
                            </div>

                            <!-- Opt-out Links -->
                            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-6">
                                <h3 class="text-xl font-semibold text-yellow-400 mb-4">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Links de Opt-out
                                </h3>
                                <p class="text-gray-300 mb-4">
                                    Desative cookies específicos de terceiros:
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" class="bg-red-500/20 text-red-400 px-4 py-2 rounded-full text-sm hover:bg-red-500/30 transition-colors">
                                        Google Analytics
                                    </a>
                                    <a href="https://www.facebook.com/help/568137493302217" target="_blank" class="bg-blue-500/20 text-blue-400 px-4 py-2 rounded-full text-sm hover:bg-blue-500/30 transition-colors">
                                        Facebook Pixel
                                    </a>
                                    <a href="http://optout.aboutads.info/" target="_blank" class="bg-purple-500/20 text-purple-400 px-4 py-2 rounded-full text-sm hover:bg-purple-500/30 transition-colors">
                                        Publicidade Online
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="bg-gradient-to-br from-primary/20 to-blue-400/20 rounded-2xl p-8 border border-primary/30 backdrop-blur-sm">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-blue-400 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-cookie-bite text-2xl text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold mb-4 text-white">Dúvidas sobre Cookies?</h2>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Se você tiver dúvidas sobre nossa política de cookies ou precisar de ajuda para gerenciar suas preferências, entre em contato conosco.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="mailto:cookies@minhasvacinas.online" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-full font-semibold transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-envelope mr-2"></i>cookies@minhasvacinas.online
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
                        <li><a href="/docs/Termos-de-Servico.php" class="text-gray-400 hover:text-primary transition-colors">Termos de Serviço</a></li>
                        <li><a href="/docs/Politica-de-Cookies.php" class="text-primary font-semibold">Política de Cookies</a></li>
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

    <!-- Cookie Banner (Example) -->
    <div id="cookie-banner" class="fixed bottom-0 left-0 right-0 bg-dark-light border-t border-primary/20 p-4 z-50 transform translate-y-full transition-transform duration-300">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <i class="fas fa-cookie-bite text-primary text-2xl"></i>
                <p class="text-gray-300 text-sm">
                    Utilizamos cookies para melhorar sua experiência. Ao continuar navegando, você concorda com nossa 
                    <a href="/docs/Politica-de-Cookies.php" class="text-primary hover:underline">Política de Cookies</a>.
                </p>
            </div>
            <div class="flex space-x-3">
                <button onclick="acceptCookies()" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200">
                    Aceitar
                </button>
                <button onclick="openCookiePreferences()" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200">
                    Configurar
                </button>
            </div>
        </div>
    </div>

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

        // Cookie Banner Management
        function showCookieBanner() {
            const banner = document.getElementById('cookie-banner');
            banner.classList.remove('translate-y-full');
        }

        function hideCookieBanner() {
            const banner = document.getElementById('cookie-banner');
            banner.classList.add('translate-y-full');
        }

        function acceptCookies() {
            localStorage.setItem('cookies-accepted', 'true');
            hideCookieBanner();
            // Enable all cookies here
            console.log('Cookies aceitos');
        }

        function openCookiePreferences() {
            // Open cookie preferences modal
            alert('Aqui você abriria um modal com as preferências de cookies');
        }

        // Check if cookies were already accepted
        document.addEventListener('DOMContentLoaded', function() {
            if (!localStorage.getItem('cookies-accepted')) {
                setTimeout(showCookieBanner, 2000);
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
