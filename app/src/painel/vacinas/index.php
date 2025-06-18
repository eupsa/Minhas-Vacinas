<?php
session_start();
require_once '../../scripts/User-Auth.php';
require_once '../../scripts/Conexao.php';

Auth($pdo);

$sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario ORDER BY data_aplicacao DESC");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();

$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['vacinas'] = $vacinas ?: [];
?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../../assets/img/img-web.png" type="image/x-icon">
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
    <title>Minhas Vacinas - Gerenciar Vacinas</title>
</head>

<body class="bg-dark-900 text-white min-h-screen">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-primary shadow-lg">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center">
                    <img src="../../../assets/img/logo-head.png" alt="Logo Vacinas" class="h-12">
                </a>
                <div class="flex items-center space-x-4">
                    <a href="../" class="hidden md:flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-colors">
                        <i class="bi bi-arrow-left mr-2"></i>
                        Voltar ao Dashboard
                    </a>
                    <button id="sidebarToggle" class="lg:hidden text-white hover:text-gray-200 transition-colors">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-16 h-full w-64 bg-dark-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 border-r border-dark-700">
        <div class="p-6">
            <div class="flex flex-col space-y-4">
                <nav class="space-y-2">
                    <a href="../" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-house-door text-lg"></i>
                        <span>Início</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-primary text-white font-medium">
                        <i class="bi bi-heart-pulse text-lg"></i>
                        <span>Vacinas</span>
                    </a>
                    <a href="../perfil/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-person text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="../perfil/dispositivos/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-laptop text-lg"></i>
                        <span>Dispositivos</span>
                    </a>
                </nav>

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
                            <a href="../../scripts/sair.php" class="text-xs text-gray-400 hover:text-white transition-colors">
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
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Minhas Vacinas</h1>
                        <p class="text-gray-400">Registre e visualize suas vacinas aplicadas</p>
                    </div>
                    <a href="cadastro-vacinas/" class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        <i class="bi bi-plus-circle mr-2"></i>
                        Registrar Nova Vacina
                    </a>
                </div>

                <!-- Stats -->
                <div class="bg-gradient-to-r from-primary to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total de Vacinas Registradas</p>
                            <p class="text-3xl font-bold"><?= count($vacinas) ?></p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <i class="bi bi-heart-pulse text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vaccines Grid -->
            <?php if (count($vacinas) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($vacinas as $vacina): ?>
                        <div class="bg-dark-800 rounded-xl overflow-hidden border border-dark-700 hover:border-primary transition-all duration-300 group">
                            <?php if (isset($vacina['path_card'])): ?>
                                <img src="<?php echo $vacina['path_card']; ?>" alt="Vacina" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center">
                                    <i class="bi bi-heart-pulse text-white text-4xl"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-white mb-4"><?= htmlspecialchars($vacina['nome_vac'], ENT_QUOTES, 'UTF-8') ?></h3>
                                
                                <div class="space-y-3 mb-6">
                                    <?php if (!empty($vacina['data_aplicacao'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="bi bi-calendar-event text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Data de Aplicação</span>
                                                <span class="font-medium"><?= date('d/m/Y', strtotime($vacina['data_aplicacao'])) ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($vacina['proxima_dose']) && strtotime($vacina['proxima_dose']) > 0): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="bi bi-calendar-plus text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Próxima Dose</span>
                                                <span class="font-medium"><?= date('d/m/Y', strtotime($vacina['proxima_dose'])) ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($vacina['local_aplicacao'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="bi bi-geo-alt text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Local</span>
                                                <span class="font-medium"><?= htmlspecialchars($vacina['local_aplicacao'], ENT_QUOTES, 'UTF-8') ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($vacina['dose'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="bi bi-heart-pulse text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Dose</span>
                                                <span class="font-medium"><?= htmlspecialchars($vacina['dose'], ENT_QUOTES, 'UTF-8') ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($vacina['lote'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="bi bi-hash text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Lote</span>
                                                <span class="font-medium"><?= htmlspecialchars($vacina['lote'], ENT_QUOTES, 'UTF-8') ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex items-center justify-between pt-4 border-t border-dark-700">
                                    <form action="../backend/excluir-vacina.php" method="POST" class="delete-vaccine-form">
                                        <input type="hidden" name="id_vac" value="<?= $vacina['id_vac'] ?>">
                                        <button type="submit" class="flex items-center px-3 py-2 text-red-400 hover:text-red-300 hover:bg-red-500 hover:bg-opacity-20 rounded-lg transition-colors">
                                            <i class="bi bi-trash mr-2"></i>
                                            Excluir
                                        </button>
                                    </form>
                                    
                                    <button onclick="exportVaccine(<?= $vacina['id_vac'] ?>)" class="flex items-center px-3 py-2 text-primary hover:text-blue-300 hover:bg-primary hover:bg-opacity-20 rounded-lg transition-colors">
                                        <i class="bi bi-download mr-2"></i>
                                        Exportar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-dark-800 rounded-xl p-12 text-center border border-dark-700">
                    <div class="bg-primary bg-opacity-20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="bi bi-heart-pulse text-primary text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Nenhuma vacina registrada</h3>
                    <p class="text-gray-400 mb-8 max-w-md mx-auto">Comece seu histórico de vacinação adicionando sua primeira vacina. Mantenha sempre seu registro atualizado!</p>
                    <a href="cadastro-vacinas/" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        <i class="bi bi-plus-circle mr-2"></i>
                        Adicionar Primeira Vacina
                    </a>
                </div>
            <?php endif; ?>
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

        // Delete Vaccine Handler
        document.querySelectorAll('.delete-vaccine-form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const result = await Swal.fire({
                    title: 'Confirmar Exclusão',
                    text: 'Tem certeza que deseja excluir esta vacina? Esta ação não pode ser desfeita.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sim, excluir',
                    cancelButtonText: 'Cancelar',
                    background: '#1e293b',
                    color: '#ffffff'
                });

                if (result.isConfirmed) {
                    try {
                        const formData = new FormData(form);
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.text();
                        
                        if (response.ok) {
                            await Swal.fire({
                                title: 'Sucesso!',
                                text: 'Vacina excluída com sucesso.',
                                icon: 'success',
                                background: '#1e293b',
                                color: '#ffffff'
                            });
                            location.reload();
                        } else {
                            throw new Error('Erro ao excluir vacina');
                        }
                    } catch (error) {
                        await Swal.fire({
                            title: 'Erro!',
                            text: 'Não foi possível excluir a vacina. Tente novamente.',
                            icon: 'error',
                            background: '#1e293b',
                            color: '#ffffff'
                        });
                    }
                }
            });
        });

        // Export Vaccine Function
        function exportVaccine(vaccineId) {
            // Implementation for vaccine export
            console.log('Exporting vaccine:', vaccineId);
            // Add your export logic here
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
