<?php
session_start();
require_once '../../utils/ConexaoDB.php';
require_once '../../utils/UsuarioAuth.php';

Auth($pdo);
Gerar_Session($pdo);

$sql = $pdo->prepare("SELECT email FROM 2FA WHERE email = :email");
$sql->bindValue(':email', $_SESSION['user_email']);
$sql->execute();

$DF = ($sql->rowCount() === 1);
?>
<!DOCTYPE html>
<html lang="pt-br" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/app/public/img/img-web.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/app/public/css/sweetalert-styles.css">
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
    <title>Minhas Vacinas - Perfil</title>
</head>

<body class="bg-dark-900 text-white min-h-screen">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-primary shadow-lg">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center">
                    <img src="/app/public/img/logo-head.png" alt="Logo Vacinas" class="h-12">
                </a>
                <div class="flex items-center space-x-4">
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
                    <a href="../vacinas/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
                        <i class="bi bi-heart-pulse text-lg"></i>
                        <span>Vacinas</span>
                    </a>
                    <a href="" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-primary text-white font-medium">
                        <i class="bi bi-person text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="dipositivos/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-dark-700 hover:text-white transition-colors">
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
        <div class="container mx-auto px-6 py-8 max-w-4xl">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Meu Perfil</h1>
                <p class="text-gray-400">Gerencie suas informações pessoais e configurações de segurança</p>
            </div>

            <!-- User Data Card -->
            <div class="bg-dark-800 rounded-xl p-8 border border-dark-700 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="bi bi-person-circle text-primary mr-3"></i>
                        Dados Pessoais
                    </h2>
                    <button onclick="openEditModal()" class="flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="bi bi-pencil mr-2"></i>
                        Editar
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Nome</label>
                        <p class="text-white font-medium"><?php echo isset($_SESSION['user_nome']) ? $_SESSION['user_nome'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">E-mail</label>
                        <p class="text-white font-medium"><?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Telefone</label>
                        <p class="text-white font-medium"><?php echo isset($_SESSION['user_telefone']) ? '+55 ' . $_SESSION['user_telefone'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">CPF</label>
                        <p class="text-white font-medium"><?php echo isset($_SESSION['user_cpf']) ? explode('.', $_SESSION['user_cpf'])[0] . '.***.***-**' : '***.***.***-**'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Data de Nascimento</label>
                        <p class="text-white font-medium"><?php echo isset($_SESSION['user_nascimento']) ? date('d/m/Y', strtotime($_SESSION['user_nascimento'])) : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Gênero</label>
                        <p class="text-white font-medium"><?php echo isset($_SESSION['user_genero']) ? $_SESSION['user_genero'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Estado</label>
                        <p class="text-white font-medium"><?php echo isset($_SESSION['user_estado']) ? $_SESSION['user_estado'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Cidade</label>
                        <p class="text-white font-medium"><?php echo isset($_SESSION['user_cidade']) ? $_SESSION['user_cidade'] : 'Não informado'; ?></p>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="bg-dark-800 rounded-xl p-8 border border-dark-700 mb-8">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="bi bi-shield-lock text-primary mr-3"></i>
                    Segurança da Conta
                </h2>

                <div class="space-y-6">
                    <div class="bg-dark-700 rounded-lg p-6">
                        <p class="text-gray-300 mb-4">A segurança da sua conta é nossa prioridade. <span class="text-primary">Mantenha suas informações de login e senha protegidas.</span></p>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-dark-800 rounded-lg">
                                <div class="flex items-center">
                                    <i class="bi bi-check-circle text-green-400 mr-3"></i>
                                    <div>
                                        <p class="text-white font-medium">Confirmação de novo acesso</p>
                                        <p class="text-sm text-gray-400">Ativa a confirmação do novo acesso de dispositivos com IP anormal</p>
                                    </div>
                                </div>
                                <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Ativo</div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-dark-800 rounded-lg">
                                <div class="flex items-center">
                                    <i class="bi bi-shield-check text-primary mr-3"></i>
                                    <div>
                                        <p class="text-white font-medium">Verificação em Duas Etapas (2FA)</p>
                                        <p class="text-sm text-gray-400">Camada extra de segurança com código adicional no login</p>
                                    </div>
                                </div>
                                <?php if ($DF): ?>
                                    <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Ativo</div>
                                <?php else: ?>
                                    <button onclick="window.location.href='2FA/'" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                        Ativar
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Preferences -->
            <div class="bg-dark-800 rounded-xl p-8 border border-dark-700 mb-8">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="bi bi-gear text-primary mr-3"></i>
                    Preferências do Usuário
                </h2>

                <div class="bg-dark-700 rounded-lg p-6">
                    <p class="text-gray-300 mb-4">Essas preferências foram configuradas automaticamente para otimizar sua experiência. <span class="text-primary">Essas configurações são fixas e não podem ser alteradas.</span></p>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-dark-800 rounded-lg">
                            <div class="flex items-center">
                                <i class="bi bi-envelope text-primary mr-3"></i>
                                <p class="text-white">Receber alertas e atualizações via e-mail</p>
                            </div>
                            <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Ativo</div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-dark-800 rounded-lg">
                            <div class="flex items-center">
                                <i class="bi bi-file-text text-primary mr-3"></i>
                                <p class="text-white">Concordar com os Termos e Condições de Uso</p>
                            </div>
                            <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Ativo</div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-dark-800 rounded-lg">
                            <div class="flex items-center">
                                <i class="bi bi-share text-primary mr-3"></i>
                                <p class="text-white">Permitir compartilhamento de dados com o Minhas Vacinas</p>
                            </div>
                            <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Ativo</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-900 bg-opacity-20 border border-red-500 border-opacity-30 rounded-xl p-8">
                <h2 class="text-xl font-semibold text-red-400 mb-4 flex items-center">
                    <i class="bi bi-exclamation-triangle mr-3"></i>
                    Zona de Perigo
                </h2>
                <p class="text-gray-300 mb-6">Ações irreversíveis que afetam permanentemente sua conta.</p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="openChangeEmailModal()" class="flex items-center justify-center px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-500 transition-colors">
                        <i class="bi bi-envelope mr-2"></i>
                        Alterar E-mail
                    </button>
                    <button onclick="openDeleteAccountModal()" class="flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors">
                        <i class="bi bi-trash mr-2"></i>
                        Excluir Conta
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-800 rounded-xl p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-dark-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Editar Perfil</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <form id="form-perfil" action="../backend/atualizar-dados.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-white mb-2">Nome</label>
                        <input type="text" id="nome" name="nome" value="<?php echo isset($_SESSION['user_nome']) ? $_SESSION['user_nome'] : ''; ?>" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                    </div>

                    <div>
                        <label for="data_nascimento" class="block text-sm font-medium text-white mb-2">Data de Nascimento</label>
                        <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo !empty($_SESSION['user_nascimento']) ? $_SESSION['user_nascimento'] : ''; ?>" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                    </div>

                    <div>
                        <label for="telefone" class="block text-sm font-medium text-white mb-2">Telefone</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-300 bg-dark-700 border border-r-0 border-dark-600 rounded-l-lg">
                                <img src="/app/public/img/num-img-br.png" alt="BR" class="w-5 h-4 mr-2"> +55
                            </span>
                            <input type="text" id="telefone" name="telefone" value="<?php echo isset($_SESSION['user_telefone']) ? $_SESSION['user_telefone'] : ''; ?>" class="flex-1 px-4 py-3 bg-dark-700 border border-dark-600 rounded-r-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>
                    </div>

                    <?php if (empty($_SESSION['user_cpf'])): ?>
                        <div>
                            <label for="cpf" class="block text-sm font-medium text-white mb-2">CPF</label>
                            <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="genero" class="block text-sm font-medium text-white mb-2">Gênero</label>
                        <select id="genero" name="genero" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                            <option value="Não Informado" <?php echo (isset($_SESSION['user_genero']) && $_SESSION['user_genero'] === 'Não Informado') ? 'selected' : ''; ?>>Não Informado</option>
                            <option value="Masculino" <?php echo (isset($_SESSION['user_genero']) && $_SESSION['user_genero'] === 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Feminino" <?php echo (isset($_SESSION['user_genero']) && $_SESSION['user_genero'] === 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
                            <option value="Outro" <?php echo (isset($_SESSION['user_genero']) && $_SESSION['user_genero'] === 'Outro') ? 'selected' : ''; ?>>Outro</option>
                        </select>
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-white mb-2">Estado</label>
                        <select id="estado" name="estado" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                            <option value="" disabled selected>Selecione um estado</option>
                            <option value="AC" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'AC') ? 'selected' : ''; ?>>Acre</option>
                            <option value="AL" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'AL') ? 'selected' : ''; ?>>Alagoas</option>
                            <option value="AP" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'AP') ? 'selected' : ''; ?>>Amapá</option>
                            <option value="AM" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'AM') ? 'selected' : ''; ?>>Amazonas</option>
                            <option value="BA" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'BA') ? 'selected' : ''; ?>>Bahia</option>
                            <option value="CE" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'CE') ? 'selected' : ''; ?>>Ceará</option>
                            <option value="DF" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'DF') ? 'selected' : ''; ?>>Distrito Federal</option>
                            <option value="ES" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'ES') ? 'selected' : ''; ?>>Espírito Santo</option>
                            <option value="GO" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'GO') ? 'selected' : ''; ?>>Goiás</option>
                            <option value="MA" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'MA') ? 'selected' : ''; ?>>Maranhão</option>
                            <option value="MT" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'MT') ? 'selected' : ''; ?>>Mato Grosso</option>
                            <option value="MS" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'MS') ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                            <option value="MG" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'MG') ? 'selected' : ''; ?>>Minas Gerais</option>
                            <option value="PA" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PA') ? 'selected' : ''; ?>>Pará</option>
                            <option value="PB" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PB') ? 'selected' : ''; ?>>Paraíba</option>
                            <option value="PR" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PR') ? 'selected' : ''; ?>>Paraná</option>
                            <option value="PE" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PE') ? 'selected' : ''; ?>>Pernambuco</option>
                            <option value="PI" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PI') ? 'selected' : ''; ?>>Piauí</option>
                            <option value="RJ" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
                            <option value="RN" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RN') ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                            <option value="RS" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RS') ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                            <option value="RO" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RO') ? 'selected' : ''; ?>>Rondônia</option>
                            <option value="RR" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RR') ? 'selected' : ''; ?>>Roraima</option>
                            <option value="SC" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'SC') ? 'selected' : ''; ?>>Santa Catarina</option>
                            <option value="SP" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'SP') ? 'selected' : ''; ?>>São Paulo</option>
                            <option value="SE" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'SE') ? 'selected' : ''; ?>>Sergipe</option>
                            <option value="TO" <?php echo (isset($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'TO') ? 'selected' : ''; ?>>Tocantins</option>
                        </select>
                    </div>

                    <!-- <div>
                        <label for="cidade" class="block text-sm font-medium text-white mb-2">Cidade</label>
                        <select id="cidade" name="cidade" class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                            <option value="">Selecione uma cidade</option>
                        </select>
                    </div> -->
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" class="flex-1 flex items-center justify-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        <i class="bi bi-check-circle mr-2"></i>
                        Salvar Alterações
                    </button>
                    <button type="button" onclick="closeEditModal()" class="flex-1 flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium">
                        <i class="bi bi-x-circle mr-2"></i>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Email Modal -->
    <div id="changeEmailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-800 rounded-xl p-8 max-w-md w-full border border-dark-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Alterar E-mail</h3>
                <button onclick="closeChangeEmailModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <p class="text-gray-300 mb-6">Um código será enviado para o novo e-mail para confirmação.</p>

            <form id="form-alterar-email" action="../backend/alterar-email.php" method="post" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-white mb-2">Novo E-mail</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        <i class="bi bi-envelope mr-2"></i>
                        Enviar Código
                    </button>
                    <button type="button" onclick="openConfirmEmailModal()" class="flex-1 flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium">
                        <i class="bi bi-check-circle mr-2"></i>
                        Já tenho código
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm Email Modal -->
    <div id="confirmEmailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-800 rounded-xl p-8 max-w-md w-full border border-dark-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Confirmar E-mail</h3>
                <button onclick="closeConfirmEmailModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <p class="text-gray-300 mb-6">Digite o código enviado para seu novo e-mail.</p>

            <form id="form-confirmar-email" action="../backend/confirmar-email.php" method="post" class="space-y-6">
                <div>
                    <label for="codigo" class="block text-sm font-medium text-white mb-2">Código de Confirmação</label>
                    <input type="text" id="codigo" name="codigo" required class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                        <i class="bi bi-check-circle mr-2"></i>
                        Confirmar
                    </button>
                    <button type="button" onclick="backToChangeEmail()" class="flex-1 flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium">
                        <i class="bi bi-arrow-left mr-2"></i>
                        Voltar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteAccountModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-800 rounded-xl p-8 max-w-md w-full border border-red-500 border-opacity-30">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-red-400">Excluir Conta</h3>
                <button onclick="closeDeleteAccountModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <div class="bg-red-900 bg-opacity-20 border border-red-500 border-opacity-30 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <i class="bi bi-exclamation-triangle text-red-400 text-xl mr-3 mt-1"></i>
                    <div>
                        <p class="text-red-400 font-medium mb-2">Atenção: Esta ação é irreversível!</p>
                        <p class="text-gray-300 text-sm">Todos os seus dados serão permanentemente excluídos e não poderão ser recuperados.</p>
                    </div>
                </div>
            </div>

            <p class="text-gray-300 mb-6">Um código será enviado para seu e-mail para confirmar a exclusão.</p>

            <form id="form-excluir-conta" action="../backend/excluir-conta.php" method="post" class="space-y-6">
                <div>
                    <label for="email_delete" class="block text-sm font-medium text-white mb-2">Confirme seu E-mail</label>
                    <input type="email" id="email_delete" name="email" required class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors font-medium">
                        <i class="bi bi-envelope mr-2"></i>
                        Enviar Código
                    </button>
                    <button type="button" onclick="openConfirmDeleteModal()" class="flex-1 flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium">
                        <i class="bi bi-check-circle mr-2"></i>
                        Já tenho código
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div id="confirmDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-800 rounded-xl p-8 max-w-md w-full border border-red-500 border-opacity-30">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-red-400">Confirmar Exclusão</h3>
                <button onclick="closeConfirmDeleteModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <div class="bg-red-900 bg-opacity-20 border border-red-500 border-opacity-30 rounded-lg p-4 mb-6">
                <p class="text-red-400 font-medium text-center">ÚLTIMA CHANCE!</p>
                <p class="text-gray-300 text-sm text-center mt-2">Esta ação não pode ser desfeita.</p>
            </div>

            <form id="form-confirmar-exclusao" action="../backend/confirmar-exclusao.php" method="post" class="space-y-6">
                <div>
                    <label for="codigo_delete" class="block text-sm font-medium text-white mb-2">Código de Confirmação</label>
                    <input type="text" id="codigo_delete" name="codigo" required class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors font-medium">
                        <i class="bi bi-trash mr-2"></i>
                        EXCLUIR CONTA
                    </button>
                    <button type="button" onclick="backToDeleteAccount()" class="flex-1 flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium">
                        <i class="bi bi-arrow-left mr-2"></i>
                        Voltar
                    </button>
                </div>
            </form>
        </div>
    </div>

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

        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openChangeEmailModal() {
            document.getElementById('changeEmailModal').classList.remove('hidden');
        }

        function closeChangeEmailModal() {
            document.getElementById('changeEmailModal').classList.add('hidden');
        }

        function openConfirmEmailModal() {
            closeChangeEmailModal();
            document.getElementById('confirmEmailModal').classList.remove('hidden');
        }

        function closeConfirmEmailModal() {
            document.getElementById('confirmEmailModal').classList.add('hidden');
        }

        function backToChangeEmail() {
            closeConfirmEmailModal();
            openChangeEmailModal();
        }

        function openDeleteAccountModal() {
            document.getElementById('deleteAccountModal').classList.remove('hidden');
        }

        function closeDeleteAccountModal() {
            document.getElementById('deleteAccountModal').classList.add('hidden');
        }

        function openConfirmDeleteModal() {
            closeDeleteAccountModal();
            document.getElementById('confirmDeleteModal').classList.remove('hidden');
        }

        function closeConfirmDeleteModal() {
            document.getElementById('confirmDeleteModal').classList.add('hidden');
        }

        function backToDeleteAccount() {
            closeConfirmDeleteModal();
            openDeleteAccountModal();
        }

        // IBGE API for cities
        document.getElementById('estado').addEventListener('change', async function() {
            const estado = this.value;
            const cidadeSelect = document.getElementById('cidade');

            cidadeSelect.innerHTML = '<option value="">Carregando...</option>';

            try {
                const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estado}/municipios`);
                const cidades = await response.json();

                cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
                cidades.forEach(cidade => {
                    cidadeSelect.innerHTML += `<option value="${cidade.nome}">${cidade.nome}</option>`;
                });
            } catch (error) {
                cidadeSelect.innerHTML = '<option value="">Erro ao carregar cidades</option>';
            }
        });

        // Formatação do telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let telefone = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número
            if (telefone.length <= 10) {
                telefone = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            } else {
                telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            }
            e.target.value = telefone;
        });

        // Formatação do CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let cpf = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número
            if (cpf.length <= 11) {
                cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }
            e.target.value = cpf;
        });
    </script>
    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/script.js"></script>
</body>

</html>