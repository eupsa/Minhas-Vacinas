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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Minhas Vacinas</title>

  <!-- Meta Tags -->
  <meta
    name="description"
    content="Controle inteligente de vacinas para toda família. Nunca mais perca uma data importante com nossa plataforma digital." />
  <meta
    name="keywords"
    content="vacinas, saúde, família, controle, digital, imunização" />
  <meta name="theme-color" content="#007bff" />

  <!-- Favicon -->
  <link rel="icon" href="app/public/img/img-web.png" type="image/x-icon" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet" />

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet" />

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            inter: ["Inter", "sans-serif"],
          },
          colors: {
            primary: "#007bff",
            "primary-dark": "#0056b3",
            "primary-light": "#66b3ff",
            dark: "#0a0e1a",
            "dark-light": "#1a1f2e",
            "dark-card": "#252b3d",
          },
          animation: {
            "float-slow": "float 6s ease-in-out infinite",
            "float-fast": "float 4s ease-in-out infinite",
            "slide-in-left": "slideInLeft 0.8s ease-out",
            "slide-in-right": "slideInRight 0.8s ease-out",
            "scale-in": "scaleIn 0.6s ease-out",
            "glow-pulse": "glowPulse 2s ease-in-out infinite",
            "slide-in": "slideIn 0.3s ease-out",
            "slide-out": "slideOut 0.3s ease-in",
          },
          keyframes: {
            float: {
              "0%, 100%": {
                transform: "translateY(0px)"
              },
              "50%": {
                transform: "translateY(-20px)"
              },
            },
            slideInLeft: {
              "0%": {
                opacity: "0",
                transform: "translateX(-50px)"
              },
              "100%": {
                opacity: "1",
                transform: "translateX(0)"
              },
            },
            slideInRight: {
              "0%": {
                opacity: "0",
                transform: "translateX(50px)"
              },
              "100%": {
                opacity: "1",
                transform: "translateX(0)"
              },
            },
            scaleIn: {
              "0%": {
                opacity: "0",
                transform: "scale(0.8)"
              },
              "100%": {
                opacity: "1",
                transform: "scale(1)"
              },
            },
            glowPulse: {
              "0%, 100%": {
                boxShadow: "0 0 20px rgba(0, 123, 255, 0.4)"
              },
              "50%": {
                boxShadow: "0 0 40px rgba(0, 123, 255, 0.8)"
              },
            },
            slideIn: {
              "0%": {
                transform: "translateX(100%)"
              },
              "100%": {
                transform: "translateX(0)"
              },
            },
            slideOut: {
              "0%": {
                transform: "translateX(0)"
              },
              "100%": {
                transform: "translateX(100%)"
              },
            },
          },
        },
      },
    };
  </script>

  <style>
    body {
      font-family: "Inter", sans-serif;
    }

    .gradient-bg {
      background: linear-gradient(135deg,
          #0a0e1a 0%,
          #1a1f2e 50%,
          #252b3d 100%);
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
      background-image: radial-gradient(circle at 25% 25%,
          rgba(0, 123, 255, 0.1) 0%,
          transparent 50%),
        radial-gradient(circle at 75% 75%,
          rgba(0, 123, 255, 0.1) 0%,
          transparent 50%);
    }

    .feature-icon {
      background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
      box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
    }

    .stats-counter {
      font-variant-numeric: tabular-nums;
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

    .section-divider {
      background: linear-gradient(90deg,
          transparent 0%,
          #007bff 50%,
          transparent 100%);
      height: 1px;
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
            <div
              class="w-10 h-10 rounded-lg flex items-center justify-center">
              <img src="app/public/img/logo-head.png" alt="">
            </div>
            <div>
              <h1 class="text-xl font-bold text-white">Minhas Vacinas</h1>
              <p class="text-xs text-gray-400">Saúde Digital</p>
            </div>
          </div>

          <!-- Desktop Menu -->
          <div class="hidden md:flex items-center space-x-8">
            <a
              href="#inicio"
              class="text-gray-300 hover:text-primary transition-colors font-medium">Início</a>
            <a
              href="#solucao"
              class="text-gray-300 hover:text-primary transition-colors font-medium">Solução</a>
            <a
              href="#recursos"
              class="text-gray-300 hover:text-primary transition-colors font-medium">Recursos</a>
            <a
              href="#sobre"
              class="text-gray-300 hover:text-primary transition-colors font-medium">Sobre</a>
          </div>

          <!-- CTA Button -->
          <div class="hidden md:block">
            <a href="app/src/auth/cadastro/"
              class="btn-primary px-6 py-2 rounded-full text-white font-medium">
              Começar Grátis
            </a>
          </div>

          <!-- Mobile Menu Button CORRIGIDO -->
          <button
            class="md:hidden text-white relative z-50 p-2"
            id="mobile-menu-btn">
            <div
              class="w-6 h-6 flex flex-col justify-center items-center space-y-1">
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
  <div
    class="fixed inset-0 off-canvas-overlay z-40 opacity-0 invisible transition-all duration-300"
    id="off-canvas-overlay"></div>

  <!-- Off-Canvas Menu CORRIGIDO -->
  <div
    class="fixed top-0 right-0 h-full w-80 max-w-sm off-canvas-menu z-50 transform translate-x-full transition-transform duration-300 ease-in-out"
    id="off-canvas-menu">
    <div class="flex flex-col h-full">
      <!-- Header -->
      <div
        class="flex items-center justify-between p-6 border-b border-gray-600">
        <div class="flex items-center space-x-3">
          <div
            class="w-8 h-8 rounded-lg flex items-center justify-center">
            <img src="app/public/img/logo-head.png" alt="Logo">
          </div>
          <div>
            <h2 class="font-bold text-white">Menu</h2>
            <p class="text-xs text-gray-400">Navegação</p>
          </div>
        </div>
        <button
          class="text-gray-400 hover:text-white transition-colors p-2"
          id="close-menu-btn">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>

      <!-- Navigation Links -->
      <div class="flex-1 overflow-y-auto p-6">
        <div class="space-y-2">
          <a
            href="#inicio"
            class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
            <div
              class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
              <i class="fas fa-home text-primary group-hover:text-white"></i>
            </div>
            <div>
              <h3 class="font-semibold text-white">Início</h3>
              <p class="text-xs text-gray-400">Página principal</p>
            </div>
          </a>

          <a
            href="#solucao"
            class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
            <div
              class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
              <i
                class="fas fa-lightbulb text-primary group-hover:text-white"></i>
            </div>
            <div>
              <h3 class="font-semibold text-white">Solução</h3>
              <p class="text-xs text-gray-400">Nossa proposta</p>
            </div>
          </a>

          <a
            href="#recursos"
            class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
            <div
              class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
              <i
                class="fas fa-rocket text-primary group-hover:text-white"></i>
            </div>
            <div>
              <h3 class="font-semibold text-white">Recursos</h3>
              <p class="text-xs text-gray-400">Funcionalidades</p>
            </div>
          </a>

          <a
            href="#sobre"
            class="mobile-nav-link flex items-center space-x-4 p-4 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
            <div
              class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
              <i
                class="fas fa-info-circle text-primary group-hover:text-white"></i>
            </div>
            <div>
              <h3 class="font-semibold text-white">Sobre</h3>
              <p class="text-xs text-gray-400">Nossa história</p>
            </div>
          </a>
        </div>

        <!-- Divider -->
        <div
          class="my-8 h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent"></div>

        <!-- Quick Actions -->
        <div class="space-y-4">
          <h4
            class="text-sm font-semibold text-gray-400 uppercase tracking-wider">
            Ações Rápidas
          </h4>

          <div class="grid grid-cols-2 gap-4">
            <a href="app/src/ajuda/"
              class="flex flex-col items-center space-y-2 p-4 bg-dark-light/50 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
              <div
                class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center group-hover:bg-green-500 group-hover:scale-110 transition-all duration-300">
                <i
                  class="fas fa-phone text-green-400 group-hover:text-white text-sm"></i>
              </div>
              <span class="text-xs font-medium text-white">Suporte</span>
            </a href="app/src/ajuda/">

            <a href="app/src/ajuda/"
              class="flex flex-col items-center space-y-2 p-4 bg-dark-light/50 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
              <div
                class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center group-hover:bg-purple-500 group-hover:scale-110 transition-all duration-300">
                <i
                  class="fas fa-book text-purple-400 group-hover:text-white text-sm"></i>
              </div>
              <span class="text-xs font-medium text-white">Guias</span>
            </a href="app/src/ajuda/">

            <a href="app/src/ajuda/"
              class="flex flex-col items-center space-y-2 p-4 bg-dark-light/50 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
              <div
                class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center group-hover:bg-yellow-500 group-hover:scale-110 transition-all duration-300">
                <i
                  class="fas fa-question-circle text-yellow-400 group-hover:text-white text-sm"></i>
              </div>
              <span class="text-xs font-medium text-white">FAQ</span>
            </a href="app/src/ajuda/">

            <a href="app/src/ajuda/"
              class="flex flex-col items-center space-y-2 p-4 bg-dark-light/50 rounded-xl hover:bg-primary/20 transition-all duration-300 group">
              <div
                class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center group-hover:bg-red-500 group-hover:scale-110 transition-all duration-300">
                <i
                  class="fas fa-envelope text-red-400 group-hover:text-white text-sm"></i>
              </div>
              <span class="text-xs font-medium text-white">Contato</span>
            </a href="app/src/ajuda/">
          </div>
        </div>
      </div>

      <!-- Footer Actions -->
      <div class="p-6 border-t border-gray-600 space-y-4">
        <a href="app/src/auth/entrar/"
          class="w-full flex items-center justify-center space-x-2 px-6 py-3 bg-dark-light hover:bg-dark-card rounded-xl text-gray-300 hover:text-white transition-all duration-300 border border-gray-600 hover:border-primary/50">
          <i class="fas fa-sign-in-alt text-primary"></i>
          <span class="font-medium">Fazer Login</span>
        </a>

        <a href="app/src/auth/cadastro/"
          class="w-full btn-primary px-6 py-3 rounded-xl text-white font-semibold flex items-center justify-center space-x-2">
          <i class="fas fa-rocket"></i>
          <span>Começar Grátis</span>
        </a>

        <!-- Social Links -->
        <div class="flex justify-center space-x-4 pt-4">
          <a
            href="#"
            class="w-10 h-10 bg-dark-light rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
            <i class="fab fa-facebook-f text-gray-400 hover:text-white"></i>
          </a>
          <a
            href="#"
            class="w-10 h-10 bg-dark-light rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
            <i class="fab fa-twitter text-gray-400 hover:text-white"></i>
          </a>
          <a
            href="#"
            class="w-10 h-10 bg-dark-light rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
            <i class="fab fa-instagram text-gray-400 hover:text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Hero Section -->
  <section
    id="inicio"
    class="min-h-[80vh] flex items-center gradient-bg hero-pattern relative overflow-hidden">
    <!-- Floating Elements -->
    <div
      class="absolute top-20 left-10 w-16 h-16 bg-primary/20 rounded-full blur-xl animate-float-slow"></div>
    <div
      class="absolute top-40 right-20 w-24 h-24 bg-primary/10 rounded-full blur-2xl animate-float-fast"></div>
    <div
      class="absolute bottom-20 left-1/4 w-12 h-12 bg-primary/30 rounded-full blur-lg animate-float-slow"></div>

    <div class="container mx-auto px-6 pt-16" style="margin-top: 6%;">
      <div class="grid lg:grid-cols-2 gap-8 items-center">
        <!-- Left Content -->
        <div class="animate-slide-in-left">
          <div
            class="inline-flex items-center px-4 py-2 bg-primary/20 rounded-full mb-6">
            <i class="fas fa-sparkles text-primary mr-2"></i>
            <span class="text-sm text-primary font-medium">Nova Era da Saúde Digital</span>
          </div>

          <h1 class="text-4xl lg:text-5xl font-bold mb-6 leading-tight">
            Sua <span class="text-gradient">Saúde</span><br />
            Sempre em<br />
            <span class="text-gradient">Primeiro Lugar</span>
          </h1>

          <p class="text-lg text-gray-300 mb-8 leading-relaxed">
            Transforme o cuidado com a saúde da sua família. Nossa plataforma
            inteligente garante que nenhuma vacina seja esquecida, mantendo
            todos protegidos.
          </p>

          <div class="flex flex-col sm:flex-row gap-4 mb-10">
            <a
              href="app/src/auth/cadastro/" class="btn-primary px-6 py-3 rounded-full text-white font-semibold">
              <i class="fas fa-rocket mr-2"></i>
              Começar Agora
            </a>
          </div>

          <!-- Stats -->
          <div class="grid grid-cols-3 gap-4">
            <div class="text-center">
              <div
                class="text-2xl font-bold text-primary stats-counter"
                data-target="15000">
                0
              </div>
              <div class="text-xs text-gray-400">Famílias Protegidas</div>
            </div>
            <div class="text-center">
              <div
                class="text-2xl font-bold text-primary stats-counter"
                data-target="98">
                0
              </div>
              <div class="text-xs text-gray-400">% de Satisfação</div>
            </div>
            <div class="text-center">
              <div
                class="text-2xl font-bold text-primary stats-counter"
                data-target="24">
                0
              </div>
              <div class="text-xs text-gray-400">Horas de Suporte</div>
            </div>
          </div>
        </div>

        <!-- Right Content - Visual -->
        <div class="animate-slide-in-right">
          <div class="relative">
            <!-- Main Card -->
            <div class="glass-card rounded-2xl p-6 animate-glow-pulse">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Cartão de Vacinas</h3>
                <div
                  class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
              </div>

              <!-- Vaccine Cards -->
              <div class="space-y-3">
                <div
                  class="flex items-center justify-between p-3 bg-dark-light/50 rounded-lg">
                  <div class="flex items-center space-x-3">
                    <div
                      class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                      <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <div>
                      <p class="font-medium text-sm">COVID-19</p>
                      <p class="text-xs text-gray-400">Atualizada</p>
                    </div>
                  </div>
                  <span class="text-green-400 text-xs font-medium">Em dia</span>
                </div>

                <div
                  class="flex items-center justify-between p-3 bg-dark-light/50 rounded-lg">
                  <div class="flex items-center space-x-3">
                    <div
                      class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                      <i class="fas fa-clock text-white text-sm"></i>
                    </div>
                    <div>
                      <p class="font-medium text-sm">Gripe Anual</p>
                      <p class="text-xs text-gray-400">Próxima dose</p>
                    </div>
                  </div>
                  <span class="text-yellow-400 text-xs font-medium">15 dias</span>
                </div>

                <div
                  class="flex items-center justify-between p-3 bg-dark-light/50 rounded-lg">
                  <div class="flex items-center space-x-3">
                    <div
                      class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                      <i class="fas fa-calendar text-white text-sm"></i>
                    </div>
                    <div>
                      <p class="font-medium text-sm">Hepatite B</p>
                      <p class="text-xs text-gray-400">Agendada</p>
                    </div>
                  </div>
                  <span class="text-primary text-xs font-medium">Amanhã</span>
                </div>
              </div>
            </div>

            <!-- Floating Notification -->
            <div
              class="absolute -top-3 -right-3 glass-card rounded-xl p-3 animate-float-fast">
              <div class="flex items-center space-x-2">
                <i class="fas fa-bell text-primary text-sm"></i>
                <span class="text-xs font-medium">Lembrete ativo</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Seção Solução -->
  <section
    id="solucao"
    class="py-12 bg-gradient-to-b from-dark to-dark-light">
    <div class="container mx-auto px-6">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-white mb-4">Nossa Solução</h2>
        <p class="text-lg text-gray-300 max-w-2xl mx-auto">
          Tecnologia avançada para cuidar da saúde da sua família
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <div
          class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300">
          <div
            class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-brain text-primary text-2xl"></i>
          </div>
          <h3 class="text-xl font-semibold text-white mb-3">
            IA Inteligente
          </h3>
          <p class="text-gray-400">
            Sistema inteligente que aprende e sugere o melhor cronograma de
            vacinas
          </p>
        </div>

        <div
          class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300">
          <div
            class="w-16 h-16 bg-green-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-shield-alt text-green-400 text-2xl"></i>
          </div>
          <h3 class="text-xl font-semibold text-white mb-3">
            Segurança Total
          </h3>
          <p class="text-gray-400">
            Seus dados protegidos com criptografia de nível bancário
          </p>
        </div>

        <div
          class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300">
          <div
            class="w-16 h-16 bg-yellow-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-bell text-yellow-400 text-2xl"></i>
          </div>
          <h3 class="text-xl font-semibold text-white mb-3">
            Lembretes Smart
          </h3>
          <p class="text-gray-400">
            Notificações personalizadas para nunca perder uma vacina
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Seção Recursos -->
  <section id="recursos" class="py-12 bg-gradient-to-b from-dark-light to-dark">
    <div class="container mx-auto px-6">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-white mb-4">
          Recursos Principais
        </h2>
        <p class="text-lg text-gray-300 max-w-2xl mx-auto">
          Tudo que você precisa para gerenciar a saúde da família
        </p>
      </div>

      <!-- Cards centralizados -->
      <div class="flex flex-wrap justify-center gap-6 max-w-6xl mx-auto">
        <!-- Card 1 -->
        <div class="glass-card rounded-xl p-6 hover:scale-105 transition-all duration-300 w-full sm:w-[300px]">
          <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-qrcode text-primary text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">QR Code</h3>
          <p class="text-gray-400 text-sm">
            Acesso rápido ao seu cartão digital
          </p>
        </div>

        <!-- Card 2 -->
        <div class="glass-card rounded-xl p-6 hover:scale-105 transition-all duration-300 w-full sm:w-[300px]">
          <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-users text-green-400 text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">Família</h3>
          <p class="text-gray-400 text-sm">
            Gerencie vacinas de toda família
          </p>
        </div>

        <!-- Card 3 -->
        <div class="glass-card rounded-xl p-6 hover:scale-105 transition-all duration-300 w-full sm:w-[300px]">
          <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-chart-line text-yellow-400 text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">Relatórios</h3>
          <p class="text-gray-400 text-sm">
            Acompanhe o histórico completo
          </p>
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
            <div
              class="w-10 h-10 rounded-lg flex items-center justify-center">
              <img src="app/public/img/logo-head.png" alt="">

            </div>
            <div>
              <h3 class="text-xl font-bold text-primary">Minhas Vacinas</h3>
              <p class="text-xs text-gray-400">Saúde Digital</p>
            </div>
          </div>
          <p class="text-gray-400">
            Protegendo você e sua família com informações e controle digital
            de vacinas.
          </p>
        </div>

        <div>
          <h3 class="text-lg font-semibold text-white mb-4">Serviços</h3>
          <ul class="space-y-2">
            <li>
              <a
                href="app/src/auth/cadastro/"
                class="text-gray-400 hover:text-primary transition-colors">Cadastro</a>
            </li>
            <li>
              <a
                href="app/src/ajuda/"
                class="text-gray-400 hover:text-primary transition-colors">Suporte</a>
            </li>
            <li>
              <a
                href="app/src/dashboard/vacinas/"
                class="text-gray-400 hover:text-primary transition-colors">Histórico</a>
            </li>
            <li>
              <a
                href="app/src/dashboard/"
                class="text-gray-400 hover:text-primary transition-colors">Lembretes</a>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-lg font-semibold text-white mb-4">Links Úteis</h3>
          <ul class="space-y-2">
            <li>
              <a
                href="docs/privacidade.php"
                class="text-gray-400 hover:text-primary transition-colors">Política de Privacidade</a>
            </li>
            <li>
              <a
                href="docs/termos.php"
                class="text-gray-400 hover:text-primary transition-colors">Termos de Serviço</a>
            </li>
            <li>
              <a
                href="/app/src/ajuda/"
                class="text-gray-400 hover:text-primary transition-colors">FAQ</a>
            </li>
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
    const mobileMenuBtn = document.getElementById("mobile-menu-btn");
    const offCanvasMenu = document.getElementById("off-canvas-menu");
    const offCanvasOverlay = document.getElementById("off-canvas-overlay");
    const closeMenuBtn = document.getElementById("close-menu-btn");
    const header = document.getElementById("header");
    const navbar = header.querySelector(".navbar");

    // Off-Canvas Menu Functions
    function openMenu() {
      offCanvasMenu.classList.remove("translate-x-full");
      offCanvasOverlay.classList.remove("opacity-0", "invisible");
      document.body.classList.add("overflow-hidden");
      mobileMenuBtn.classList.add("hamburger-active");
    }

    function closeMenu() {
      offCanvasMenu.classList.add("translate-x-full");
      offCanvasOverlay.classList.add("opacity-0", "invisible");
      document.body.classList.remove("overflow-hidden");
      mobileMenuBtn.classList.remove("hamburger-active");
    }

    // Event Listeners
    mobileMenuBtn.addEventListener("click", openMenu);
    closeMenuBtn.addEventListener("click", closeMenu);
    offCanvasOverlay.addEventListener("click", closeMenu);

    // Close menu when clicking on navigation links
    document.querySelectorAll(".mobile-nav-link").forEach((link) => {
      link.addEventListener("click", closeMenu);
    });

    // Header Scroll Effect CORRIGIDO
    let lastScrollY = window.scrollY;

    window.addEventListener("scroll", () => {
      const currentScrollY = window.scrollY;

      if (currentScrollY > 100) {
        navbar.classList.add("navbar-scrolled");
      } else {
        navbar.classList.remove("navbar-scrolled");
      }

      lastScrollY = currentScrollY;
    });

    // Smooth Scrolling
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
          const headerHeight = header.offsetHeight;
          const targetPosition = target.offsetTop - headerHeight;

          window.scrollTo({
            top: targetPosition,
            behavior: "smooth",
          });
        }
      });
    });

    // Stats Counter Animation
    let countersAnimated = false;

    const animateCounters = () => {
      if (countersAnimated) return;
      countersAnimated = true;

      const counters = document.querySelectorAll(".stats-counter");

      counters.forEach((counter) => {
        const target = parseInt(counter.getAttribute("data-target"));
        const increment = target / 100;
        let current = 0;

        const updateCounter = () => {
          if (current < target) {
            current += increment;
            counter.textContent = Math.floor(current);
            requestAnimationFrame(updateCounter);
          } else {
            counter.textContent = target;
          }
        };

        updateCounter();
      });
    };

    // Intersection Observer for Animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          if (entry.target.classList.contains("animate-slide-in-left")) {
            entry.target.style.opacity = "1";
            entry.target.style.transform = "translateX(0)";
          }
          if (entry.target.classList.contains("animate-slide-in-right")) {
            entry.target.style.opacity = "1";
            entry.target.style.transform = "translateX(0)";
          }
          if (entry.target.classList.contains("animate-scale-in")) {
            entry.target.style.opacity = "1";
            entry.target.style.transform = "scale(1)";
          }

          if (entry.target.querySelector(".stats-counter")) {
            animateCounters();
          }
        }
      });
    }, observerOptions);

    // Initialize Animations
    document
      .querySelectorAll(
        ".animate-slide-in-left, .animate-slide-in-right, .animate-scale-in"
      )
      .forEach((el) => {
        el.style.opacity = "0";
        if (el.classList.contains("animate-slide-in-left")) {
          el.style.transform = "translateX(-50px)";
        } else if (el.classList.contains("animate-slide-in-right")) {
          el.style.transform = "translateX(50px)";
        } else if (el.classList.contains("animate-scale-in")) {
          el.style.transform = "scale(0.8)";
        }
        el.style.transition = "all 0.8s ease-out";
        observer.observe(el);
      });

    const statsSection = document.querySelector("#inicio");
    if (statsSection) {
      observer.observe(statsSection);
    }

    // Parallax Effect
    window.addEventListener("scroll", () => {
      const scrolled = window.pageYOffset;
      const parallaxElements = document.querySelectorAll(
        ".animate-float-slow, .animate-float-fast"
      );

      parallaxElements.forEach((element, index) => {
        const speed = index % 2 === 0 ? 0.5 : 0.3;
        element.style.transform = `translateY(${scrolled * speed}px)`;
      });
    });

    // Keyboard Navigation
    document.addEventListener("keydown", function(e) {
      if (
        e.key === "Escape" &&
        !offCanvasMenu.classList.contains("translate-x-full")
      ) {
        closeMenu();
      }
    });

    // Prevent body scroll when menu is open
    function preventBodyScroll(prevent) {
      if (prevent) {
        document.body.style.overflow = "hidden";
      } else {
        document.body.style.overflow = "";
      }
    }
  </script>
</body>

</html>