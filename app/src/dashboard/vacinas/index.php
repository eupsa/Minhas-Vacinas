<?php
session_start();
require_once '../../utils/ConexaoDB.php';
require_once '../../utils/UsuarioAuth.php';

Auth($pdo);

$sql = $pdo->prepare("SELECT * FROM vacina WHERE id_usuario = :id_usuario ORDER BY data_aplicacao DESC");
$sql->bindValue(':id_usuario', $_SESSION['user_id']);
$sql->execute();

$vacinas = $sql->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['vacinas'] = $vacinas ?: [];
?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vacinas - Gerenciar Vacinas</title>

    <!-- Meta Tags -->
    <meta name="description" content="Gerencie suas vacinas - visualize, edite e organize seu histórico de vacinação.">
    <meta name="keywords" content="vacinas, histórico, gerenciar, saúde">
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
                        'scale-in': 'scaleIn 0.6s ease-out',
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
                        },
                        scaleIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.8)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
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

        /* Card Hover Effects */
        .vaccine-card {
            transition: all 0.3s ease;
        }

        .vaccine-card:hover {
            transform: translateY(-4px);
            border-color: #007bff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
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
                        <p class="text-xs text-blue-100">Gerenciar Vacinas</p>
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
                    <a href="" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-syringe text-lg"></i>
                        <span>Minhas Vacinas</span>
                    </a>
                    <a href="../perfil/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-user text-lg"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="../perfil/dispositivos/" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
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
        <div class="container mx-auto px-6 py-8">
            <!-- Header Section -->
            <div class="mb-8 animate-fade-in-up">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Minhas Vacinas</h1>
                        <p class="text-gray-400">Registre e visualize suas vacinas aplicadas</p>
                    </div>
                    <a href="nova-vacina/" class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 btn-primary rounded-lg text-white font-medium">
                        <i class="fas fa-plus mr-2"></i>
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
                            <i class="fas fa-syringe text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (count($vacinas) > 0): ?>
                    <?php foreach ($vacinas as $vacina): ?>
                        <div id="vacina-<?= $vacina['id_vac'] ?>" class="vaccine-card bg-dark-card rounded-xl overflow-hidden border border-gray-600 group">
                            <div class="w-full h-48 bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center">
                                <?php if (!empty($vacina['path_card'])): ?>
                                    <img src="<?= htmlspecialchars($vacina['path_card'], ENT_QUOTES, 'UTF-8') ?>" alt="Vacina" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                <?php else: ?>
                                    <i class="fas fa-syringe text-white text-4xl"></i>
                                <?php endif; ?>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-white mb-4"><?= htmlspecialchars($vacina['nome_vac'], ENT_QUOTES, 'UTF-8') ?></h3>
                                <?php if (!empty($vacina['obs'])): ?>
                                    <p class="text-gray-400 text-sm mb-4 leading-relaxed"><?= nl2br(htmlspecialchars($vacina['obs'], ENT_QUOTES, 'UTF-8')) ?></p>
                                <?php endif; ?>
                                <div class="space-y-3 mb-6">
                                    <?php if (!empty($vacina['data_aplicacao'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-calendar text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Data de Aplicação</span>
                                                <span class="font-medium"><?= date('d/m/Y', strtotime($vacina['data_aplicacao'])) ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($vacina['proxima_dose'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-calendar-plus text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Próxima Dose</span>
                                                <span class="font-medium"><?= date('d/m/Y', strtotime($vacina['proxima_dose'])) ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($vacina['local_aplicacao'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-map-marker-alt text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Local</span>
                                                <span class="font-medium"><?= htmlspecialchars($vacina['local_aplicacao'], ENT_QUOTES, 'UTF-8') ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($vacina['dose'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-syringe text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Dose</span>
                                                <span class="font-medium"><?= htmlspecialchars($vacina['dose'], ENT_QUOTES, 'UTF-8') ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($vacina['lote'])): ?>
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-hashtag text-primary mr-3 text-lg"></i>
                                            <div>
                                                <span class="text-xs text-gray-400 block">Lote</span>
                                                <span class="font-medium"><?= htmlspecialchars($vacina['lote'], ENT_QUOTES, 'UTF-8') ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 pt-4 border-t border-gray-600">
                                    <!-- Excluir -->
                                    <form method="POST" action="../backend/excluir-vacina.php" id="form-excluir-vacina">
                                        <input type="hidden" name="id_vac" value="<?= htmlspecialchars($vacina['id_vac'], ENT_QUOTES, 'UTF-8') ?>">
                                        <button type="submit" class="flex items-center w-full sm:w-auto px-3 py-2 text-red-400 hover:text-red-300 hover:bg-red-500 hover:bg-opacity-20 rounded-lg transition-colors">
                                            <i class="fas fa-trash mr-2"></i>Excluir
                                        </button>
                                    </form>

                                    <!-- PDF -->
                                    <button type="button"
                                        onclick="gerarCertificadoPDF('<?= $vacina['id_vac'] ?>')"
                                        class="flex items-center w-full sm:w-auto px-3 py-2 text-blue-400 hover:text-blue-300 hover:bg-blue-600 hover:bg-opacity-20 rounded-lg transition-colors">
                                        <i class="fa-solid fa-file-pdf mr-2"></i>PDF
                                    </button>

                                    <!-- Compartilhar -->
                                    <button type="button"
                                        class="flex items-center w-full sm:w-auto px-3 py-2 text-green-400 hover:text-green-300 hover:bg-green-600 hover:bg-opacity-20 rounded-lg transition-colors">
                                        <i class="fas fa-share-alt mr-2"></i>Compartilhar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full text-center text-gray-400 py-8">
                        Nenhuma vacina registrada até o momento.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <div id="certificado-<?= $vacina['id_vac'] ?>" class="hidden" style="
  width: 800px;
  margin: 0 auto;
  background: #f9fafb;
  color: #1f2937;
  padding: 50px 60px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 17px;
  line-height: 1.6;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.12);
  border: 1px solid #e5e7eb;
  box-sizing: border-box;
">
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>

        <!-- LOGO -->
        <div style="text-align: center; margin-bottom: 40px;">
            <img src="/app/public/img/logo-head.png" alt="Logo" style="height: 70px; object-fit: contain; margin-bottom: 15px;">
            <h1 style="font-size: 34px; font-weight: 700; margin: 0; color: #111827;">Certificado de Vacinação</h1>
            <p style="color: #6b7280; font-size: 15px; margin-top: 8px;">Comprovante de dose registrada no sistema Minhas Vacinas</p>
        </div>

        <!-- INFORMAÇÕES DA VACINA -->
        <div style="margin-bottom: 50px; text-align: left; color: #374151;">
            <p style="margin: 8px 0;"><strong style="color:#111827;">Nome da Vacina:</strong> <?= htmlspecialchars($vacina['nome_vac']) ?></p>
            <p style="margin: 8px 0;"><strong style="color:#111827;">Data de Aplicação:</strong> <?= date('d/m/Y', strtotime($vacina['data_aplicacao'])) ?></p>
            <p style="margin: 8px 0;"><strong style="color:#111827;">Próxima Dose:</strong> <?= date('d/m/Y', strtotime($vacina['proxima_dose'])) ?></p>
            <p style="margin: 8px 0;"><strong style="color:#111827;">Local da Aplicação:</strong> <?= htmlspecialchars($vacina['local_aplicacao']) ?></p>
            <p style="margin: 8px 0;"><strong style="color:#111827;">Dose:</strong> <?= htmlspecialchars($vacina['dose']) ?></p>
            <p style="margin: 8px 0;"><strong style="color:#111827;">Lote:</strong> <?= htmlspecialchars($vacina['lote']) ?></p>
        </div>

        <!-- QR CODE -->
        <div style="text-align: center; margin-bottom: 50px;">
            <div style="display: inline-block; background: white; padding: 8px; border: 2px solid #e5e7eb; border-radius: 12px;">
                <img src="qrcode_localhost.png" alt="QR Code" style="width: 150px; height: 150px; object-fit: contain;">
            </div>
            <p style="font-size: 13px; color: #6b7280; margin-top: 12px;">Escaneie para verificar a validade no sistema</p>
        </div>


        <!-- ASSINATURA -->
        <div style="text-align: center; margin-bottom: 30px;">
            <p style="font-size: 16px; font-weight: 700; margin-bottom: 4px; color: #374151;">
                <?= htmlspecialchars($_SESSION['user_nome'] ?? 'Nome do Usuário') ?>
            </p>
            <p style="font-size: 14px; color: #6b7280;">
                <?= htmlspecialchars($_SESSION['user_email'] ?? 'email@usuario.com') ?>
            </p>
        </div>

        <!-- RODAPÉ -->
        <div style="text-align: center; font-size: 13px; color: #9ca3af; border-top: 1px solid #d1d5db; padding-top: 14px;">
            Documento gerado pelo sistema <strong>Minhas Vacinas</strong><br>
        </div>
        <div style="text-align: center; font-size: 12px; color: #888; margin-bottom: 20px;">
            Exportado em: <?= date('d/m/Y \à\s H:i:s') ?>
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


        function gerarCertificadoPDF(id) {
            const el = document.getElementById('certificado-' + id);
            el.classList.remove('hidden'); // mostra antes de capturar

            const opt = {
                margin: [20, 20, 20, 20],
                filename: `certificado-vacina-${id}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 1.5,
                    useCORS: true,
                    scrollX: 0,
                    scrollY: 0,
                    windowWidth: document.body.scrollWidth,
                    windowHeight: document.body.scrollHeight,
                },
                jsPDF: {
                    unit: 'pt',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().set(opt).from(el).save().then(() => {
                el.classList.add('hidden'); // esconde depois
            });
        }
    </script>

    <script type="module" src="/app/public/js/sweetalert-config.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="excluir.js"></script>
</body>

</html>