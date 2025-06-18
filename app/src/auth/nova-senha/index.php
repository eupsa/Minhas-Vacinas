<?php
require '../../scripts/Conexao.php';

$token = $_GET['token'];

$sql = $pdo->prepare("SELECT * FROM esqueceu_senha WHERE token = :token");
$sql->bindValue(':token', $token);
$sql->execute();

if ($sql->rowCount() != 1) {
    header('Location: ../esqueceu-senha/');
}
?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/img-web.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#007bff',
                        'primary-dark': '#0056b3',
                        dark: '#0f172a',
                        'dark-light': '#1e293b',
                        'dark-lighter': '#334155'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'bounce-slow': 'bounce 2s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        slideUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(40px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        glow: {
                            '0%': {
                                boxShadow: '0 0 20px rgba(0, 123, 255, 0.5)'
                            },
                            '100%': {
                                boxShadow: '0 0 30px rgba(0, 123, 255, 0.8)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Minhas Vacinas - Nova Senha</title>
</head>

<body class="bg-dark text-white min-h-screen">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-dark/95 backdrop-blur-md border-b border-primary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="/assets/img/logo-head.png" alt="Logo Vacinas" class="h-10 w-auto">
                        <span class="text-xl font-bold text-primary">Minhas Vacinas</span>
                    </a>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Início</a>
                        <a href="/#nossa-missao" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Sobre</a>
                        <a href="../../ajuda/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">Suporte</a>
                        <a href="../../FAQ/" class="text-white hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">FAQ</a>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="../entrar/" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-full transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>ENTRAR
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white hover:text-primary focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-dark-light border-t border-primary/20">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Início</a>
                <a href="/#nossa-missao" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Sobre</a>
                <a href="../../ajuda/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Suporte</a>
                <a href="../../FAQ/" class="text-white hover:text-primary block px-3 py-2 rounded-md text-base font-medium">FAQ</a>

                <div class="border-t border-primary/20 pt-4 mt-4">
                    <a href="../entrar/" class="bg-primary hover:bg-primary-dark text-white block text-center px-4 py-2 rounded-full transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>ENTRAR
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-36 pb-6 bg-gradient-to-br from-dark via-dark-light to-dark relative overflow-hidden">
        <!-- Background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/10 rounded-full blur-2xl animate-bounce-slow"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-primary/10 rounded-full blur-2xl animate-bounce-slow" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-glow">
                    <i class="fas fa-lock text-xl text-white"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold mb-4 bg-gradient-to-r from-white via-primary to-white bg-clip-text text-transparent">
                    Nova Senha
                </h1>
                <p class="text-base text-gray-300 mb-4 max-w-xl mx-auto">
                    Crie uma senha forte e segura para proteger sua conta
                </p>
            </div>
        </div>
    </section>

    <!-- New Password Form Section -->
    <section class="py-16 bg-gradient-to-b from-dark to-dark-light">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-dark-light/50 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-primary/20 shadow-2xl">

                <!-- Password Requirements -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-shield-alt text-primary mr-2"></i>
                        Requisitos de Segurança
                    </h3>
                    <div class="bg-primary/10 rounded-xl p-4 border border-primary/20">
                        <ul id="passwordChecklist" class="space-y-2 text-sm">
                            <li class="flex items-center">
                                <i class="fas fa-circle text-gray-600 mr-3 text-xs" id="checkLength"></i>
                                <span class="text-gray-400" id="lengthText">Pelo menos 8 caracteres</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-circle text-gray-600 mr-3 text-xs" id="checkUppercase"></i>
                                <span class="text-gray-400" id="uppercaseText">Uma letra maiúscula</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-circle text-gray-600 mr-3 text-xs" id="checkNumber"></i>
                                <span class="text-gray-400" id="numberText">Um número</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-circle text-gray-600 mr-3 text-xs" id="checkSpecial"></i>
                                <span class="text-gray-400" id="specialText">Um caractere especial (@$!%*?&)</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- New Password Form -->
                <form action="../backend/nova-senha.php" method="post" id="form_reset" class="space-y-6">
                    <div>
                        <label for="senha" class="block text-sm font-medium text-gray-300 mb-2">
                            Nova Senha <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="senha"
                                name="senha"
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 pr-12 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                                placeholder="Digite sua nova senha">
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mt-3">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs text-gray-400">Força da senha:</span>
                                <span id="passwordStrength" class="text-xs text-gray-400">Muito fraca</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div id="passwordProgress" class="bg-red-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="confSenha" class="block text-sm font-medium text-gray-300 mb-2">
                            Confirmar Nova Senha <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="confSenha"
                                name="confSenha"
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 pr-12 bg-dark border border-primary/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200"
                                placeholder="Confirme sua nova senha">
                            <button
                                type="button"
                                id="ConftogglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="mt-2 text-sm"></div>
                    </div>

                    <input type="hidden" name="token" value="<?php echo !empty($_GET['token']) ? $_GET['token'] : null; ?>">

                    <button
                        type="submit"
                        id="submitBtn"
                        disabled
                        class="w-full bg-primary hover:bg-primary-dark text-white px-8 py-4 rounded-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary/50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span id="btn-text">Criar Nova Senha</span>
                        <div id="loading-spinner" class="hidden inline-block ml-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-lighter border-t border-primary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <img src="/assets/img/logo-head.png" alt="Logo" class="h-8 w-auto">
                        <span class="text-xl font-bold text-primary">Minhas Vacinas</span>
                    </div>
                    <p class="text-gray-400">Protegendo você e sua família com informações e controle digital de vacinas.</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Serviços</h3>
                    <ul class="space-y-2">
                        <li><a href="/src/auth/cadastro/" class="text-gray-400 hover:text-primary transition-colors">Cadastro</a></li>
                        <li><a href="/src/ajuda/" class="text-gray-400 hover:text-primary transition-colors">Suporte</a></li>
                        <li><a href="/src/painel/" class="text-gray-400 hover:text-primary transition-colors">Histórico</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Links Úteis</h3>
                    <ul class="space-y-2">
                        <li><a href="../../../docs/Politica-de-Privacidade.php" class="text-gray-400 hover:text-primary transition-colors">Política de Privacidade</a></li>
                        <li><a href="../../../docs/Termos-de-Servico.php" class="text-gray-400 hover:text-primary transition-colors">Termos de Serviço</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Contato</h3>
                    <p class="text-gray-400">
                        <i class="fas fa-envelope mr-2 text-primary"></i>
                        contato@minhasvacinas.online
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-primary/20 bg-dark py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-400">
                    © 2025 Minhas Vacinas. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Password visibility toggles
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('senha');
            const icon = this.querySelector('i');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('ConftogglePassword').addEventListener('click', function() {
            const password = document.getElementById('confSenha');
            const icon = this.querySelector('i');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Password validation
        const senhaInput = document.getElementById('senha');
        const confSenhaInput = document.getElementById('confSenha');
        const submitBtn = document.getElementById('submitBtn');

        function validatePassword() {
            const password = senhaInput.value;
            const progressBar = document.getElementById('passwordProgress');
            const strengthText = document.getElementById('passwordStrength');

            const lengthCheck = document.getElementById('checkLength');
            const lengthText = document.getElementById('lengthText');
            const uppercaseCheck = document.getElementById('checkUppercase');
            const uppercaseText = document.getElementById('uppercaseText');
            const numberCheck = document.getElementById('checkNumber');
            const numberText = document.getElementById('numberText');
            const specialCheck = document.getElementById('checkSpecial');
            const specialText = document.getElementById('specialText');

            let strength = 0;

            // Length check
            if (password.length >= 8) {
                lengthCheck.classList.remove('text-gray-600');
                lengthCheck.classList.add('text-green-400');
                lengthText.classList.remove('text-gray-400');
                lengthText.classList.add('text-green-400');
                strength++;
            } else {
                lengthCheck.classList.remove('text-green-400');
                lengthCheck.classList.add('text-gray-600');
                lengthText.classList.remove('text-green-400');
                lengthText.classList.add('text-gray-400');
            }

            // Uppercase check
            if (/[A-Z]/.test(password)) {
                uppercaseCheck.classList.remove('text-gray-600');
                uppercaseCheck.classList.add('text-green-400');
                uppercaseText.classList.remove('text-gray-400');
                uppercaseText.classList.add('text-green-400');
                strength++;
            } else {
                uppercaseCheck.classList.remove('text-green-400');
                uppercaseCheck.classList.add('text-gray-600');
                uppercaseText.classList.remove('text-green-400');
                uppercaseText.classList.add('text-gray-400');
            }

            // Number check
            if (/\d/.test(password)) {
                numberCheck.classList.remove('text-gray-600');
                numberCheck.classList.add('text-green-400');
                numberText.classList.remove('text-gray-400');
                numberText.classList.add('text-green-400');
                strength++;
            } else {
                numberCheck.classList.remove('text-green-400');
                numberCheck.classList.add('text-gray-600');
                numberText.classList.remove('text-green-400');
                numberText.classList.add('text-gray-400');
            }

            // Special character check
            if (/[@$!%*?&]/.test(password)) {
                specialCheck.classList.remove('text-gray-600');
                specialCheck.classList.add('text-green-400');
                specialText.classList.remove('text-gray-400');
                specialText.classList.add('text-green-400');
                strength++;
            } else {
                specialCheck.classList.remove('text-green-400');
                specialCheck.classList.add('text-gray-600');
                specialText.classList.remove('text-green-400');
                specialText.classList.add('text-gray-400');
            }

            // Update progress bar
            const progress = (strength * 25);
            progressBar.style.width = progress + '%';

            // Update strength text and color
            if (strength === 0) {
                strengthText.textContent = 'Muito fraca';
                progressBar.className = 'bg-red-500 h-2 rounded-full transition-all duration-300';
            } else if (strength === 1) {
                strengthText.textContent = 'Fraca';
                progressBar.className = 'bg-red-400 h-2 rounded-full transition-all duration-300';
            } else if (strength === 2) {
                strengthText.textContent = 'Média';
                progressBar.className = 'bg-yellow-500 h-2 rounded-full transition-all duration-300';
            } else if (strength === 3) {
                strengthText.textContent = 'Boa';
                progressBar.className = 'bg-blue-500 h-2 rounded-full transition-all duration-300';
            } else if (strength === 4) {
                strengthText.textContent = 'Muito forte';
                progressBar.className = 'bg-green-500 h-2 rounded-full transition-all duration-300';
            }

            checkPasswordMatch();
        }

        function checkPasswordMatch() {
            const password = senhaInput.value;
            const confirmPassword = confSenhaInput.value;
            const matchDiv = document.getElementById('passwordMatch');

            if (confirmPassword === '') {
                matchDiv.textContent = '';
                submitBtn.disabled = true;
                return;
            }

            if (password !== confirmPassword) {
                matchDiv.textContent = 'As senhas não coincidem';
                matchDiv.className = 'mt-2 text-sm text-red-400';
                submitBtn.disabled = true;
            } else {
                matchDiv.textContent = 'As senhas coincidem';
                matchDiv.className = 'mt-2 text-sm text-green-400';

                // Enable submit only if password is strong enough
                const strength = calculatePasswordStrength(password);
                submitBtn.disabled = strength < 4;
            }
        }

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[@$!%*?&]/.test(password)) strength++;
            return strength;
        }

        senhaInput.addEventListener('input', validatePassword);
        confSenhaInput.addEventListener('input', checkPasswordMatch);

        // Form submission
        document.getElementById('form_reset').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btn-text');
            const loadingSpinner = document.getElementById('loading-spinner');

            // Show loading state
            submitBtn.disabled = true;
            btnText.textContent = 'Criando senha...';
            loadingSpinner.classList.remove('hidden');

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    showNotification('Senha criada com sucesso! Redirecionando...', 'success');
                    setTimeout(() => {
                        window.location.href = '../entrar/';
                    }, 2000);
                } else {
                    throw new Error('Erro ao criar senha');
                }

            } catch (error) {
                console.error('Error:', error);
                showNotification('Erro ao criar nova senha. Tente novamente.', 'error');

            } finally {
                submitBtn.disabled = false;
                btnText.textContent = 'Criar Nova Senha';
                loadingSpinner.classList.add('hidden');
            }
        });

        // Notification system
        function showNotification(message, type = 'info', duration = 5000) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-2xl transform transition-all duration-300 translate-x-full`;

            const colors = {
                success: 'bg-green-500/20 border border-green-500/30 text-green-400',
                error: 'bg-red-500/20 border border-red-500/30 text-red-400',
                warning: 'bg-yellow-500/20 border border-yellow-500/30 text-yellow-400',
                info: 'bg-blue-500/20 border border-blue-500/30 text-blue-400'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-triangle',
                warning: 'fa-exclamation-circle',
                info: 'fa-info-circle'
            };

            notification.className += ` ${colors[type]}`;

            notification.innerHTML = `
                <div class="flex items-start">
                    <i class="fas ${icons[type]} mr-3 mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <button class="ml-3 flex-shrink-0 hover:opacity-70 transition-opacity" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, duration);
        }
    </script>
</body>

</html>