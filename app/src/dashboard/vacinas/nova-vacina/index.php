<?php
session_start();
require_once '../../../utils/ConexaoDB.php';
require_once '../../../utils/UsuarioAuth.php';

Auth($pdo);

$sql = $pdo->prepare("SELECT * FROM vacinas_existentes ORDER BY nome_vac ASC");
$sql->execute();
$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['vacinas'] = $vacinas ?: [];
?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Nova Vacina</title>

    <!-- Meta Tags -->
    <meta name="description" content="Cadastre uma nova vacina no seu histórico de vacinação.">
    <meta name="keywords" content="nova vacina, cadastro, registro, saúde">
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

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, #1a1f2e 0%, #252b3d 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(0, 123, 255, 0.1);
        }

        .sidebar-link {
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background: rgba(0, 123, 255, 0.1);
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        /* Header Styles */
        .header {
            background: rgba(0, 123, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
                        <img src="/app/public/img/logo-head.png" alt="">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Minhas Vacinas</h1>
                        <p class="text-xs text-blue-100">Nova Vacina</p>
                    </div>
                </div>

                <button id="sidebarToggle" class="lg:hidden text-white hover:text-blue-200 transition-colors p-2">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-16 h-full w-64 sidebar transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="p-6">
            <div class="flex flex-col space-y-4 h-full">
                <!-- Navigation Links -->
                <nav class="space-y-2">
                    <a href="../../" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-home text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="../" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-syringe text-lg"></i>
                        <span>Minhas Vacinas</span>
                    </a>
                    <a href="../../perfil/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-user text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="../../perfil/dispositivos/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-laptop text-lg"></i>
                        <span>Dispositivos</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="mt-auto pt-6 border-t border-gray-600">
                    <div class="flex items-center space-x-3 p-4 rounded-lg bg-dark-light">
                        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate"><?php echo isset($_SESSION['user_nome']) ? explode(' ', $_SESSION['user_nome'])[0] : 'Usuário'; ?></p>
                            <button class="text-xs text-gray-400 hover:text-white transition-colors" id="btnLogout">
                                <i class="fas fa-sign-out-alt mr-1"></i>Sair
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div class="container mx-auto px-6 py-8 max-w-4xl">
            <!-- Header -->
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-3xl font-bold text-white mb-2">Cadastrar Nova Vacina</h1>
                <p class="text-gray-400">Preencha as informações da vacina aplicada</p>
            </div>

            <!-- Form -->
            <div class="bg-dark-card rounded-xl p-8 border border-gray-600">
                <form id="form_vacina" class="space-y-6">
                    <!-- Vaccine Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="nomeVac" class="block text-sm font-medium text-white mb-2">
                                Vacina <span class="text-red-400">*</span>
                            </label>
                            <select id="nomeVac" name="nomeVac" required class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                <option value="" disabled selected>Selecione uma vacina</option>
                                <?php if (count($vacinas) > 0): ?>
                                    <?php foreach ($vacinas as $vacina): ?>
                                        <option value="<?= htmlspecialchars($vacina['nome_vac']) ?>"><?= htmlspecialchars($vacina['nome_vac']) ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Nenhuma vacina disponível</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Application Date -->
                        <div>
                            <label for="dataAplicacao" class="block text-sm font-medium text-white mb-2">
                                Data da Aplicação <span class="text-red-400">*</span>
                            </label>
                            <input type="date" id="dataAplicacao" name="dataAplicacao" required class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <!-- Next Dose -->
                        <div>
                            <label for="proxima_dose" class="block text-sm font-medium text-white mb-2">
                                Próxima Dose
                            </label>
                            <input type="date" id="proxima_dose" name="proxima_dose" class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <!-- Application Location -->
                        <div>
                            <label for="localAplicacao" class="block text-sm font-medium text-white mb-2">
                                Local de Aplicação <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="localAplicacao" name="localAplicacao" required placeholder="Ex: Hospital São Lucas" class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <!-- Vaccine Type -->
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-white mb-2">
                                Tipo da Vacina <span class="text-red-400">*</span>
                            </label>
                            <select id="tipo" name="tipo" required class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                <option value="" disabled selected>Selecione o tipo</option>
                                <option value="Imunização">Imunização</option>
                                <option value="Vacina de Vírus Vivo Atenuado">Vacina de Vírus Vivo Atenuado</option>
                                <option value="Vacina de Vírus Inativado">Vacina de Vírus Inativado</option>
                                <option value="Vacina Subunitária">Vacina Subunitária</option>
                                <option value="Vacina de RNA Mensageiro (mRNA)">Vacina de RNA Mensageiro (mRNA)</option>
                                <option value="Vacina de Vetor Viral">Vacina de Vetor Viral</option>
                                <option value="Vacina de Proteína Recombinante">Vacina de Proteína Recombinante</option>
                            </select>
                        </div>

                        <!-- Dose -->
                        <div>
                            <label for="dose" class="block text-sm font-medium text-white mb-2">
                                Dose <span class="text-red-400">*</span>
                            </label>
                            <select id="dose" name="dose" required class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                <option value="" disabled selected>Selecione a dose</option>
                                <option value="1ª Dose">1ª Dose</option>
                                <option value="2ª Dose">2ª Dose</option>
                                <option value="Reforço">Reforço</option>
                                <option value="Dose Única">Dose Única</option>
                                <option value="Dose de Manutenção">Dose de Manutenção</option>
                                <option value="Dose Adicional">Dose Adicional</option>
                            </select>
                        </div>

                        <!-- Lot -->
                        <div>
                            <label for="lote" class="block text-sm font-medium text-white mb-2">
                                Lote
                            </label>
                            <input type="text" id="lote" name="lote" placeholder="Ex: ABC123" class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>
                    </div>

                    <!-- Observations -->
                    <div>
                        <label for="obs" class="block text-sm font-medium text-white mb-2">
                            Observações
                        </label>
                        <textarea id="obs" name="obs" rows="4" placeholder="Adicione observações sobre a aplicação da vacina..." class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-none"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" id="submitBtn" class="flex-1 flex items-center justify-center px-6 py-4 btn-primary rounded-lg text-white font-medium text-lg">
                            <i class="fas fa-plus mr-2"></i>
                            <span id="btn-text">Cadastrar Vacina</span>
                            <div id="loading-spinner" class="hidden inline-block ml-2">
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                            </div>
                        </button>
                        <a href="vacinas.html" class="flex-1 flex items-center justify-center px-6 py-4 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium text-lg">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-dark-card rounded-xl p-6 border border-gray-600">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    Dicas para o Cadastro
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-300">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
                        <p>Mantenha sempre seu cartão de vacinação em mãos para preencher as informações corretamente.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
                        <p>O número do lote pode ser encontrado no cartão de vacinação ou no comprovante.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
                        <p>Registre a data da próxima dose para receber lembretes automáticos.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
                        <p>Use as observações para anotar reações ou informações importantes.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    <!-- JavaScript -->
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        sidebarToggle.addEventListener('click', openSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Close sidebar when clicking on navigation links on mobile
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        document.getElementById('btnLogout').addEventListener('click', () => {
            Swal.fire({
                title: 'Tem certeza que deseja sair?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, sair',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redireciona para a página PHP que destrói a sessão
                    window.location.href = '/app/src/utils/Sair.php';
                }
            });
        });
    </script>
    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>