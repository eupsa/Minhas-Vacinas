<?php
session_start();
require_once 'app/src/utils/ConexaoDB.php';
require_once 'libs/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$token = $_ENV['IPINFO_TOKEN'];
$ip = $_SERVER['REMOTE_ADDR'];

$response = file_get_contents("https://ipinfo.io/{$ip}/json?token={$token}");

if ($response !== false) {
    $data = json_decode($response, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        $cidade = isset($data['city']) ? $data['city'] : null;
        $estado = isset($data['region']) ? $data['region'] : null;
        $pais = isset($data['country']) ? $data['country'] : null;
        $empresa = isset($data['org']) ? $data['org'] : null;

        $sql = $pdo->prepare("SELECT COUNT(*) FROM ip_logs WHERE ip = :ip");
        $sql->bindValue(':ip', $ip);
        $sql->execute();
        $ipExistente = $sql->fetchColumn();

        if ($ipExistente == 0) {
            try {
                $sql = $pdo->prepare("INSERT INTO ip_logs (ip, cidade, estado, pais, empresa) VALUES (:ip, :cidade, :estado, :pais, :empresa)");
                $sql->bindValue(':ip', $ip);
                $sql->bindValue(':cidade', $cidade);
                $sql->bindValue(':estado', $estado);
                $sql->bindValue(':pais', $pais);
                $sql->bindValue(':empresa', $empresa);
                $sql->execute();
            } catch (PDOException $e) {
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    try {
        $sql = $pdo->prepare("INSERT INTO novidades (email) VALUES (:email)");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            header("Location: /?status=sucesso#nossa-missao");
        }
        header("Location: /?status=sucesso#nossa-missao");
    } catch (PDOException $e) {
        header("Location: /?status=erro#nossa-missao");
    }
}
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
    <meta name="description" content="Minhas Vacinas - A plataforma para gestão e controle do histórico de vacinação. Organize suas vacinas, receba alertas e informações sobre imunizações.">
    <meta name="author" content="Minhas Vacinas Inc">
    <meta name="keywords" content="Minhas Vacinas Inc">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#007bff">
    <link rel="canonical" href="https://www.minhasvacinas.online/">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="https://www.minhasvacinas.online/">
    <meta property="og:title" content="Minhas Vacinas">
    <meta property="og:description" content="Minhas Vacinas - A plataforma para gestão e controle do histórico de vacinação.">
    <meta property="og:image" content="https://www.minhasvacinas.online/assets/img/banner-200x200.png">

    <title>Minhas Vacinas - Proteção Digital para Sua Família</title>
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
                        <a href="" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Início</a>
                        <a href="#nossa-missao" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Sobre</a>
                        <a href="app/src/ajuda/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Suporte</a>
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
                                <a href="app/src/dashboard/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-home mr-2"></i>Painel
                                </a>
                                <a href="app/src/dashboard/vacinas/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-syringe mr-2"></i>Vacinas
                                </a>
                                <a href="app/src/dashboard/perfil/" class="block px-4 py-2 text-sm text-white hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-user-circle mr-2"></i>Perfil
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="app/src/auth/cadastro/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white px-6 py-2 rounded-full transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-user-plus mr-2"></i>CADASTRE-SE
                        </a>
                        <a href="app/src/auth/entrar/" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-full transition-all duration-200 transform hover:scale-105 animate-glow">
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
                <a href="#nossa-missao" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Sobre</a>
                <a href="src/ajuda/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Suporte</a>
                <a href="src/FAQ/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">FAQ</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="border-t border-primary/20 pt-4 mt-4">
                        <a href="src/painel/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-home mr-2"></i>Painel
                        </a>
                        <a href="app/src/dashboard/vacinas/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-syringe mr-2"></i>Vacinas
                        </a>
                        <a href="app/src/dashboard/perfil/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-user-circle mr-2"></i>Perfil
                        </a>
                    </div>
                <?php else: ?>
                    <div class="border-t border-primary/20 pt-4 mt-4 space-y-2">
                        <a href="app/src/auth/cadastro/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white block text-center px-4 py-2 rounded-full transition-all duration-200">
                            <i class="fas fa-user-plus mr-2"></i>CADASTRE-SE
                        </a>
                        <a href="app/src/auth/entrar/" class="bg-primary hover:bg-primary-dark text-white block text-center px-4 py-2 rounded-full transition-all duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>ENTRAR
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
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
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-white via-primary to-white bg-clip-text text-transparent">
                    Minhas Vacinas
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Proteção e Saúde Digital para Toda a Família
                </p>
                <p class="text-lg text-gray-400 mb-12 max-w-2xl mx-auto">
                    Mantenha o controle de todas as vacinas da sua família de forma simples, segura e inteligente.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="app/src/auth/cadastro/" class="bg-primary hover:bg-primary-dark text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 animate-glow">
                        <i class="fas fa-rocket mr-2"></i>Começar Agora
                    </a>
                    <a href="#recursos" class="bg-transparent border-2 border-primary text-primary hover:bg-primary hover:text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-play mr-2"></i>Conhecer Recursos
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-primary text-2xl"></i>
        </div>
    </section>

    <!-- Features Cards Section -->
    <section id="recursos" class="py-20 bg-gradient-to-b from-dark to-dark-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-slide-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-primary to-blue-400 bg-clip-text text-transparent">
                    Recursos Inovadores
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Tecnologia de ponta para cuidar da saúde da sua família
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature Card 1 -->
                <div class="group bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-primary/20 hover:border-primary/50 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-blue-400 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-mobile-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-white group-hover:text-primary transition-colors">Gestão Eficiente</h3>
                    <p class="text-gray-400 group-hover:text-gray-300 transition-colors">Organize e acompanhe as vacinas da sua família de forma intuitiva e eficiente.</p>
                </div>

                <!-- Feature Card 2 -->
                <div class="group bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-primary/20 hover:border-primary/50 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bell text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-white group-hover:text-red-400 transition-colors">Lembretes Inteligentes</h3>
                    <p class="text-gray-400 group-hover:text-gray-300 transition-colors">Nunca perca uma vacina com notificações personalizadas no seu dispositivo.</p>
                </div>

                <!-- Feature Card 3 -->
                <div class="group bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-primary/20 hover:border-primary/50 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-white group-hover:text-green-400 transition-colors">Segurança Total</h3>
                    <p class="text-gray-400 group-hover:text-gray-300 transition-colors">Seus dados protegidos com criptografia de ponta e armazenamento seguro.</p>
                </div>

                <!-- Feature Card 4 -->
                <div class="group bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-primary/20 hover:border-primary/50 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-white group-hover:text-purple-400 transition-colors">Relatórios Detalhados</h3>
                    <p class="text-gray-400 group-hover:text-gray-300 transition-colors">Acompanhe o status com gráficos interativos e alertas de vencimento.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Advanced Features Section -->
    <section class="py-20 bg-gradient-to-b from-dark-light to-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white">
                    Recursos Avançados
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Tecnologia que garante proteção e praticidade
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Advanced Feature 1 -->
                <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 hover:border-primary/50 transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-lock text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Histórico Digital Seguro</h3>
                    <p class="text-gray-400 leading-relaxed">Acesse um registro digital criptografado de todas as vacinas da sua família, disponível 24/7.</p>
                </div>

                <!-- Advanced Feature 2 -->
                <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 hover:border-primary/50 transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bell-slash text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Alertas Automáticos</h3>
                    <p class="text-gray-400 leading-relaxed">Sistema inteligente de notificações que nunca deixa você perder uma vacina importante.</p>
                </div>

                <!-- Advanced Feature 3 -->
                <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 hover:border-primary/50 transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-medical text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Cartão Digital</h3>
                    <p class="text-gray-400 leading-relaxed">Tenha seu cartão de vacinação sempre no bolso, acessível offline quando necessário.</p>
                </div>

                <!-- Advanced Feature 4 -->
                <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 hover:border-primary/50 transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bullhorn text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Campanhas de Imunização</h3>
                    <p class="text-gray-400 leading-relaxed">Fique sempre informado sobre campanhas de vacinação e proteja sua família.</p>
                </div>

                <!-- Advanced Feature 5 -->
                <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 hover:border-primary/50 transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-cloud text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Armazenamento em Nuvem</h3>
                    <p class="text-gray-400 leading-relaxed">Dados seguros na nuvem com backup automático e sincronização entre dispositivos.</p>
                </div>

                <!-- Advanced Feature 6 -->
                <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-2xl p-8 border border-primary/20 hover:border-primary/50 transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-check text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Cadastro Simplificado</h3>
                    <p class="text-gray-400 leading-relaxed">Interface intuitiva que permite cadastro rápido e acesso a todos os recursos em minutos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section id="nossa-missao" class="py-20 bg-gradient-to-br from-primary/20 via-dark to-primary/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white">Nossa Missão</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-blue-400 mx-auto mb-8"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <p class="text-xl text-gray-300 leading-relaxed">
                        Nossa missão é promover a saúde e o bem-estar da comunidade através da conscientização sobre a importância da vacinação.
                    </p>
                    <p class="text-lg text-gray-400 leading-relaxed">
                        Buscamos garantir que todos tenham acesso a informações atualizadas e precisas, facilitando o gerenciamento do histórico de vacinas e incentivando a proteção de todos.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="bg-dark-light/50 rounded-xl p-6 border border-primary/20">
                            <h3 class="text-xl font-semibold mb-3 text-primary">Compromisso com a Educação</h3>
                            <p class="text-gray-400">Educamos sobre as vacinas e suas contribuições para a saúde pública, empoderando decisões informadas.</p>
                        </div>
                        <div class="bg-dark-light/50 rounded-xl p-6 border border-primary/20">
                            <h3 class="text-xl font-semibold mb-3 text-primary">Acesso a Informações</h3>
                            <p class="text-gray-400">Oferecemos uma plataforma acessível com dados confiáveis sobre vacinação e campanhas.</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-gradient-to-br from-primary/20 to-blue-400/20 rounded-2xl p-8 backdrop-blur-sm border border-primary/30">
                        <div class="text-center space-y-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-primary to-blue-400 rounded-full flex items-center justify-center mx-auto">
                                <i class="fas fa-heart text-3xl text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Protegendo Famílias</h3>
                            <p class="text-gray-300">Mais de 10.000 famílias já confiam em nossa plataforma para manter seus históricos de vacinação seguros e organizados.</p>
                            <div class="flex justify-center space-x-8 text-center">
                                <div>
                                    <div class="text-3xl font-bold text-primary">10K+</div>
                                    <div class="text-sm text-gray-400">Famílias</div>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-primary">50K+</div>
                                    <div class="text-sm text-gray-400">Vacinas</div>
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-primary">99.9%</div>
                                    <div class="text-sm text-gray-400">Uptime</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-20 bg-gradient-to-r from-dark via-dark-light to-dark">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-dark-light to-dark-lighter rounded-3xl p-12 border border-primary/20 shadow-2xl">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-white">Fique Por Dentro</h2>
                <p class="text-xl text-gray-300 mb-8">Receba novidades sobre campanhas de vacinação e atualizações da plataforma</p>

                <form action="" method="POST" class="max-w-md mx-auto" id="newsletter-form">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input
                            type="email"
                            name="email"
                            placeholder="Seu melhor e-mail"
                            required
                            class="flex-1 px-6 py-4 bg-dark border border-primary/30 rounded-full text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200">
                        <button
                            type="submit"
                            class="bg-primary hover:bg-primary-dark text-white px-8 py-4 rounded-full font-semibold transition-all duration-200 transform hover:scale-105 whitespace-nowrap">
                            <i class="fas fa-paper-plane mr-2"></i>Inscrever-se
                        </button>
                    </div>
                </form>

                <?php if (isset($_GET['status'])): ?>
                    <div id="status-message" class="mt-6 p-4 rounded-lg <?php echo $_GET['status'] === 'sucesso' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30'; ?>">
                        <i class="fas <?php echo $_GET['status'] === 'sucesso' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> mr-2"></i>
                        <?php echo $_GET['status'] === 'sucesso' ? 'Inscrição realizada com sucesso!' : 'Erro ao processar inscrição. Tente novamente.'; ?>
                    </div>
                <?php endif; ?>
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
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Serviços</h3>
                    <ul class="space-y-2">
                        <li><a href="/app/src/auth/cadastro/" class="text-gray-400 hover:text-primary transition-colors">Cadastro</a></li>
                        <li><a href="/src/ajuda/" class="text-gray-400 hover:text-primary transition-colors">Suporte</a></li>
                        <li><a href="/src/painel/" class="text-gray-400 hover:text-primary transition-colors">Histórico</a></li>
                    </ul>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Links Úteis</h3>
                    <ul class="space-y-2">
                        <li><a href="docs/privacidade.php" class="text-gray-400 hover:text-primary transition-colors">Política de Privacidade</a></li>
                        <li><a href="docs/termos.php" class="text-gray-400 hover:text-primary transition-colors">Termos de Serviço</a></li>
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

        // Newsletter form handling
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;

            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enviando...';
            button.disabled = true;

            // Reset after form submission
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        });

        // Auto-hide status message
        const statusMessage = document.getElementById('status-message');
        if (statusMessage) {
            setTimeout(() => {
                statusMessage.style.opacity = '0';
                statusMessage.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    statusMessage.remove();
                }, 300);
            }, 5000);
        }

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