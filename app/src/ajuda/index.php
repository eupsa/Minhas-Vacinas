<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Central de Suporte</title>

    <!-- Meta Tags -->
    <meta name="description" content="Central de suporte Minhas Vacinas. Entre em contato conosco para dúvidas, problemas técnicos ou sugestões. Atendimento 24/7.">
    <meta name="keywords" content="suporte, ajuda, contato, minhas vacinas, atendimento, dúvidas">
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

        .feature-icon {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
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

        /* Navbar Styles - CORRIGIDO */
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
    <!-- Header CORRIGIDO -->
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
                        <a href="#suporte" class="text-primary transition-colors font-medium">Suporte</a>
                        <a href="#contato" class="text-gray-300 hover:text-primary transition-colors font-medium">Contato</a>
                    </div>

                    <!-- CTA Button -->
                    <div class="hidden md:block">
                        <a href="/app/src/auth/cadastro/" class="btn-primary px-6 py-2 rounded-full text-white font-medium">
                            Começar Grátis
                        </a>
                    </div>

                    <!-- Mobile Menu Button CORRIGIDO -->
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

    <!-- Off-Canvas Menu CORRIGIDO -->
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

                    <a href="#suporte" class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-headset text-primary group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Suporte</h3>
                            <p class="text-xs text-gray-400">Central de ajuda</p>
                        </div>
                    </a>

                    <a href="#contato" class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-envelope text-primary group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Contato</h3>
                            <p class="text-xs text-gray-400">Fale conosco</p>
                        </div>
                    </a>
                </div>

                <!-- Divider -->
                <div class="my-8 h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent"></div>

                <!-- Quick Actions -->
                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Ações Rápidas</h4>

                    <div class="grid grid-cols-2 gap-4">
                        <button class="flex flex-col items-center space-y-2 p-4 bg-dark-light/50 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center group-hover:bg-green-500 group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-phone text-green-400 group-hover:text-white text-sm"></i>
                            </div>
                            <span class="text-xs font-medium text-white">Suporte</span>
                        </button>

                        <button class="flex flex-col items-center space-y-2 p-4 bg-dark-light/50 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center group-hover:bg-purple-500 group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-book text-purple-400 group-hover:text-white text-sm"></i>
                            </div>
                            <span class="text-xs font-medium text-white">Guias</span>
                        </button>

                        <button class="flex flex-col items-center space-y-2 p-4 bg-dark-light/50 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center group-hover:bg-yellow-500 group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-question-circle text-yellow-400 group-hover:text-white text-sm"></i>
                            </div>
                            <span class="text-xs font-medium text-white">FAQ</span>
                        </button>

                        <button class="flex flex-col items-center space-y-2 p-4 bg-dark-light/50 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center group-hover:bg-red-500 group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-envelope text-red-400 group-hover:text-white text-sm"></i>
                            </div>
                            <span class="text-xs font-medium text-white">Contato</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="p-6 border-t border-gray-600 space-y-4">
                <a href="/app/src/auth/entrar/" class="w-full flex items-center justify-center space-x-2 px-6 py-3 bg-dark-light hover:bg-dark-card rounded-xl text-gray-300 hover:text-white transition-all duration-300 border border-gray-600 hover:border-primary/50">
                    <i class="fas fa-sign-in-alt text-primary"></i>
                    <span class="font-medium">Fazer Login</span>
                </a>

                <a href="/app/src/auth/cadastro/" class="w-full btn-primary px-6 py-3 rounded-xl text-white font-semibold flex items-center justify-center space-x-2">
                    <i class="fas fa-rocket"></i>
                    <span>Começar Grátis</span>
                </a>

                <!-- Social Links -->
                <div class="flex justify-center space-x-4 pt-4">
                    <a href="#" class="w-10 h-10 bg-dark-light rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                        <i class="fab fa-facebook-f text-gray-400 hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-dark-light rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                        <i class="fab fa-twitter text-gray-400 hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-dark-light rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                        <i class="fab fa-instagram text-gray-400 hover:text-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section id="inicio" class="min-h-[70vh] flex items-center gradient-bg hero-pattern relative overflow-hidden">
        <div class="container mx-auto px-6 pt-16">
            <div class="max-w-3xl mx-auto text-center">
                <div class="animate-fade-in-up">
                    <div class="inline-flex items-center px-4 py-2 bg-primary/20 rounded-full mb-6">
                        <i class="fas fa-headset text-primary mr-2"></i>
                        <span class="text-primary font-medium">Central de Suporte 24/7</span>
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-bold mb-6 leading-tight">
                        <span class="text-gradient">Estamos Aqui</span><br>
                        Para <span class="text-white">Ajudar</span>
                    </h1>

                    <p class="text-lg text-gray-300 mb-8 leading-relaxed max-w-2xl mx-auto">
                        Nossa equipe está pronta para resolver suas dúvidas e fornecer o melhor suporte.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                        <button class="btn-primary px-6 py-3 rounded-full text-white font-semibold" onclick="document.getElementById('contato').scrollIntoView({behavior: 'smooth'})">
                            <i class="fas fa-envelope mr-2"></i>
                            Enviar Mensagem
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Support Section -->
    <section id="suporte" class="py-12 bg-gradient-to-b from-dark to-dark-light">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">Como Podemos Ajudar?</h2>
                <p class="text-lg text-gray-300 max-w-xl mx-auto">
                    Escolha a melhor forma de entrar em contato
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 max-w-4xl mx-auto">
                <div class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 group cursor-pointer">
                    <div class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
                        <i class="fas fa-envelope text-primary group-hover:text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">E-mail</h3>
                    <p class="text-gray-400 mb-4">Envie sua dúvida por e-mail</p>
                    <p class="text-primary font-medium">contato@minhasvacinas.online</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contato" class="py-12 bg-gradient-to-b from-dark-light to-dark">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Contact Info -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="glass-card rounded-2xl p-6 max-w-full overflow-hidden">
                            <h3 class="text-2xl font-semibold mb-6 text-white">Informações de Contato</h3>
                            <div class="space-y-4">
                                <!-- E-mail -->
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-envelope text-primary text-lg"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm text-gray-400">E-mail</p>
                                        <p class="text-white font-medium break-words text-sm leading-tight">
                                            contato@minhasvacinas.online
                                        </p>
                                    </div>
                                </div>

                                <!-- Horário de Atendimento -->
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-clock text-primary text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-400">Horário de Atendimento</p>
                                        <p class="text-white font-medium text-sm">24/7 - Sempre disponível</p>
                                    </div>
                                </div>

                                <!-- Tempo de Resposta -->
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-reply text-primary text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-400">Tempo de Resposta</p>
                                        <p class="text-white font-medium text-sm">Até 24 horas</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="glass-card rounded-2xl p-6 bg-gradient-to-br from-primary/10 to-primary/5">
                            <h3 class="text-xl font-semibold mb-4 text-white">Dicas para um Melhor Atendimento</h3>
                            <ul class="space-y-3 text-gray-300">
                                <li class="flex items-start space-x-3">
                                    <i class="fas fa-check text-primary mt-1 text-sm"></i>
                                    <span class="text-sm">Descreva seu problema detalhadamente</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <i class="fas fa-check text-primary mt-1 text-sm"></i>
                                    <span class="text-sm">Inclua capturas de tela se possível</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <i class="fas fa-check text-primary mt-1 text-sm"></i>
                                    <span class="text-sm">Informe o dispositivo que está usando</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <i class="fas fa-check text-primary mt-1 text-sm"></i>
                                    <span class="text-sm">Verifique sua caixa de spam</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="lg:col-span-2">
                        <div class="glass-card rounded-2xl p-6">
                            <h2 class="text-3xl font-bold mb-6 text-white">Envie sua Mensagem</h2>

                            <form id="form_suporte" class="space-y-6" method="post" action="backend/suporte.php">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="suporte_nome" class="block text-sm font-medium text-gray-300 mb-2">
                                            Nome Completo <span class="text-red-400">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            id="suporte_nome"
                                            name="suporte_nome"

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
                                        class="w-full px-4 py-3 bg-dark border border-primary/30 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200">
                                        <option value="">Selecione o motivo</option>
                                        <option value="Problema Técnico">Problema técnico</option>
                                        <option value="Dúvida">Dúvida sobre o sistema</option>
                                        <option value="Sugestão">Sugestão de melhoria</option>
                                        <option value="Reclamação">Reclamação</option>
                                        <option value="Elogio">Elogio</option>
                                        <option value="Outro">Outro</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="mensagem" class="block text-sm font-medium text-gray-300 mb-2">
                                        Mensagem <span class="text-red-400">*</span>
                                    </label>
                                    <textarea
                                        id="mensagem"
                                        name="mensagem"
                                        rows="6"
                                        class="w-full px-4 py-3 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200 resize-none"
                                        placeholder="Descreva detalhadamente sua solicitação, dúvida ou problema..."></textarea>
                                </div>

                                <button
                                    type="submit"
                                    id="submit-btn"
                                    class="w-full btn-primary px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary/50">
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
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-card border-t border-primary/20">
        <div class="container mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                            <img src="/app/public/img/logo-head.png" alt="">
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
                        <li><a href="/app/src/auth/cadastro/" class="text-gray-400 hover:text-primary transition-colors">Cadastro</a></li>
                        <li><a class="text-gray-400 hover:text-primary transition-colors">Suporte</a></li>
                        <li><a href="/app/src/dashboard/vacinas/" class="text-gray-400 hover:text-primary transition-colors">Histórico</a></li>
                        <li><a href="/app/src/dashboard/" class="text-gray-400 hover:text-primary transition-colors">Lembretes</a></li>
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

    <!-- JavaScript CORRIGIDO -->
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

        // Header Scroll Effect CORRIGIDO
        let lastScrollY = window.scrollY;

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            if (currentScrollY > 100) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }

            lastScrollY = currentScrollY;
        });

        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerHeight = header.offsetHeight;
                    const targetPosition = target.offsetTop - headerHeight;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Observer for auto-hide
        const observer = new MutationObserver(autoHideMessage);
        observer.observe(document.getElementById('resposta-container'), {
            childList: true
        });

        // Intersection Observer for Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const intersectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('animate-fade-in-up')) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                }
            });
        }, observerOptions);

        // Observe elements
        document.querySelectorAll('.animate-fade-in-up').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease-out';
            intersectionObserver.observe(el);
        });

        // Parallax Effect for Floating Elements
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.animate-float-slow, .animate-float-fast');

            parallaxElements.forEach((element, index) => {
                const speed = index % 2 === 0 ? 0.5 : 0.3;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !offCanvasMenu.classList.contains('translate-x-full')) {
                closeMenu();
            }
        });
    </script>
</body>

</html>