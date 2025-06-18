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
<html lang="pt-br" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/app/public/img/img-web.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/app/public/css/sweetalert-styles.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#007bff',
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <title>Minhas Vacinas - Ativar 2FA</title>
</head>

<body class="bg-dark-900 text-white min-h-screen">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-primary shadow-lg">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center">
                    <img src="/app/public/img/logo-head.png" alt="Logo Vacinas" class="h-12">
                </a>
                <a href="../" class="flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-colors">
                    <i class="bi bi-arrow-left mr-2"></i>
                    Perfil
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-20 min-h-screen flex items-center justify-center">
        <div class="container mx-auto px-6 py-8 max-w-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="bg-primary bg-opacity-20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-shield-lock text-primary text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Ativar Verificação em Duas Etapas</h1>
                <p class="text-gray-400">Adicione uma camada extra de segurança à sua conta</p>
            </div>

            <!-- 2FA Setup Card -->
            <div class="bg-dark-800 rounded-xl p-8 border border-dark-700">
                <!-- Steps -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="bi bi-list-ol text-primary mr-3"></i>
                        Passo a passo para ativar o 2FA
                    </h2>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">1</div>
                            <p class="text-gray-300">Baixe um aplicativo autenticador como <strong class="text-white">Google Authenticator</strong> ou <strong class="text-white">Authy</strong></p>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">2</div>
                            <p class="text-gray-300">Abra o aplicativo e selecione <strong class="text-white">"Adicionar nova conta"</strong></p>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">3</div>
                            <p class="text-gray-300">Escaneie o código QR abaixo ou insira a chave manualmente</p>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">4</div>
                            <p class="text-gray-300">Digite o código de 6 dígitos gerado pelo aplicativo</p>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="text-center mb-8">
                    <div class="bg-white rounded-xl p-6 inline-block mb-4">
                        <img src="<?php echo $g->getUrl('Minhas Vacinas', '(' . $_SESSION['user_email'] . ')', $secret); ?>" alt="QR Code para autenticação" class="max-w-full h-auto">
                    </div>

                    <div class="bg-dark-700 rounded-lg p-4">
                        <h3 class="text-white font-semibold mb-2">Ou copie esta chave manualmente:</h3>
                        <div class="flex items-center justify-center space-x-3">
                            <code id="manualToken" class="bg-dark-900 text-primary px-4 py-2 rounded font-mono text-lg"><?php echo $secret; ?></code>
                            <button onclick="copyToken()" class="flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="bi bi-clipboard mr-2"></i>
                                Copiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Verification Form -->
                <form action="../../backend/ativar-2FA.php" method="post" id="form-2fa" class="space-y-6">
                    <div>
                        <label for="codigo" class="block text-sm font-medium text-white mb-2">
                            Código de Verificação <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="codigo" name="codigo" maxlength="6" placeholder="000000" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white text-center text-2xl font-mono tracking-widest focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        <p class="text-sm text-gray-400 mt-2">Digite o código de 6 dígitos do seu aplicativo autenticador</p>
                    </div>

                    <input type="hidden" name="key" value="<?php echo $secret; ?>">

                    <button type="submit" class="w-full flex items-center justify-center px-6 py-4 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors font-medium text-lg">
                        <i class="bi bi-shield-check mr-2"></i>
                        <span id="btn-text">Ativar Verificação em Duas Etapas</span>
                        <div id="loading-spinner" class="hidden ml-2">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                        </div>
                    </button>
                </form>

                <!-- Security Notice -->
                <div class="mt-8 bg-blue-900 bg-opacity-20 border border-blue-500 border-opacity-30 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="bi bi-info-circle text-blue-400 text-xl mr-3 mt-1"></i>
                        <div>
                            <h4 class="text-blue-400 font-semibold mb-2">Importante!</h4>
                            <ul class="text-gray-300 text-sm space-y-1">
                                <li>• Guarde a chave de backup em local seguro</li>
                                <li>• Você precisará do aplicativo autenticador para fazer login</li>
                                <li>• Se perder o acesso ao aplicativo, entre em contato com o suporte</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>