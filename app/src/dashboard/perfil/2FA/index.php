<?php
session_start();
require_once '../../../utils/ConexaoDB.php';
require_once '../../../utils/UsuarioAuth.php';

$sql = $pdo->prepare("SELECT email FROM 2FA WHERE email = :email");
$sql->bindValue(':email', $_SESSION['user_email']);
$sql->execute();

if ($sql->rowCount() === 1) {
    header('Location: ../');
    exit;
}

$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
$secret = $g->generateSecret();
?>
<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Ativar 2FA</title>

    <!-- Meta Tags -->
    <meta name="description" content="Ative a verificação em duas etapas para maior segurança da sua conta.">
    <meta name="keywords" content="2fa, segurança, autenticação, verificação">
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
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                    },
                    keyframes: {
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

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.4);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.6);
        }

        /* Header Styles */
        .header {
            background: rgba(0, 123, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* QR Code Animation */
        .qr-container {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        /* Step Animation */
        .step-item {
            transition: all 0.3s ease;
        }

        .step-item:hover {
            transform: translateX(4px);
        }

        /* Code Input Styling */
        .code-input {
            letter-spacing: 0.5em;
            font-family: 'Courier New', monospace;
        }

        .code-input:focus {
            transform: scale(1.02);
        }
    </style>
</head>

<body class="bg-dark text-white font-inter overflow-x-hidden">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 header">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-opacity-20 rounded-lg flex items-center justify-center">
                        <img src="/app/public/img/logo-head.png" alt="Logo Vacinas">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Minhas Vacinas</h1>
                        <p class="text-xs text-blue-100">Ativar 2FA</p>
                    </div>
                </div>

                <a href="../" class="flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Perfil
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-20 min-h-screen flex items-center justify-center gradient-bg">
        <div class="container mx-auto px-6 py-8 max-w-2xl">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="bg-primary bg-opacity-20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 animate-pulse-slow">
                    <i class="fas fa-shield-alt text-primary text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    Ativar <span class="text-gradient">Verificação em Duas Etapas</span>
                </h1>
                <p class="text-gray-400">Adicione uma camada extra de segurança à sua conta</p>
            </div>

            <!-- 2FA Setup Card -->
            <div class="bg-dark-card rounded-xl p-8 border border-gray-600 shadow-2xl">
                <!-- Steps -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-list-ol text-primary mr-3"></i>
                        Passo a passo para ativar o 2FA
                    </h2>

                    <div class="space-y-4">
                        <div class="step-item flex items-start space-x-4 p-4 rounded-lg bg-dark hover:bg-dark-light transition-all duration-300">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">1</div>
                            <div>
                                <p class="text-gray-300">Baixe um aplicativo autenticador</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full">Google Authenticator</span>
                                    <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">Authy</span>
                                    <span class="bg-purple-600 text-white text-xs px-2 py-1 rounded-full">Microsoft Authenticator</span>
                                </div>
                            </div>
                        </div>

                        <div class="step-item flex items-start space-x-4 p-4 rounded-lg bg-dark hover:bg-dark-light transition-all duration-300">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">2</div>
                            <p class="text-gray-300">Abra o aplicativo e selecione <strong class="text-white">"Adicionar nova conta"</strong> ou <strong class="text-white">"+"</strong></p>
                        </div>

                        <div class="step-item flex items-start space-x-4 p-4 rounded-lg bg-dark hover:bg-dark-light transition-all duration-300">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">3</div>
                            <p class="text-gray-300">Escaneie o código QR abaixo ou insira a chave manualmente</p>
                        </div>

                        <div class="step-item flex items-start space-x-4 p-4 rounded-lg bg-dark hover:bg-dark-light transition-all duration-300">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">4</div>
                            <p class="text-gray-300">Digite o código de 6 dígitos gerado pelo aplicativo</p>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="text-center mb-8">
                    <div class="qr-container bg-white rounded-xl p-6 inline-block mb-4 shadow-lg">
                        <!-- Placeholder QR Code -->
                        <div class="w-48 h-48 bg-gray-100 flex items-center justify-center rounded-lg">
                            <div class="text-center">
                                <img src="<?php echo $g->getUrl('Minhas Vacinas', '(' . $_SESSION['user_email'] . ')', $secret); ?>" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="bg-dark rounded-lg p-4 border border-gray-600">
                        <h3 class="text-white font-semibold mb-3 flex items-center justify-center">
                            <i class="fas fa-key text-primary mr-2"></i>
                            Ou copie esta chave manualmente:
                        </h3>
                        <div class="flex items-center justify-center space-x-3 flex-wrap gap-2">
                            <code id="manualToken" class="bg-dark-light text-primary px-4 py-2 rounded font-mono text-lg border border-primary border-opacity-30 select-all">
                                <?php echo htmlspecialchars($secret); ?>
                            </code>
                            <button onclick="copyToken(event)" class="flex items-center px-3 py-2 btn-primary rounded-lg text-white font-medium">
                                <i class="fas fa-copy mr-2"></i>
                                Copiar
                            </button>
                        </div>
                        <p class="text-gray-400 text-xs mt-2">Clique na chave para selecioná-la</p>
                    </div>
                </div>

                <!-- Verification Form -->
                <form id="form-2fa" class="space-y-6" method="post" action="../../backend/ativar-2FA.php">
                    <div>
                        <label for="codigo" class="block text-sm font-medium text-white mb-2 flex items-center">
                            <i class="fas fa-mobile-alt text-primary mr-2"></i>
                            Código de Verificação <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            id="codigo"
                            name="codigo"
                            maxlength="6"
                            placeholder="000000"
                            autocapitalize="off"
                            class="code-input w-full px-4 py-4 bg-dark border border-gray-600 rounded-lg text-white text-center text-2xl tracking-widest focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                            inputmode="numeric"
                            pattern="[0-9]*">
                        <p class="text-sm text-gray-400 mt-2 flex items-center">
                            <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                            Digite o código de 6 dígitos do seu aplicativo autenticador
                        </p>
                    </div>

                    <input type="hidden" name="key" value="<?php echo $secret; ?>">


                    <button type="submit" class="w-full flex items-center justify-center px-6 py-4 btn-primary rounded-lg text-white font-medium text-lg transition-all duration-300 hover:scale-[1.02]">
                        <i class="fas fa-shield-check mr-2"></i>
                        <span id="btn-text">Ativar Verificação em Duas Etapas</span>
                        <div id="loading-spinner" class="hidden ml-2">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                        </div>
                    </button>
                </form>

                <!-- Security Notice -->
                <div class="mt-8 bg-blue-900 bg-opacity-20 border border-blue-500 border-opacity-30 rounded-lg p-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-400 text-xl mr-3 mt-1"></i>
                        <div>
                            <h4 class="text-blue-400 font-semibold mb-3 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Importante - Leia com atenção!
                            </h4>
                            <ul class="text-gray-300 text-sm space-y-2">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-400 mr-2 mt-1 text-xs"></i>
                                    <span>Guarde a chave de backup em local seguro (anote em papel)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-400 mr-2 mt-1 text-xs"></i>
                                    <span>Você precisará do aplicativo autenticador para fazer login</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-400 mr-2 mt-1 text-xs"></i>
                                    <span>Se perder o acesso ao aplicativo, entre em contato com o suporte</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-400 mr-2 mt-1 text-xs"></i>
                                    <span>Mantenha seu dispositivo móvel sempre atualizado</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="mt-6 text-center">
                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-3 bg-dark-card text-gray-400 text-xs">Precisa de ajuda?</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 text-sm">
                        <a href="suporte.html" class="flex-1 bg-dark rounded-lg p-3 border border-gray-600 hover:border-primary transition-colors">
                            <i class="fas fa-headset text-primary mb-1"></i>
                            <p class="text-gray-400 text-xs">Problemas com a configuração?</p>
                            <p class="text-primary text-xs font-medium">Fale com o suporte</p>
                        </a>
                        <div class="flex-1 bg-dark rounded-lg p-3 border border-gray-600">
                            <i class="fas fa-clock text-primary mb-1"></i>
                            <p class="text-gray-400 text-xs">Disponível 24/7</p>
                            <p class="text-gray-300 text-xs">Suporte técnico</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JavaScript -->
    <script>
        // Copy token function
        function copyToken(event) {
            const tokenElement = document.getElementById('manualToken');
            const tokenText = tokenElement.textContent.trim();

            const button = event.currentTarget;
            const originalHTML = button.innerHTML;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(tokenText).then(() => {
                    button.innerHTML = '<i class="fas fa-check mr-2"></i>Copiado!';
                    button.classList.remove('btn-primary');
                    button.classList.add('bg-green-600');

                    setTimeout(() => {
                        button.innerHTML = originalHTML;
                        button.classList.remove('bg-green-600');
                        button.classList.add('btn-primary');
                    }, 2000);
                }).catch(err => {
                    fallbackCopy(tokenText, button, originalHTML);
                });
            } else {
                fallbackCopy(tokenText, button, originalHTML);
            }
        }

        function fallbackCopy(text, button, originalHTML) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.top = '-9999px';
            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();

            try {
                document.execCommand('copy');
                button.innerHTML = '<i class="fas fa-check mr-2"></i>Copiado!';
                button.classList.remove('btn-primary');
                button.classList.add('bg-green-600');
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.classList.remove('bg-green-600');
                    button.classList.add('btn-primary');
                }, 2000);
            } catch (err) {
                alert('Não foi possível copiar o token.');
            }

            document.body.removeChild(textarea);
        }


        // Code input formatting
        document.getElementById('codigo').addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            // Add visual feedback when complete
            if (this.value.length === 6) {
                this.classList.add('border-green-500', 'bg-green-900', 'bg-opacity-20');
            } else {
                this.classList.remove('border-green-500', 'bg-green-900', 'bg-opacity-20');
            }
        });
    </script>

    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>