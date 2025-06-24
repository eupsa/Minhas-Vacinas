<?php
session_start();
require_once '../../utils/ConexaoDB.php';
require_once '../../utils/UsuarioAuth.php';

Auth($pdo);
Gerar_Session($pdo);

$sql = $pdo->prepare("SELECT * FROM 2fa WHERE email = :email");
$sql->bindValue(':email', $_SESSION['user_email']);
$sql->execute();

if ($sql->rowCount() > 0) {
    $doisFatores = TRUE;
} else {
    $doisFatores = FALSE;
}
?>
<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Perfil</title>

    <!-- Meta Tags -->
    <meta name="description" content="Gerencie seu perfil e configurações de segurança no Minhas Vacinas.">
    <meta name="keywords" content="perfil, configurações, segurança, dados pessoais">
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
                        'spin': 'spin 1s linear infinite',
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

        /* Code Input Styles */
        .code-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #374151;
            border-radius: 8px;
            background: #1f2937;
            color: white;
            transition: all 0.3s ease;
        }

        .code-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .code-input.filled {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
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
                        <p class="text-xs text-blue-100">Perfil</p>
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
                    <a href="../" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-home text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="../vacinas/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-syringe text-lg"></i>
                        <span>Minhas Vacinas</span>
                    </a>
                    <a href="" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-user text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="dispositivos/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
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
                            <p class="text-sm font-medium text-white truncate"><?php echo ($_SESSION['user_nome']) ? explode(' ', $_SESSION['user_nome'])[0] : 'Usuário'; ?></p>
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
                <h1 class="text-3xl font-bold text-white mb-2">Meu Perfil</h1>
                <p class="text-gray-400">Gerencie suas informações pessoais e configurações de segurança</p>
            </div>

            <!-- User Data Card -->
            <div class="bg-dark-card rounded-xl p-8 border border-gray-600 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-user-circle text-primary mr-3"></i>
                        Dados Pessoais
                    </h2>
                    <button onclick="openEditModal()" class="flex items-center px-4 py-2 btn-primary rounded-lg text-white">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Nome</label>
                        <p class="text-white font-medium"><?php echo ($_SESSION['user_nome']) ? $_SESSION['user_nome'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">E-mail</label>
                        <p class="text-white font-medium"><?php echo ($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Telefone</label>
                        <p class="text-white font-medium">+55 <?php echo ($_SESSION['user_telefone']) ? $_SESSION['user_telefone'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Data de Nascimento</label>
                        <p class="text-white font-medium"><?php echo ($_SESSION['user_nascimento']) ? $_SESSION['user_nascimento'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Gênero</label>
                        <p class="text-white font-medium"><?php echo ($_SESSION['user_genero']) ? $_SESSION['user_genero'] : 'Não informado'; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Estado</label>
                        <p class="text-white font-medium"><?php echo ($_SESSION['user_estado']) ? $_SESSION['user_estado'] : 'Não informado'; ?></p>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="bg-dark-card rounded-xl p-8 border border-gray-600 mb-8">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-shield-alt text-primary mr-3"></i>
                    Segurança da Conta
                </h2>

                <div class="space-y-6">
                    <div class="bg-dark rounded-lg p-6">
                        <p class="text-gray-300 mb-4">A segurança da sua conta é nossa prioridade. <span class="text-primary">Mantenha suas informações de login e senha protegidas.</span></p>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-dark-card rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                                    <div>
                                        <p class="text-white font-medium">Confirmação de novo acesso</p>
                                        <p class="text-sm text-gray-400">Ativa a confirmação do novo acesso de dispositivos</p>
                                    </div>
                                </div>
                                <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Ativo</div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-dark-card rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-shield-check text-primary mr-3"></i>
                                    <div>
                                        <p class="text-white font-medium">Verificação em Duas Etapas (2FA)</p>
                                        <p class="text-sm text-gray-400">Camada extra de segurança com código adicional no login</p>
                                    </div>
                                </div>
                                <?php if ($doisFatores): ?>
                                    <form action="2FA/desativar.php" method="POST" onsubmit="return confirm('Tem certeza que deseja desativar a verificação em duas etapas?');">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors inline-flex items-center">
                                            <i class="fas fa-ban mr-2"></i> Desativar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <a href="2FA/" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center">
                                        <i class="fas fa-shield-alt mr-2"></i> Ativar
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- New Security Actions -->
                            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-600">
                                <button id="btnAlterarEmail" class="flex items-center justify-center px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-500 transition-colors">
                                    <i class="fas fa-envelope mr-2"></i>
                                    Alterar E-mail
                                </button>
                                <a href="../../auth/esqueceu-senha/" class="flex items-center justify-center px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-500 transition-colors">
                                    <i class="fas fa-key mr-2"></i>
                                    Alterar Senha
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Preferences -->
            <div class="bg-dark-card rounded-xl p-8 border border-gray-600 mb-8">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-cog text-primary mr-3"></i>
                    Preferências do Usuário
                </h2>

                <div class="bg-dark rounded-lg p-6">
                    <p class="text-gray-300 mb-4">Essas preferências foram configuradas automaticamente para otimizar sua experiência. <span class="text-primary">Essas configurações são fixas e não podem ser alteradas.</span></p>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-dark-card rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-primary mr-3"></i>
                                <p class="text-white">Receber alertas e atualizações via e-mail</p>
                            </div>
                            <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Ativo</div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-dark-card rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-file-text text-primary mr-3"></i>
                                <p class="text-white">Concordar com os Termos e Condições de Uso</p>
                            </div>
                            <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Ativo</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-card rounded-xl p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-gray-600">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Editar Perfil</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="form-perfil" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-white mb-2">Nome</label>
                        <input type="text" id="nome" name="nome" value="<?= $_SESSION['user_nome'] ?>" class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                    </div>
                    <div>
                        <label for="data_nascimento" class="block text-sm font-medium text-white mb-2">Data de Nascimento</label>
                        <input
                            type="date"
                            id="data_nascimento"
                            name="data_nascimento"
                            value="<?php echo isset($_SESSION['user_nascimento']) ? date('Y-m-d', strtotime($_SESSION['user_nascimento'])) : ''; ?>"
                            class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                    </div>

                    <div>
                        <label for="telefone" class="block text-sm font-medium text-white mb-2">Telefone</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-300 bg-dark border border-r-0 border-gray-600 rounded-l-lg">
                                +55
                            </span>
                            <input type="text" id="telefone" name="telefone" value="<?php echo ($_SESSION['user_telefone']) ?>" class="flex-1 px-4 py-3 bg-dark border border-gray-600 rounded-r-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        </div>
                    </div>

                    <div>
                        <label for="genero" class="block text-sm font-medium text-white mb-2">Gênero</label>
                        <select id="genero" name="genero" class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                            <option value="Não Informado" <?php echo (($_SESSION['user_genero']) && $_SESSION['user_genero'] === 'Não Informado') ? 'selected' : ''; ?>>Não Informado</option>
                            <option value="Masculino" <?php echo (($_SESSION['user_genero']) && $_SESSION['user_genero'] === 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Feminino" <?php echo (($_SESSION['user_genero']) && $_SESSION['user_genero'] === 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
                            <option value="Outro" <?php echo (($_SESSION['user_genero']) && $_SESSION['user_genero'] === 'Outro') ? 'selected' : ''; ?>>Outro</option>
                        </select>
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-white mb-2">Estado</label>
                        <select id="estado" name="estado" class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                            <option value="" disabled selected>Selecione um estado</option>
                            <option value="AC" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'AC') ? 'selected' : ''; ?>>Acre</option>
                            <option value="AL" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'AL') ? 'selected' : ''; ?>>Alagoas</option>
                            <option value="AP" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'AP') ? 'selected' : ''; ?>>Amapá</option>
                            <option value="AM" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'AM') ? 'selected' : ''; ?>>Amazonas</option>
                            <option value="BA" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'BA') ? 'selected' : ''; ?>>Bahia</option>
                            <option value="CE" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'CE') ? 'selected' : ''; ?>>Ceará</option>
                            <option value="DF" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'DF') ? 'selected' : ''; ?>>Distrito Federal</option>
                            <option value="ES" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'ES') ? 'selected' : ''; ?>>Espírito Santo</option>
                            <option value="GO" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'GO') ? 'selected' : ''; ?>>Goiás</option>
                            <option value="MA" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'MA') ? 'selected' : ''; ?>>Maranhão</option>
                            <option value="MT" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'MT') ? 'selected' : ''; ?>>Mato Grosso</option>
                            <option value="MS" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'MS') ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                            <option value="MG" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'MG') ? 'selected' : ''; ?>>Minas Gerais</option>
                            <option value="PA" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PA') ? 'selected' : ''; ?>>Pará</option>
                            <option value="PB" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PB') ? 'selected' : ''; ?>>Paraíba</option>
                            <option value="PR" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PR') ? 'selected' : ''; ?>>Paraná</option>
                            <option value="PE" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PE') ? 'selected' : ''; ?>>Pernambuco</option>
                            <option value="PI" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'PI') ? 'selected' : ''; ?>>Piauí</option>
                            <option value="RJ" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
                            <option value="RN" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RN') ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                            <option value="RS" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RS') ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                            <option value="RO" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RO') ? 'selected' : ''; ?>>Rondônia</option>
                            <option value="RR" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'RR') ? 'selected' : ''; ?>>Roraima</option>
                            <option value="SC" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'SC') ? 'selected' : ''; ?>>Santa Catarina</option>
                            <option value="SP" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'SP') ? 'selected' : ''; ?>>São Paulo</option>
                            <option value="SE" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'SE') ? 'selected' : ''; ?>>Sergipe</option>
                            <option value="TO" <?php echo (($_SESSION['user_estado']) && $_SESSION['user_estado'] == 'TO') ? 'selected' : ''; ?>>Tocantins</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" class="flex-1 flex items-center justify-center px-6 py-3 btn-primary rounded-lg text-white font-medium">
                        <i class="fas fa-check mr-2"></i>
                        Salvar Alterações
                    </button>
                    <button type="button" onclick="closeEditModal()" class="flex-1 flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Email Modal -->
    <div id="changeEmailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-card rounded-xl p-8 max-w-md w-full border border-gray-600">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Alterar E-mail</h3>
                <button class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Step 1: Email Form -->
            <div id="emailStep1" class="space-y-6">
                <p class="text-gray-300 mb-6">Um código será enviado para o novo e-mail para confirmação.</p>

                <form id="changeEmailForm" class="space-y-6" method="POST" action="../backend/alterar-email.php">
                    <div>
                        <label for="currentEmail" class="block text-sm font-medium text-white mb-2">E-mail Atual</label>
                        <input type="email" id="currentEmail" value="<?= $_SESSION['user_email'] ?>" disabled class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-gray-300 cursor-not-allowed">
                    </div>

                    <div>
                        <label for="newEmail" class="block text-sm font-medium text-white mb-2">Novo E-mail</label>
                        <input type="email" id="newEmail" name="novoEmail" required class="w-full px-4 py-3 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                    </div>

                    <button type="submit" id="sendEmailBtn" class="w-full flex items-center justify-center px-6 py-3 btn-primary rounded-lg text-white font-medium">
                        <span id="sendEmailText">
                            <i class="fas fa-envelope mr-2"></i>
                            Enviar Código
                        </span>
                        <span id="sendEmailLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Enviando...
                        </span>
                    </button>
                    <button
                        type="button"
                        id="btnJaTenhoCodigo"
                        class="w-full flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors">
                        Já tenho um código
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>
            </div>

            <!-- Step 2: Code Verification -->
            <div id="emailStep2" class="hidden space-y-6">
                <div class="text-center">
                    <i class="fas fa-envelope-open text-primary text-3xl mb-4"></i>
                    <h4 class="text-lg font-semibold text-white mb-2">Código Enviado!</h4>
                    <p class="text-gray-300 text-sm">Digite o código de 6 dígitos enviado para <span id="sentToEmail" class="text-primary font-medium"></span></p>
                </div>

                <form id="verifyEmailCodeForm" class="space-y-6" method="POST" action="../backend/confirmar-email.php">
                    <div>
                        <label class="block text-sm font-medium text-white mb-3 text-center">Código de Verificação</label>
                        <div class="flex justify-center space-x-2">
                            <input type="tel" maxlength="1" class="code-input" data-index="0" inputmode="numeric" pattern="\d*">
                            <input type="tel" maxlength="1" class="code-input" data-index="1" inputmode="numeric" pattern="\d*">
                            <input type="tel" maxlength="1" class="code-input" data-index="2" inputmode="numeric" pattern="\d*">
                            <input type="tel" maxlength="1" class="code-input" data-index="3" inputmode="numeric" pattern="\d*">
                            <input type="tel" maxlength="1" class="code-input" data-index="4" inputmode="numeric" pattern="\d*">
                            <input type="tel" maxlength="1" class="code-input" data-index="5" inputmode="numeric" pattern="\d*">
                            <input type="hidden" name="codigo" id="codigoCompleto">

                        </div>
                    </div>

                    <button type="submit" id="verifyEmailBtn" class="w-full flex items-center justify-center px-6 py-3 btn-primary rounded-lg text-white font-medium">
                        <span id="verifyEmailText">
                            <i class="fas fa-check mr-2"></i>
                            Confirmar Alteração
                        </span>
                        <span id="verifyEmailLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Verificando...
                        </span>
                    </button>

                    <button
                        type="button"
                        onclick="backToEmailStep1()"
                        class="w-full flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Voltar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setupCodeInputs(selector) {
            const inputs = document.querySelectorAll(selector);

            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value.replace(/\D/g, '');

                    // Só aceita número
                    e.target.value = value;

                    if (value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    atualizarCodigoCompleto(inputs);
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const digits = paste.replace(/\D/g, '').slice(0, inputs.length);

                    digits.split('').forEach((digit, i) => {
                        if (inputs[i]) {
                            inputs[i].value = digit;
                        }
                    });

                    if (inputs[digits.length - 1]) {
                        inputs[digits.length - 1].focus();
                    }

                    atualizarCodigoCompleto(inputs);
                });
            });
        }

        function atualizarCodigoCompleto(inputs) {
            const codigo = Array.from(inputs).map(i => i.value).join('');
            document.getElementById('codigoCompleto').value = codigo;
        }

        // Chamar essa função com o seletor correto
        setupCodeInputs('.code-input');

        function backToEmailStep1() {
            document.getElementById('emailStep2').classList.add('hidden');
            document.getElementById('emailStep1').classList.remove('hidden');
        }

        document.getElementById('btnJaTenhoCodigo').addEventListener('click', () => {
            document.getElementById('emailStep1').classList.add('hidden');
            document.getElementById('emailStep2').classList.remove('hidden');
        });


        document.getElementById('btnAlterarEmail').addEventListener('click', () => {
            document.getElementById('changeEmailModal').classList.remove('hidden');
        });

        document.getElementById('changeEmailForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const email = document.getElementById('newEmail').value;
            const btn = document.getElementById('sendEmailBtn');
            const text = document.getElementById('sendEmailText');
            const loading = document.getElementById('sendEmailLoading');

            // Mostra o loader
            text.classList.add('hidden');
            loading.classList.remove('hidden');
            btn.disabled = true;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                });

                const data = await response.json();

                if (data.status === true) {
                    // Vai para o passo 2
                    document.getElementById('emailStep1').classList.add('hidden');
                    document.getElementById('emailStep2').classList.remove('hidden');
                    document.getElementById('sentToEmail').textContent = email;
                } else {
                    // Exibe erro do PHP
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: data.msg || 'Falha ao enviar o e-mail.',
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro inesperado',
                    text: 'Não foi possível processar a solicitação.',
                });
            } finally {
                // Restaura o botão
                text.classList.remove('hidden');
                loading.classList.add('hidden');
                btn.disabled = false;
            }
        });
    </script>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-card rounded-xl p-8 max-w-md w-full border border-gray-600">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Alterar Senha</h3>
                <button onclick="closeChangePasswordModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="text-center">
                <i class="fas fa-key text-primary text-3xl mb-4"></i>
                <h4 class="text-lg font-semibold text-white mb-2">Código Enviado!</h4>
                <p class="text-gray-300 text-sm mb-6">Digite o código de 6 dígitos enviado para seu e-mail e defina sua nova senha</p>
            </div>

            <form id="changePasswordForm" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-white mb-3 text-center">Código de Verificação</label>
                    <div class="flex justify-center space-x-2 mb-6">
                        <input type="text" maxlength="1" class="code-input password-code" data-index="0">
                        <input type="text" maxlength="1" class="code-input password-code" data-index="1">
                        <input type="text" maxlength="1" class="code-input password-code" data-index="2">
                        <input type="text" maxlength="1" class="code-input password-code" data-index="3">
                        <input type="text" maxlength="1" class="code-input password-code" data-index="4">
                        <input type="text" maxlength="1" class="code-input password-code" data-index="5">
                    </div>
                </div>

                <div>
                    <label for="newPassword" class="block text-sm font-medium text-white mb-2">Nova Senha</label>
                    <div class="relative">
                        <input type="password" id="newPassword" name="newPassword" required class="w-full px-4 py-3 pr-12 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        <button type="button" onclick="togglePasswordVisibility('newPassword')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                            <i class="fas fa-eye" id="newPasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="confirmNewPassword" class="block text-sm font-medium text-white mb-2">Confirmar Nova Senha</label>
                    <div class="relative">
                        <input type="password" id="confirmNewPassword" name="confirmNewPassword" required class="w-full px-4 py-3 pr-12 bg-dark border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        <button type="button" onclick="togglePasswordVisibility('confirmNewPassword')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                            <i class="fas fa-eye" id="confirmNewPasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <a href="../../auth/esqueceu-senha/" id="changePasswordBtn" class="w-full flex items-center justify-center px-6 py-3 btn-primary rounded-lg text-white font-medium">
                    <span id="changePasswordText">
                        <i class="fas fa-key mr-2"></i>
                        Alterar Senha
                    </span>
                </a>
            </form>
        </div>
    </div>

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

        // Fecha sidebar se clicar em link no mobile
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) closeSidebar();
            });
        });

        // ESC fecha sidebar
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });

        // Input de telefone
        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function(e) {
                let telefone = e.target.value.replace(/\D/g, '');
                if (telefone.length <= 10) {
                    telefone = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                } else {
                    telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                }
                e.target.value = telefone;
            });
        }

        // Logout
        const btnLogout = document.getElementById('btnLogout');
        if (btnLogout) {
            btnLogout.addEventListener('click', () => {
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
                        window.location.href = '/app/src/utils/Sair.php';
                    }
                });
            });
        }
    </script>
    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/script.js"></script>
    <script src="js/confirmar-email.js"></script>
    <script src="js/confirmar-exclusao.js"></script>
    <script src="js/excluir-conta.js"></script>
    <script src="js/mudar-email.js"></script>
</body>

</html>