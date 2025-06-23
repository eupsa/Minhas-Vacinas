<?php
require_once '../src/utils/ConexaoDB.php';

// $uri = $_SERVER['REQUEST_URI'];
// $partes = explode('/', trim($uri, '/'));
// $uuid = end($partes);

$uuid = $_GET['uuid'];

$sql = $pdo->prepare("SELECT * FROM vacinas_compartilhadas WHERE uuid = :uuid");
$sql->bindValue(':uuid', $uuid);
$sql->execute();

if ($sql->rowCount() > 0) {
    $vacinasCompartilhadas = $sql->fetch();

    $sql = $pdo->prepare("SELECT * FROM vacina WHERE id_vac = :id");
    $sql->bindValue(':id', $vacinasCompartilhadas['id_vac_FK']);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $vacina = $sql->fetch();

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
        $sql->bindValue(':id', $vacina['id_usuario']);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $usuario = $sql->fetch();
        }
    }
} else {
    header("Location: /");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacina Compartilhada - Minhas Vacinas</title>

    <!-- Meta Tags -->
    <meta name="description" content="Visualize informações da vacina compartilhada pelo usuário.">
    <meta name="keywords" content="vacina, compartilhar, cartão de vacinação, saúde">
    <meta name="theme-color" content="#007bff">

    <!-- Favicon -->
    <link rel="icon" href="../public/img/img-web.png" type="image/x-icon">

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
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
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
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        scaleIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.9)'
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

        /* Navbar Styles */
        .navbar {
            background: rgba(0, 123, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Vaccine Card Styles */
        .vaccine-card {
            background: linear-gradient(135deg, #252b3d 0%, #1a1f2e 100%);
            border: 1px solid rgba(0, 123, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .vaccine-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
            border-color: rgba(0, 123, 255, 0.4);
        }

        /* Status Badge */
        .status-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        /* Verification Badge */
        .verified-badge {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        /* Print Styles */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .vaccine-card {
                background: white !important;
                border: 2px solid #007bff !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body class="gradient-bg text-white font-inter min-h-screen">
    <!-- Navbar -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-opacity-20 rounded-lg flex items-center justify-center">
                        <img src="../public/img/logo-head.png" alt="">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Minhas Vacinas</h1>
                        <p class="text-xs text-blue-100">Cartão de Vacinação Digital</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- <button onclick="window.print()" class="no-print hidden md:flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-colors">
                        <i class="fas fa-print mr-2"></i>
                        Imprimir
                    </button> -->

                    <button id="shareBtn" class="no-print hidden md:flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-colors">
                        <i class="fas fa-share-alt mr-2"></i>
                        Compartilhar
                    </button>

                    <button id="mobileMenuToggle" class="no-print md:hidden text-white hover:text-blue-200 transition-colors p-2">
                        <i class="fas fa-ellipsis-v text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="no-print hidden md:hidden mt-4 pt-4 border-t border-white border-opacity-20">
                <div class="flex flex-col space-y-2">
                    <button onclick="window.print()" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                        <i class="fas fa-print mr-3"></i>
                        Imprimir Cartão
                    </button>
                    <button id="shareBtnMobile" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                        <i class="fas fa-share-alt mr-3"></i>
                        Compartilhar
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24 pb-12 min-h-screen">
        <div class="container mx-auto px-6">
            <!-- Header Section -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="verified-badge inline-flex items-center px-4 py-2 rounded-full text-white text-sm font-medium mb-4">
                    <i class="fas fa-certificate mr-2"></i>
                    Cartão Verificado
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Cartão de Vacinação Digital</h1>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Este cartão foi compartilhado por <strong class="text-primary"><?= $usuario['nome'] ?></strong> e contém informações verificadas sobre sua vacinação.
                </p>
            </div>

            <!-- Vaccine Card -->
            <div class="max-w-4xl mx-auto animate-scale-in">
                <div class="vaccine-card rounded-2xl p-8 md:p-10">
                    <!-- Card Header -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div class="flex items-center space-x-4 mb-4 md:mb-0">
                            <div class="w-16 h-16 bg-primary bg-opacity-20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-syringe text-primary text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white"><?= $vacina['nome_vac'] ?></h2>
                            </div>
                        </div>

                        <div class="status-badge px-4 py-2 rounded-full text-white text-sm font-medium">
                            <i class="fas fa-check-circle mr-2"></i>
                            Vacinado
                        </div>
                    </div>

                    <!-- Vaccine Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-calendar-alt text-primary mr-3"></i>
                                <h3 class="text-white font-semibold">Data de Aplicação</h3>
                            </div>
                            <?php
                            $data = new IntlDateFormatter(
                                'pt_BR',
                                IntlDateFormatter::LONG,
                                IntlDateFormatter::NONE,
                                'America/Sao_Paulo',
                                IntlDateFormatter::GREGORIAN
                            );

                            $dataFormatada = $data->format(new DateTime($vacina['data_aplicacao']));
                            ?>
                            <p class="text-gray-300 text-lg font-medium"><?= $dataFormatada ?></p>
                        </div>

                        <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-clock text-primary mr-3"></i>
                                <h3 class="text-white font-semibold">Próxima Dose</h3>
                            </div>
                            <p class="text-gray-300 text-lg font-medium">
                                <?php
                                if (!empty($vacina['proxima_dose'])) {
                                    setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR');
                                    echo strftime('%d de %B, %Y', strtotime($vacina['proxima_dose']));
                                } else {
                                    echo 'Não definida';
                                }
                                ?>
                            </p>
                        </div>

                        <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-map-marker-alt text-primary mr-3"></i>
                                <h3 class="text-white font-semibold">Local de Aplicação</h3>
                            </div>
                            <p class="text-gray-300 text-lg font-medium"><?= $vacina['local_aplicacao'] ?></p>
                        </div>

                        <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-vial text-primary mr-3"></i>
                                <h3 class="text-white font-semibold">Dose</h3>
                            </div>
                            <p class="text-gray-300 text-lg font-medium"><?= $vacina['dose'] ?></p>
                        </div>

                        <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-barcode text-primary mr-3"></i>
                                <h3 class="text-white font-semibold">Lote</h3>
                            </div>
                            <p class="text-gray-300 text-lg font-medium"><?= $vacina['lote'] ?></p>
                        </div>

                        <div class="bg-dark bg-opacity-50 rounded-xl p-6">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-vial text-primary mr-3"></i>
                                <h3 class="text-white font-semibold">Tipo da Vacina</h3>
                            </div>
                            <p class="text-gray-300 text-lg font-medium">
                                <?= !empty($vacina['tipo']) ? htmlspecialchars($vacina['tipo']) : 'Não informado' ?>
                            </p>
                        </div>
                    </div>

                    <!-- Vaccine Description -->
                    <div class="bg-dark bg-opacity-50 rounded-xl p-6 mb-8">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-info-circle text-primary mr-3"></i>
                            <h3 class="text-white font-semibold">Descrição da Vacina</h3>
                        </div>
                        <p class="text-gray-300 leading-relaxed">
                            <?= $vacina['obs'] ?>
                        </p>
                    </div>

                    <!-- User Info -->
                    <div class="border-t border-gray-600 pt-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <p class="text-white font-semibold"><?= $usuario['nome'] ?></p>
                                    <p class="text-gray-400 text-sm">Compartilhou este cartão</p>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-gray-400 text-sm">Compartilhado em</p>
                                <p class="text-white font-medium">
                                    <?php
                                    setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR');
                                    $dataHora = $vacinasCompartilhadas['data_compartilhamento'] ?? date('Y-m-d H:i:s');
                                    echo strftime('%d de %B, %Y às %H:%M', strtotime($dataHora));
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="no-print max-w-4xl mx-auto mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <!-- <button onclick="window.print()" class="btn-primary flex items-center justify-center px-8 py-3 rounded-lg text-white font-medium">
                    <i class="fas fa-download mr-2"></i>
                    Salvar como PDF
                </button> -->

                <button id="shareMainBtn" class="flex items-center justify-center px-8 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors font-medium">
                    <i class="fas fa-share-alt mr-2"></i>
                    Compartilhar
                </button>

                <a href=/app/src/auth/cadastro/" class="flex items-center justify-center px-8 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors font-medium">
                    <i class="fas fa-home mr-2"></i>
                    Criar Minha Conta
                </a>
            </div>

        </div>
    </main>

    <!-- Share Modal -->
    <div id="shareModal" class="no-print fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-dark-card rounded-xl p-8 max-w-md w-full border border-gray-600">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Compartilhar Cartão</h3>
                <button onclick="closeShareModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div class="bg-dark rounded-lg p-4">
                    <label class="block text-sm font-medium text-white mb-2">Link para compartilhar:</label>
                    <div class="flex">
                        <input type="text" id="shareLink" value="https://minhasvacinas.pedrotech.cloud/app/vacinas/<?= $uuid ?>" readonly class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-l-lg text-white text-sm">
                        <button onclick="copyLink()" class="px-4 py-2 bg-primary text-white rounded-r-lg hover:bg-primary-dark transition-colors">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Set current date
            document.getElementById('shareDate').textContent = new Date().toLocaleDateString('pt-BR', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        });

        // Share Modal Functions
        function openShareModal() {
            document.getElementById('shareModal').classList.remove('hidden');
        }

        function closeShareModal() {
            document.getElementById('shareModal').classList.add('hidden');
        }

        // Share button event listeners
        document.getElementById('shareBtn').addEventListener('click', openShareModal);
        document.getElementById('shareBtnMobile').addEventListener('click', openShareModal);
        document.getElementById('shareMainBtn').addEventListener('click', openShareModal);

        // Copy link function
        function copyLink() {
            const shareLink = document.getElementById('shareLink');
            shareLink.select();
            shareLink.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(shareLink.value);

            // Show feedback
            const button = event.target.closest('button');
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.classList.add('bg-green-600');

            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-green-600');
            }, 2000);
        }

        // Share functions
        function shareWhatsApp() {
            const text = "Confira meu cartão de vacinação digital: " + document.getElementById('shareLink').value;
            window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
        }

        function shareEmail() {
            const subject = "Cartão de Vacinação Digital - Maria Silva";
            const body = "Olá!\n\nCompartilho com você meu cartão de vacinação digital.\n\nAcesse: " + document.getElementById('shareLink').value + "\n\nAtenciosamente,\nMaria Silva";
            window.open(`mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`);
        }

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeShareModal();
            }
        });

        // Print optimization
        window.addEventListener('beforeprint', function() {
            document.title = 'Cartão de Vacinação - Maria Silva - COVID-19';
        });
    </script>
</body>

</html>