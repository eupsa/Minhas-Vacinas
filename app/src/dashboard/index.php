<?php
session_start();
require_once '../utils/ConexaoDB.php';
require_once '../utils/UsuarioAuth.php';

Auth($pdo);

$sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario ORDER BY id_vac DESC LIMIT 3");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();
$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);


$sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario ORDER BY id_vac DESC LIMIT 3");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();
$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();
$totalCount = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $pdo->prepare("
    SELECT
        id_usuario,
        nome,
        email,
        estado,
        senha,
        data_nascimento,
        genero,
        cpf,
        telefone,
        cidade,
        foto_perfil,
        ROUND(
            (
                (nome IS NOT NULL AND nome != '') +
                (email IS NOT NULL AND email != '') +
                (estado IS NOT NULL AND email != '') +
                (senha IS NOT NULL AND senha != '') +
                (data_nascimento IS NOT NULL) + -- Simplified check for DATE column
                (genero IS NOT NULL AND genero != 'Não Informado') +
                (cpf IS NOT NULL AND cpf != '') +
                (telefone IS NOT NULL AND telefone != '') +
                (cidade IS NOT NULL AND cidade != 'Não informado') +
                (foto_perfil IS NOT NULL AND foto_perfil != '')
            ) / 10 * 100, 0
        ) AS percentual_completo
    FROM usuario
    WHERE id_usuario = :id
");
$sql->bindValue(':id', $_SESSION['user_id']);
$sql->execute();
$usuario = $sql->fetch(PDO::FETCH_ASSOC);


$_SESSION['vacinas'] = $vacinas ?: [];
?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/app/public/img/img-web.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
    <title>Minhas Vacinas - Dashboard</title>
</head>

<body class="bg-dark-900 text-white min-h-screen">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-primary shadow-lg">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center">
                    <img src="/app/public/img/logo-head.png" alt="Logo Vacinas" class="h-12">
                </a>
                <button id="sidebarToggle" class="lg:hidden text-white hover:text-gray-200 transition-colors">
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-16 h-full w-64 bg-dark-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 border-r border-dark-700">
        <div class="p-6">
            <div class="flex flex-col space-y-4">
                <!-- Navigation Links -->
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-primary text-white font-medium">
                        <i class="bi bi-house-door text-lg"></i>
                        <span>Início</span>
                    </a>
                    <a href="vacinas/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-heart-pulse text-lg"></i>
                        <span>Vacinas</span>
                    </a>
                    <a href="perfil/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-person text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="perfil/dispositivos/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-laptop text-lg"></i>
                        <span>Dispositivos</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="mt-auto pt-6 border-t border-dark-700">
                    <div class="flex items-center space-x-3 p-4 rounded-lg bg-dark-700">
                        <?php if (isset($_SESSION['user_foto'])): ?>
                            <img src="<?php echo $_SESSION['user_foto']; ?>" alt="Foto do Usuário" class="w-10 h-10 rounded-full">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                                <i class="bi bi-person text-white"></i>
                            </div>
                        <?php endif; ?>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">
                                Olá, <?php echo isset($_SESSION['user_nome']) ? explode(' ', $_SESSION['user_nome'])[0] : 'Usuário'; ?>
                            </p>
                            <a href="../scripts/sair.php" class="text-xs text-gray-400 hover:text-white transition-colors">
                                <i class="bi bi-box-arrow-right mr-1"></i>Sair
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div class="container mx-auto px-6 py-8">
            <!-- Welcome Section -->
            <div class="mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">
                    Bem-vindo ao seu painel, <?php echo isset($_SESSION['user_nome']) ? explode(' ', $_SESSION['user_nome'])[0] : 'Usuário'; ?>! 👋
                </h1>
                <p class="text-gray-400 text-lg">Gerencie suas vacinas e mantenha seu histórico sempre atualizado.</p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-gradient-to-r from-primary to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total de Vacinas</p>
                            <p class="text-3xl font-bold"><?= count($totalCount) ?></p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <i class="bi bi-heart-pulse text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Perfil Completo</p>
                            <p class="text-3xl font-bold"><?= ($usuario['percentual_completo']) ?>%</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <i class="bi bi-person-check text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Conta Segura</p>
                            <p class="text-3xl font-bold">
                                <i class="bi bi-shield-check"></i>
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <i class="bi bi-lock text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Updates Section -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6">Atualizações e Novidades</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Available Updates -->
                    <div class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-primary transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="bi bi-check-circle text-green-400 text-xl"></i>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Disponível</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Gerenciamento de Vacinas</h3>
                        <p class="text-gray-400 mb-4">Cadastre e gerencie suas vacinas com facilidade.</p>
                        <a href="vacinas/nova-vacina/" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="bi bi-plus-circle mr-2"></i>
                            Gerenciar
                        </a>
                    </div>

                    <div class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-primary transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="bi bi-check-circle text-green-400 text-xl"></i>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Disponível</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Gerenciar Dispositivos</h3>
                        <p class="text-gray-400 mb-4">Veja e remova dispositivos conectados à sua conta.</p>
                        <a href="perfil/dipositivos/" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="bi bi-laptop mr-2"></i>
                            Gerenciar
                        </a>
                    </div>

                    <div class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-primary transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="bi bi-check-circle text-green-400 text-xl"></i>
                            </div>
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Disponível</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Login com Google</h3>
                        <p class="text-gray-400 mb-4">Acesse sua conta de forma rápida e segura.</p>
                        <button class="inline-flex items-center px-4 py-2 bg-gray-600 text-gray-400 rounded-lg cursor-not-allowed">
                            <i class="bi bi-google mr-2"></i>
                            Apenas novos usuários
                        </button>
                    </div>

                    <!-- In Development -->
                    <div class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-yellow-500 transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="bi bi-hourglass-split text-yellow-400 text-xl animate-spin"></i>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Em desenvolvimento</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Cadastro de Dependentes</h3>
                        <p class="text-gray-400 mb-4">Adicione dependentes e gerencie suas vacinas.</p>
                        <button class="inline-flex items-center px-4 py-2 bg-gray-600 text-gray-400 rounded-lg cursor-not-allowed">
                            <i class="bi bi-people mr-2"></i>
                            Indisponível
                        </button>
                    </div>

                    <div class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-yellow-500 transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="bi bi-hourglass-split text-yellow-400 text-xl animate-spin"></i>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Em desenvolvimento</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Blog MV!</h3>
                        <p class="text-gray-400 mb-4">Novidades, dicas e atualizações sobre vacinação.</p>
                        <button class="inline-flex items-center px-4 py-2 bg-gray-600 text-gray-400 rounded-lg cursor-not-allowed">
                            <i class="bi bi-journal-text mr-2"></i>
                            Indisponível
                        </button>
                    </div>

                    <div class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-yellow-500 transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-500 bg-opacity-20 rounded-lg p-2 mr-3">
                                <i class="bi bi-hourglass-split text-yellow-400 text-xl animate-spin"></i>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Em desenvolvimento</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">App Mobile</h3>
                        <p class="text-gray-400 mb-4">Aplicativo para iOS e Android em breve.</p>
                        <button class="inline-flex items-center px-4 py-2 bg-gray-600 text-gray-400 rounded-lg cursor-not-allowed">
                            <i class="bi bi-phone mr-2"></i>
                            Indisponível
                        </button>
                    </div>
                </div>
            </section>

            <!-- Recent Vaccines -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Últimas Vacinas Adicionadas</h2>
                    <a href="vacinas/" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="bi bi-eye mr-2"></i>
                        Ver todas
                    </a>
                </div>

                <?php if (count($vacinas) > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($vacinas as $vacina): ?>
                            <div class="bg-dark-800 rounded-xl overflow-hidden border border-dark-700 hover:border-primary transition-colors group">
                                <?php if (isset($vacina['path_card'])): ?>
                                    <img src="<?php echo $vacina['path_card']; ?>" alt="Vacina" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                <?php else: ?>
                                    <div class="w-full h-48 bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center">
                                        <i class="bi bi-heart-pulse text-white text-4xl"></i>
                                    </div>
                                <?php endif; ?>

                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-white mb-4"><?= htmlspecialchars($vacina['nome_vac']) ?></h3>

                                    <div class="space-y-2 text-sm">
                                        <?php if (!empty($vacina['dose'])): ?>
                                            <div class="flex items-center text-gray-300">
                                                <i class="bi bi-heart-pulse text-primary mr-2"></i>
                                                <span class="font-medium">Dose:</span>
                                                <span class="ml-1"><?= htmlspecialchars($vacina['dose']) ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($vacina['data_aplicacao'])): ?>
                                            <div class="flex items-center text-gray-300">
                                                <i class="bi bi-calendar-event text-primary mr-2"></i>
                                                <span class="font-medium">Data:</span>
                                                <span class="ml-1"><?= date('d/m/Y', strtotime($vacina['data_aplicacao'])) ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($vacina['local_aplicacao'])): ?>
                                            <div class="flex items-center text-gray-300">
                                                <i class="bi bi-geo-alt text-primary mr-2"></i>
                                                <span class="font-medium">Local:</span>
                                                <span class="ml-1"><?= htmlspecialchars($vacina['local_aplicacao']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-dark-800 rounded-xl p-12 text-center border border-dark-700">
                        <div class="bg-primary bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-heart-pulse text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Nenhuma vacina registrada</h3>
                        <p class="text-gray-400 mb-6">Comece adicionando sua primeira vacina ao histórico.</p>
                        <a href="vacinas/cadastro-vacinas/" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="bi bi-plus-circle mr-2"></i>
                            Adicionar Vacina
                        </a>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    <script src="backend-error-handler.js"></script>
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(registration => console.log('Service Worker registrado:', registration))
                    .catch(error => console.log('Erro ao registrar Service Worker:', error));
            });
        }
    </script>
</body>

</html>