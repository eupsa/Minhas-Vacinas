<?php
session_start();
require_once __DIR__ . '../../../../../libs/autoload.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../../dashboard/");
    exit();
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
$dotenv->load();

$client_id = $_ENV['GOOGLE_ID_CLIENT'];
$redirect_uri = urlencode($_ENV['GOOGLE_REDIRECT_REGISTER']);
$scope = urlencode('openid email profile');
$state = bin2hex(random_bytes(16)); // opcional: para segurança extra

$google_auth_url = "https://accounts.google.com/o/oauth2/v2/auth?" .
    "client_id=$client_id&" .
    "redirect_uri=$redirect_uri&" .
    "response_type=code&" .
    "scope=$scope&" .
    "state=$state&" .
    "access_type=offline&" .
    "prompt=select_account";

$msg = $_GET['msg'] ?? null;
$text = $_GET['text'] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Cadastro</title>

    <!-- Meta Tags -->
    <meta name="description" content="Cadastre-se no Minhas Vacinas e tenha controle total sobre suas vacinas e da sua família. Plataforma segura e gratuita.">
    <meta name="keywords" content="cadastro, registro, minhas vacinas, saúde digital, vacinas">
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

    <script src="https://accounts.google.com/gsi/client" async defer></script>

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

        /* Password Strength Indicators */
        .password-check.valid {
            color: #10b981 !important;
        }

        .password-check.invalid {
            color: #ef4444 !important;
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
                        <a href="index.html" class="text-gray-300 hover:text-primary transition-colors font-medium">Início</a>
                        <a href="/app/src/ajuda/" class="text-gray-300 hover:text-primary transition-colors font-medium">Suporte</a>
                        <a href="#" class="text-primary transition-colors font-medium">Cadastro</a>
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
                        <img src="/app/public/img/logo-head.png" alt="Logo">
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
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-light rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-white text-lg"></i>
                    </div>

                    <h1 class="text-2xl lg:text-3xl font-bold mb-4 leading-tight">
                        Bem-vindo ao <span class="text-gradient">Minhas Vacinas</span>
                    </h1>

                    <p class="text-base text-gray-300 mb-6 leading-relaxed">
                        Crie sua conta e tenha controle total sobre sua saúde
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Form Section -->
    <section class="py-12 bg-gradient-to-b from-dark to-dark-light">
        <div class="container mx-auto px-6">
            <div class="max-w-lg mx-auto">
                <div class="glass-card rounded-2xl p-6 md:p-8">

                    <!-- Google Sign In Placeholder -->
                    <div class="text-center mb-6">
                        <div class="text-center mb-6">
                            <a href="<?= $google_auth_url ?>"
                                class="w-full flex items-center justify-center space-x-3 bg-white hover:bg-gray-50 text-gray-900 px-4 py-2.5 rounded-lg font-medium transition-all duration-200 border border-gray-300">
                                <svg class="w-4 h-4" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                <span class="text-sm">Continuar com Google</span>
                            </a>
                        </div>

                    </div>


                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-primary/30"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-3 bg-dark-card text-gray-400 text-xs">ou use seu e-mail</span>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <form id="formcad" class="space-y-4" method="post" action="../backend/cadastro.php">
                        <div>
                            <label for="nome" class="block text-xs font-medium text-gray-300 mb-1">
                                Nome Completo <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="text"
                                id="nome"
                                name="nome"
                                autocomplete="off"
                                class="w-full px-3 py-2.5 bg-dark border border-primary/30 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-200">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-medium text-gray-300 mb-1">
                                E-mail <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                autocomplete="off"
                                class="w-full px-3 py-2.5 bg-dark border border-primary/30 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-200">
                        </div>

                        <div>
                            <label for="senha" class="block text-xs font-medium text-gray-300 mb-1">
                                Senha <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="senha"
                                    name="senha"
                                    autocomplete="off"
                                    class="w-full px-3 py-2.5 pr-10 bg-dark border border-primary/30 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-200">
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                            <div class="mt-1 space-y-1">
                                <div class="flex items-center text-xs">
                                    <i class="fas fa-circle text-gray-600 mr-1 password-check text-xs" id="length-check"></i>
                                    <span class="text-gray-400 password-check text-xs" id="length-text">Mínimo 8 caracteres</span>
                                </div>
                                <div class="flex items-center text-xs">
                                    <i class="fas fa-circle text-gray-600 mr-1 password-check text-xs" id="special-check"></i>
                                    <span class="text-gray-400 password-check text-xs" id="special-text">1 caractere especial</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="confSenha" class="block text-xs font-medium text-gray-300 mb-1">
                                Confirmar Senha <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="confSenha"
                                    name="confSenha"
                                    autocomplete="off"
                                    class="w-full px-3 py-2.5 pr-10 bg-dark border border-primary/30 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-200">
                                <button
                                    type="button"
                                    id="ConftogglePassword"
                                    autocomplete="off"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                            <div class="mt-1">
                                <div class="flex items-center text-xs">
                                    <i class="fas fa-circle text-gray-600 mr-1 password-check text-xs" id="match-check"></i>
                                    <span class="text-gray-400 password-check text-xs" id="match-text">Senhas devem coincidir</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="estado" class="block text-xs font-medium text-gray-300 mb-1">
                                Estado <span class="text-red-400">*</span>
                            </label>
                            <select
                                id="estado"
                                name="estado"
                                class="w-full px-3 py-2.5 bg-dark border border-primary/30 rounded-lg text-white text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-200">
                                <option value="" disabled selected>Selecione seu estado</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                            </select>
                        </div>

                        <div class="flex items-start space-x-2 pt-2">
                            <input
                                type="checkbox"
                                id="termsCheckbox"
                                required
                                class="mt-0.5 w-3 h-3 text-primary bg-dark border-primary/30 rounded focus:ring-primary focus:ring-1">
                            <label for="termsCheckbox" class="text-xs text-gray-300 leading-relaxed">
                                Aceito os
                                <a href="/docs/termos.php" target="_blank" class="text-primary hover:text-primary-light underline">Termos</a>
                                e
                                <a href="/docs/privacidade.php" target="_blank" class="text-primary hover:text-primary-light underline">Política de Privacidade</a>
                            </label>
                        </div>

                        <button
                            type="submit"
                            id="submit-btn"
                            class="w-full btn-primary px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary/50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span id="btn-text">Criar Conta</span>
                        </button>
                    </form>

                    <!-- Login Link -->
                    <div class="mt-6 text-center">
                        <div class="relative my-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-primary/20"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-3 bg-dark-card text-gray-400 text-xs">Já tem conta?</span>
                            </div>
                        </div>
                        <a href="../entrar/" class="text-primary hover:text-primary-light font-medium transition-colors text-sm">
                            <i class="fas fa-sign-in-alt mr-1"></i>Fazer Login
                        </a>
                    </div>

                    <!-- Confirm Registration Link -->
                    <div class="mt-3 text-center">
                        <a href="../confirmar-cadastro/" class="text-gray-400 hover:text-primary text-xs transition-colors">
                            <i class="fas fa-envelope-open mr-1"></i>Confirmar cadastro existente
                        </a>
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
                        <li><a href="/app/src/ajuda/" class="text-gray-400 hover:text-primary transition-colors">Suporte</a></li>
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

        // Password visibility toggles
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

        document.getElementById('ConftogglePassword').addEventListener('click', function() {
            const password = document.getElementById('confSenha');
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

        // Password validation
        const senhaInput = document.getElementById('senha');
        const confSenhaInput = document.getElementById('confSenha');
        const lengthCheck = document.getElementById('length-check');
        const lengthText = document.getElementById('length-text');
        const specialCheck = document.getElementById('special-check');
        const specialText = document.getElementById('special-text');
        const matchCheck = document.getElementById('match-check');
        const matchText = document.getElementById('match-text');

        function validatePassword() {
            const password = senhaInput.value;
            const confirmPassword = confSenhaInput.value;

            // Length validation
            if (password.length >= 8) {
                lengthCheck.classList.add('valid');
                lengthText.classList.add('valid');
            } else {
                lengthCheck.classList.remove('valid');
                lengthText.classList.remove('valid');
            }

            // Special character validation
            const specialRegex = /[!@#$%^&*(),.?":{}|<>]/;
            if (specialRegex.test(password)) {
                specialCheck.classList.add('valid');
                specialText.classList.add('valid');
            } else {
                specialCheck.classList.remove('valid');
                specialText.classList.remove('valid');
            }

            // Password match validation
            if (password && confirmPassword && password === confirmPassword) {
                matchCheck.classList.remove('invalid');
                matchCheck.classList.add('valid');
                matchText.classList.remove('invalid');
                matchText.classList.add('valid');
                matchText.textContent = 'Senhas coincidem';
            } else if (confirmPassword) {
                matchCheck.classList.remove('valid');
                matchCheck.classList.add('invalid');
                matchText.classList.remove('valid');
                matchText.classList.add('invalid');
                matchText.textContent = 'Senhas não coincidem';
            } else {
                matchCheck.classList.remove('valid', 'invalid');
                matchText.classList.remove('valid', 'invalid');
                matchText.textContent = 'Senhas devem coincidir';
            }
        }

        senhaInput.addEventListener('input', validatePassword);
        confSenhaInput.addEventListener('input', validatePassword);

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !offCanvasMenu.classList.contains('translate-x-full')) {
                closeMenu();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const msg = <?= json_encode($msg) ?>;
            const text = <?= json_encode($text) ?>;

            // Se a msg e o text estiverem presentes na URL
            if (msg && text) {
                Swal.fire({
                    icon: msg === 'sucesso' ? 'success' : 'error',
                    title: msg === 'sucesso' ? 'Sucesso!' : 'Erro!',
                    text: text,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Limpa os parâmetros da URL após mostrar o alerta
                    if (window.history.replaceState) {
                        const url = new URL(window.location);
                        url.searchParams.delete('msg');
                        url.searchParams.delete('text');
                        window.history.replaceState({}, document.title, url.toString());
                    }
                });
            }
        });
    </script>
    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>