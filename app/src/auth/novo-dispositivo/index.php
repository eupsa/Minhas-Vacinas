<?php
require_once '../../utils/ConexaoDB.php';
$id_usuario = isset($_GET['id']) ? $_GET['id'] : '';
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$erro = '';

if (empty($id_usuario) || empty($ip)) {
    echo json_encode(['status' => false, 'msg' => "Variável IP ou ID não definida."]);
    exit();
}

$retorna = null;
try {
    $sql = $pdo->prepare("SELECT * FROM dispositivos WHERE ip = :ip AND id_usuario = :id_usuario");
    $sql->bindValue(':ip', $ip);
    $sql->bindValue(':id_usuario', $id_usuario);
    $sql->execute();

    if ($sql->rowCount() === 0) {
        $retorna = ['status' => false, 'msg' => "Nenhum dispositivo encontrado com o IP e ID fornecidos."];
    } else {
        $sql = $pdo->prepare("UPDATE dispositivos SET confirmado = 1 WHERE ip = :ip AND id_usuario = :id_usuario");
        $sql->bindValue(':ip', $ip);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $retorna = ['status' => true, 'msg' => "Dispositivo adicionado à sua conta."];
        } else {
            $retorna = ['status' => false, 'msg' => "Erro ao adicionar dispositivo."];
        }
    }
} catch (PDOException $e) {
    $retorna = ['status' => false, 'msg' => "Erro ao adicionar dispositivo: " . $e->getMessage()];
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
                        'bounce-slow': 'bounce 2s ease-in-out infinite',
                        'spin-slow': 'spin 2s linear infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Minhas Vacinas - Novo Dispositivo</title>
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
                        <a href="../../ajuda/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Suporte</a>
                        <a href="../../FAQ/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">FAQ</a>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="../entrar/" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-full transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>ENTRAR
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
                    <a href="../entrar/" class="bg-primary hover:bg-primary-dark text-white block text-center px-4 py-2 rounded-full transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>ENTRAR
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <?php if ($retorna): ?>
        <!-- Result Section -->
        <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-dark via-dark-light to-dark relative overflow-hidden">
            <!-- Background elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-bounce-slow"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-bounce-slow" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-dark-light/50 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-primary/20 shadow-2xl animate-fade-in">
                    <?php if ($retorna['status']): ?>
                        <!-- Success -->
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-check text-3xl text-white"></i>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold mb-6 text-white">
                            Dispositivo Confirmado!
                        </h1>
                        <p class="text-xl text-gray-300 mb-8">
                            <?= htmlspecialchars($retorna['msg']) ?>
                        </p>
                        <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4 mb-6">
                            <p class="text-green-400 text-sm">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Seu dispositivo foi adicionado com segurança à sua conta.
                            </p>
                        </div>
                    <?php else: ?>
                        <!-- Error -->
                        <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-exclamation-triangle text-3xl text-white"></i>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold mb-6 text-white">
                            Erro na Confirmação
                        </h1>
                        <p class="text-xl text-gray-300 mb-8">
                            <?= htmlspecialchars($retorna['msg']) ?>
                        </p>
                        <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 mb-6">
                            <p class="text-red-400 text-sm">
                                <i class="fas fa-info-circle mr-2"></i>
                                Entre em contato com o suporte se o problema persistir.
                            </p>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="../entrar/" class="bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Fazer Login
                        </a>
                        <a href="../../ajuda/" class="bg-transparent border border-primary text-primary hover:bg-primary hover:text-white px-8 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-headset mr-2"></i>
                            Suporte
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <script>
            // Auto redirect after success
            <?php if ($retorna['status']): ?>
                setTimeout(() => {
                    window.location.href = "../entrar/";
                }, 5000);
            <?php endif; ?>
        </script>

    <?php else: ?>
        <!-- Loading Section -->
        <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-dark via-dark-light to-dark relative overflow-hidden">
            <!-- Background elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-bounce-slow"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-bounce-slow" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-dark-light/50 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-primary/20 shadow-2xl animate-fade-in">
                    <!-- Loading Animation -->
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-blue-400 rounded-full flex items-center justify-center mx-auto mb-6">
                        <div class="animate-spin-slow">
                            <i class="fas fa-cog text-3xl text-white"></i>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold mb-6 text-white">
                        Confirmando Dispositivo
                    </h1>
                    
                    <p id="loadingText" class="text-xl text-gray-300 mb-8 animate-pulse-slow">
                        Verificando suas credenciais...
                    </p>
                    
                    <div class="bg-primary/10 rounded-lg p-4 border border-primary/20">
                        <div class="flex items-center justify-center space-x-2">
                            <div class="w-2 h-2 bg-primary rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-primary rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                            <div class="w-2 h-2 bg-primary rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                        </div>
                        <p class="text-primary text-sm mt-2">Processando dados de segurança...</p>
                    </div>
                </div>
            </div>
        </section>

        <script>
            // Loading messages rotation
            const loadingMessages = [
                "Verificando suas credenciais...",
                "Confirmando dispositivo...",
                "Validando dados de segurança...",
                "Conectando ao servidor...",
                "Processando informações...",
                "Finalizando confirmação..."
            ];

            let currentMessageIndex = 0;
            const loadingText = document.getElementById("loadingText");

            const messageInterval = setInterval(() => {
                currentMessageIndex = (currentMessageIndex + 1) % loadingMessages.length;
                loadingText.textContent = loadingMessages[currentMessageIndex];
            }, 2000);

            // Auto-reload after timeout to show result
            setTimeout(() => {
                clearInterval(messageInterval);
                window.location.reload();
            }, 8000);
        </script>
    <?php endif; ?>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>