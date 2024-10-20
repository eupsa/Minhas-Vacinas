<?php
require '../../../backend/scripts/conn.php';

$senha = $_POST['senha'];
$confsenha = $_POST['confSenha'];

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = $pdo->prepare("SELECT * FROM redefinicaoSenha WHERE token = :token");
    $sql->bindValue(':token', $token);
    $sql->execute();

    if ($sql->rowCount() === 1) {
        $redefinicao = $sql->fetch(PDO::FETCH_ASSOC);
        $email = $redefinicao['email'];
        $dataExpiracao = $redefinicao['dataExpiracao'];

        if (date('Y-m-d H:i:s', strtotime($dataExpiracao)) > date('Y-m-d H:i:s')) {
            if (empty($senha) || empty($confsenha)) {
                $retorna = ['status' => false, 'msg' => "Preencha todos os campos."];
                header('Content-Type: application/json');
                echo json_encode($retorna);
                exit;
            } else {
                if ($senha === $confsenha) {
                    try {
                        $senhaHash = hash('sha256', $senha);
                        $sql = $pdo->prepare("UPDATE usuario SET senha = :senha WHERE email = :email");
                        $sql->bindValue(':senha', $senhaHash);
                        $sql->bindValue(':email', $email);
                        $sql->execute();

                        $sql = $pdo->prepare("DELETE FROM redefinicaoSenha WHERE token = :token");
                        $sql->bindValue(':token', $token);
                        $sql->execute();

                        $retorna = ['status' => true, 'msg' => "Senha alterada com sucesso!"];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                    } catch (PDOException $e) {
                        $retorna = ['status' => false, 'msg' => "Erro ao atualizar a senha: " . $e->getMessage()];
                        header('Content-Type: application/json');
                        echo json_encode($retorna);
                        exit;
                    }
                } else {
                    $retorna = ['status' => false, 'msg' => "As senhas precisam ser iguais."];
                    header('Content-Type: application/json');
                    echo json_encode($retorna);
                    exit;
                }
            }
        } else {
            $retorna = ['status' => false, 'msg' => "O link de redefinição de senha expirou."];
            header('Content-Type: application/json');
            echo json_encode($retorna);
            exit;
        }
    } else {
        $retorna = ['status' => false, 'msg' => "Token inválido."];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit;
    }
} else {
    $retorna = ['status' => false, 'msg' => "Token não encontrado."];
    header('Content-Type: application/json');
    echo json_encode($retorna);
    exit;
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset_password.css">
    <link rel="icon" href="../../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Recuperação de Senha</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="../../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-light btn-login" href="../index.php">LOGIN</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <section class="form-resetPassword">
        <div class="container d-flex justify-content-center align-items-center full-height" style="margin-top: 70px;">
            <div class="row w-100">
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <form action="reset_password.php"
                        class="needs-validation bg-light p-5 rounded shadow-lg" id="form_reset" method="post"
                        novalidate>
                        <h4 class="mb-4 text-center">Crie sua senha</h4>
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
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary w-100" type="submit">Criar senha</button>
                    </form>
                    <hr class="custom-hr">
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
    <script src="reset_password.js"></script>
    <script src="../../../../assets/js/sweetalert2.js"></script>
</body>

</html>