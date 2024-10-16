<?php
require '../backend/scripts/auth.php';
VefLogin();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vacinas - Cadastro</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="../../index.html">
                    <img src="../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.html">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.html#nossa-missao">Sobre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../campaigns/index.html">Campanhas</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSuporte">
                                Suporte
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Baixe o App
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="">
                                        <img src="https://api.iconify.design/logos:apple-app-store.svg" alt="App Store"
                                            style="width: 20px; height: 20px;" class="me-2">
                                        App Store
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
                                        <img src="https://api.iconify.design/logos:google-play-icon.svg"
                                            alt="Google Play" style="width: 20px; height: 20px;" class="me-2">
                                        Google Play
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="btn btn-light btn-login" href="../login/index.php">LOGIN</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section>
        <div class="container d-flex justify-content-center align-items-center full-height" style="margin-top: 70px;">
            <div class="row w-100">
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <form action="../backend/register.php" class="needs-validation bg-light p-5 rounded shadow-lg"
                        id="formcad" method="post" novalidate>
                        <h4 class="mb-4 text-center">Faça seu Cadastro</h4>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required autocomplete="off">
                            <div class="invalid-feedback">Por favor, insira seu nome.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                autocomplete="off">
                            <div class="invalid-feedback">Por favor, insira um e-mail válido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Crie sua senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="senha" name="senha">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Por favor, insira uma senha.</div>
                            </div>
                            <div id="passwordHelpBlock" class="form-text">
                                Sua senha deve ter de 8 a 20 caracteres, conter letras e números e não deve conter
                                espaços, caracteres especiais ou emojis.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password2" class="form-label">Confirme sua senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confSenha" name="confSenha">
                                <button class="btn btn-outline-secondary" type="button" id="ConftogglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Por favor, insira uma senha.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Selecione um estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="">Selecione um estado</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                            </select>
                            <div class="invalid-feedback">Por favor, selecione um estado.</div>
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Cadastrar</button>
                    </form>
                    <hr class="custom-hr">
                    <div class="text-center mt-3">
                        <p class="mb-1">Já tem uma conta?</p>
                        <a href="../login/index.php" class="btn btn-primary">Entre na sua conta</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="modal-suporte">
        <div class="modal fade" id="modalSuporte" tabindex="-1" aria-labelledby="modalSuporteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSuporteLabel">Entre em Contato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="src/backend/support.php" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name" placeholder="Seu nome">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" placeholder="Seu e-mail">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="message" rows="3"
                                    placeholder="Sua mensagem"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer text-center">
        <div class="container">
            <p class="mb-0">© 2024 Vacinas - Todos os direitos reservados</p>
            <a href="" class="text-white">Termos de Uso</a> |
            <a href="" class="text-white">Política de Privacidade</a>
        </div>
    </footer>

    <!-- 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script src="../../assets/js/sweetalert2.js"></script>
</body>

</html>