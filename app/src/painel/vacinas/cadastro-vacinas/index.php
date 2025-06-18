<?php
session_start();
require_once '../../../scripts/User-Auth.php';
require_once '../../../scripts/Conexao.php';

Auth($pdo);

$sql = $pdo->prepare("SELECT * FROM vacinas_existentes ORDER BY nome_vac ASC");
$sql->execute();
$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['vacinas'] = $vacinas ?: [];
?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../../../assets/img/img-web.png" type="image/x-icon">
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
    <title>Minhas Vacinas - Cadastrar Vacina</title>
</head>

<body class="bg-dark-900 text-white min-h-screen">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-primary shadow-lg">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center">
                    <img src="../../../../assets/img/logo-head.png" alt="Logo Vacinas" class="h-12">
                </a>
                <div class="flex items-center space-x-4">
                    <a href="../" class="hidden md:flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-colors">
                        <i class="bi bi-arrow-left mr-2"></i>
                        Voltar às Vacinas
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
                    <a href="../../" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-house-door text-lg"></i>
                        <span>Início</span>
                    </a>
                    <a href="../" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-primary text-white font-medium">
                        <i class="bi bi-heart-pulse text-lg"></i>
                        <span>Vacinas</span>
                    </a>
                    <a href="../../perfil/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-person text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="../../perfil/dispositivos/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
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
                            <a href="../../../scripts/sair.php" class="text-xs text-gray-400 hover:text-white transition-colors">
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
        <div class="container mx-auto px-6 py-8 max-w-4xl">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Cadastrar Nova Vacina</h1>
                <p class="text-gray-400">Preencha as informações da vacina aplicada</p>
            </div>

            <!-- Form -->
            <div class="bg-dark-800 rounded-xl p-8 border border-dark-700">
                <form action="../../backend/cadastro-vacina.php" method="post" id="form_vacina" enctype="multipart/form-data" class="space-y-6">
                    <!-- Vaccine Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="nomeVac" class="block text-sm font-medium text-white mb-2">
                                Vacina <span class="text-red-400">*</span>
                            </label>
                            <select id="nomeVac" name="nomeVac" required class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
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
                            <input type="date" id="dataAplicacao" name="dataAplicacao" required class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <!-- Next Dose -->
                        <div>
                            <label for="proxima_dose" class="block text-sm font-medium text-white mb-2">
                                Próxima Dose
                            </label>
                            <input type="date" id="proxima_dose" name="proxima_dose" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <!-- Application Location -->
                        <div>
                            <label for="localAplicacao" class="block text-sm font-medium text-white mb-2">
                                Local de Aplicação <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="localAplicacao" name="localAplicacao" required placeholder="Ex: Hospital São Lucas" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>

                        <!-- Vaccine Type -->
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-white mb-2">
                                Tipo da Vacina <span class="text-red-400">*</span>
                            </label>
                            <select id="tipo" name="tipo" required class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
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
                            <select id="dose" name="dose" required class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
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
                            <input type="text" id="lote" name="lote" placeholder="Ex: ABC123" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>
                    </div>

                    <!-- Observations -->
                    <div>
                        <label for="obs" class="block text-sm font-medium text-white mb-2">
                            Observações
                        </label>
                        <textarea id="obs" name="obs" rows="4" placeholder="Adicione observações sobre a aplicação da vacina..." class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-none"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" class="flex-1 flex items-center justify-center px-6 py-4 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors font-medium text-lg">
                            <i class="bi bi-plus-circle mr-2"></i>
                            Cadastrar Vacina
                        </button>
                        <a href="../" class="flex-1 flex items-center justify-center px-6 py-4 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium text-lg">
                            <i class="bi bi-x-circle mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-dark-800 rounded-xl p-6 border border-dark-700">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="bi bi-info-circle text-primary mr-2"></i>
                    Dicas para o Cadastro
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-300">
                    <div class="flex items-start space-x-3">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        <p>Mantenha sempre seu cartão de vacinação em mãos para preencher as informações corretamente.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        <p>O número do lote pode ser encontrado no cartão de vacinação ou no comprovante.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        <p>Registre a data da próxima dose para receber lembretes automáticos.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        <p>Use as observações para anotar reações ou informações importantes.</p>
                    </div>
                </div>
            </div>
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

        // Form Validation and Submission
        document.getElementById('form_vacina').addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split mr-2 animate-spin"></i>Cadastrando...';
            submitBtn.disabled = true;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.text();

                if (response.ok) {
                    await Swal.fire({
                        title: 'Sucesso!',
                        text: 'Vacina cadastrada com sucesso.',
                        icon: 'success',
                        background: '#1e293b',
                        color: '#ffffff'
                    });
                    window.location.href = '../';
                } else {
                    throw new Error('Erro ao cadastrar vacina');
                }
            } catch (error) {
                await Swal.fire({
                    title: 'Erro!',
                    text: 'Não foi possível cadastrar a vacina. Verifique os dados e tente novamente.',
                    icon: 'error',
                    background: '#1e293b',
                    color: '#ffffff'
                });
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>