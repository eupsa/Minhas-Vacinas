<?php
session_start();
require '../../scripts/conn.php';
require '../../scripts/auth.php';

if (!isset($_SESSION['session_id'])) {
    header("Location: ../../auth/entrar/");
    exit();
}

$sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
$sql->bindValue(':id_usuario', $_SESSION['session_id']);
$sql->execute();

if ($sql->rowCount() == 1) {
    info_user($pdo);

    $id_usuario = $_SESSION['session_id'];
    $sql = $pdo->prepare("SELECT * FROM cidade WHERE Uf = :estado");
    $sql->bindValue(':estado', $_SESSION['session_estado']);
    $sql->execute();
    $cidades = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($cidades) > 0) {
        $_SESSION['cidades'] = $cidades;
    } else {
        $_SESSION['cidades'] = [];
    }
} else {
    $_SESSION = [];
    session_destroy();

    header("Location: ../../auth/entrar/");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3472234536437513"
        crossorigin="anonymous"></script>
    <title>Vacinas - Perfil</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top"
            style="background-color: #007bff; z-index: 1100; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

    <section>
        <div>
            <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
                <div class="d-flex align-items-center justify-content-center" style="height: 10vh;"></div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="../" class="nav-link text-white" aria-current="page">
                            <i class="bi bi-house-door"></i> Início
                        </a>
                    </li>
                    <li>
                        <a href="../vacinas/" class="nav-link text-white">
                            <i class="fas fa-syringe"></i> Vacinas
                        </a>
                    </li>
                    <li>
                        <a href="" onclick="alert('Indisponível')" class="nav-link text-white">
                            <i class="fas fa-bullhorn"></i> Campanhas
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i> Conta
                        </a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="navbarDropdown" style="background: #343a40;">
                            <li><a class="dropdown-item text-white" href="../../auth/trocar-email/" data-bs-toggle="modal" data-bs-target="#alterar-email">Alterar e-mail</a></li>
                            <li><a class="dropdown-item text-white" href="../">Alterar senha</a></li>
                            <li><a class="dropdown-item text-white" href="">Configurações (desativado)</a></li>
                            <li>
                                <!-- <hr class="dropdown-divider"> -->
                            </li>
                        </ul>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/img/bx-user.svg" alt="Foto do Usuário" class="rounded-circle me-2"
                            width="40" height="40">
                        <span><?php echo isset($_SESSION['session_nome']) ? explode(' ', $_SESSION['session_nome'])[0] : 'Usuário'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="" onclick="Location.reload()"><i class="fas fa-user"></i> Minha conta</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../../ajuda/"><i class="fas fa-headset"></i> Suporte</a></li>
                        <li><a class="dropdown-item" href="../../scripts/sair.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                        <li><a class="dropdown-item text-danger" href="">Excluir conta</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="profile-section py-5 padding-left-10">
        <div class=" container">
            <div class="card shadow-lg border-0"">
                <div class=" card-header bg text-white text-center py-3" style="background: #3f3f3f;">
                <h3>Dados do Perfil</h3>
            </div>
            <div class="card-body">
                <form id="form_perfil" action="../../../backend/update_register.php" method="post">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" disabled
                                value="<?php echo isset($_SESSION['session_nome']) ? $_SESSION['session_nome'] : ''; ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label">E-Mail</label>
                            <div class="position-relative">
                                <input type="email" class="form-control" id="email" name="email" disabled
                                    value="<?php echo isset($_SESSION['session_email']) ? $_SESSION['session_email'] : ''; ?>">
                                <small class="text-success d-flex align-items-center position-absolute top-50 end-0 translate-middle-y me-2">
                                    <i class="fas fa-check-circle me-2" title="E-mail confirmado com sucesso!"></i>
                                </small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" disabled
                                value="<?php echo isset($_SESSION['session_data_nascimento']) && !empty($_SESSION['session_data_nascimento']) ? $_SESSION['session_data_nascimento'] : ''; ?>"
                                placeholder="aaaaa">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <img src="../../../assets/img/num-img-br.png" alt="Bandeira do Brasil" style="width: 20px; height: 15px;" class="me-2">+55
                                </span>
                                <input type="text" class="form-control" id="telefone" name="telefone" disabled
                                    value="<?php echo isset($_SESSION['session_telefone']) ? $_SESSION['session_telefone'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="cpf" class="form-label">CPF</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="cpf" name="cpf" disabled
                                    value="<?php echo isset($_SESSION['session_cpf']) ? $_SESSION['session_cpf'] : ''; ?>">
                                <?php if (!empty($_SESSION['session_cpf'])): ?>
                                    <small class="text-success d-flex align-items-center position-absolute top-50 end-0 translate-middle-y me-2">
                                        <i class="fas fa-check-circle me-2" title="CPF válido!"></i>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="cidade" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" disabled
                                value="<?php echo isset($_SESSION['session_estado']) ? $_SESSION['session_estado'] : ''; ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="genero" class="form-label">Gênero</label>
                            <select class="form-control" id="genero" name="genero" disabled>
                                <option value="Não Informado" <?php echo (isset($_SESSION['session_genero']) && $_SESSION['session_genero'] === 'Não Informado') ? 'selected' : ''; ?>>Não Informado</option>
                                <option value="Masculino" <?php echo (isset($_SESSION['session_genero']) && $_SESSION['session_genero'] === 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="Feminino" <?php echo (isset($_SESSION['session_genero']) && $_SESSION['session_genero'] === 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
                                <option value="Outro" <?php echo (isset($_SESSION['session_genero']) && $_SESSION['session_genero'] === 'Outro') ? 'selected' : ''; ?>>Outro</option>
                            </select>
                        </div>
                        <!-- <div class="col-12 col-md-6">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" disabled
                                value="<?php echo isset($_SESSION['session_cidade']) ? $_SESSION['session_cidade'] : ''; ?>">
                        </div> -->
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn w-100 py-1 text-white" data-bs-toggle="modal" data-bs-target="#updateModal" style="background: #3f3f3f;">Editar Dados</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true" style="z-index: 1200;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Seus Dados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-perfil" action="../backend/atualizar-dados.php" method="post">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" autocomplete="off"
                                        value="<?php echo isset($_SESSION['session_nome']) ? $_SESSION['session_nome'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="col">
                                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" autocomplete="off"
                                        value="<?php echo isset($_SESSION['session_data_nascimento']) ? $_SESSION['session_data_nascimento'] : ''; ?>">
                                </div>
                                <div class="col">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="telefone-addon">
                                            <img src="../../../assets/img/num-img-br.png" alt="Bandeira do Brasil" style="width: 20px; height: 15px;" class="me-2">+55
                                        </span>
                                        <input type="text" class="form-control" id="telefone" name="telefone" autocomplete="off"
                                            aria-describedby="telefone-addon"
                                            value="<?php echo isset($_SESSION['session_telefone']) ? $_SESSION['session_telefone'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php if (empty($_SESSION['session_cpf'])): ?>
                                <div class="mb-3">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" autocomplete="off">
                                    <small class="form-text text-muted" style="color: red;">O CPF pode ser preenchido uma única vez e não poderá ser alterado.</small>
                                </div>
                            <?php endif; ?>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <select class="form-select" id="genero" name="genero">
                                        <option value="Não Informado" <?php echo (isset($_SESSION['session_genero']) && $_SESSION['session_genero'] === 'Não Informado') ? 'selected' : ''; ?>>Não Informado</option>
                                        <option value="Masculino" <?php echo (isset($_SESSION['session_genero']) && $_SESSION['session_genero'] === 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                        <option value="Feminino" <?php echo (isset($_SESSION['session_genero']) && $_SESSION['session_genero'] === 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
                                        <option value="Outro" <?php echo (isset($_SESSION['session_genero']) && $_SESSION['session_genero'] === 'Outro') ? 'selected' : ''; ?>>Outro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="" disabled selected>Selecione um estado</option>
                                        <option value="AC" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'AC') ? 'selected' : ''; ?>>Acre</option>
                                        <option value="AL" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'AL') ? 'selected' : ''; ?>>Alagoas</option>
                                        <option value="AP" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'AP') ? 'selected' : ''; ?>>Amapá</option>
                                        <option value="AM" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'AM') ? 'selected' : ''; ?>>Amazonas</option>
                                        <option value="BA" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'BA') ? 'selected' : ''; ?>>Bahia</option>
                                        <option value="CE" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'CE') ? 'selected' : ''; ?>>Ceará</option>
                                        <option value="DF" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'DF') ? 'selected' : ''; ?>>Distrito Federal</option>
                                        <option value="ES" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'ES') ? 'selected' : ''; ?>>Espírito Santo</option>
                                        <option value="GO" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'GO') ? 'selected' : ''; ?>>Goiás</option>
                                        <option value="MA" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'MA') ? 'selected' : ''; ?>>Maranhão</option>
                                        <option value="MT" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'MT') ? 'selected' : ''; ?>>Mato Grosso</option>
                                        <option value="MS" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'MS') ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                                        <option value="MG" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'MG') ? 'selected' : ''; ?>>Minas Gerais</option>
                                        <option value="PA" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'PA') ? 'selected' : ''; ?>>Pará</option>
                                        <option value="PB" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'PB') ? 'selected' : ''; ?>>Paraíba</option>
                                        <option value="PR" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'PR') ? 'selected' : ''; ?>>Paraná</option>
                                        <option value="PE" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'PE') ? 'selected' : ''; ?>>Pernambuco</option>
                                        <option value="PI" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'PI') ? 'selected' : ''; ?>>Piauí</option>
                                        <option value="RJ" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
                                        <option value="RN" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'RN') ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                                        <option value="RS" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'RS') ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                                        <option value="RO" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'RO') ? 'selected' : ''; ?>>Rondônia</option>
                                        <option value="RR" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'RR') ? 'selected' : ''; ?>>Roraima</option>
                                        <option value="SC" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'SC') ? 'selected' : ''; ?>>Santa Catarina</option>
                                        <option value="SP" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'SP') ? 'selected' : ''; ?>>São Paulo</option>
                                        <option value="SE" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'SE') ? 'selected' : ''; ?>>Sergipe</option>
                                        <option value="TO" <?php echo (isset($_SESSION['session_estado']) && $_SESSION['session_estado'] == 'TO') ? 'selected' : ''; ?>>Tocantins</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="row mb-3">
                                <div class="col">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <?php if (count($cidades) > 0): ?>
                                        <select class="form-select" id="cidade" name="cidade">
                                            <option value="" disabled selected>Selecione sua cidade...</option>
                                            <?php foreach ($cidades as $cidade): ?>
                                                <option value="<?php echo $cidade['Nome']; ?>" <?php echo (isset($_SESSION['session_cidade']) && $_SESSION['session_cidade'] == $cidade['Nome']) ? 'selected' : ''; ?>>
                                                    <?php echo $cidade['Nome']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <input type="text" class="form-control" id="cidade" name="cidade" autocomplete="off"
                                            value="<?php echo isset($_SESSION['session_cidade']) ? $_SESSION['session_cidade'] : ''; ?>">
                                    <?php endif; ?>
                                </div>
                            </div> -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Atualizar Dados</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="alterar-email" tabindex="-1" aria-labelledby="alterar-email" aria-hidden="true" style="z-index: 1200;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alterar-email">Alterar e-mail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">Um e-mail de confirmação será enviado para o e-mail abaixo. Verifique sua caixa de entrada para confirmar seu e-mail.
                        </p>
                        <form id="form-alterar-email" action="../backend/alterar-email.php" method="post">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email" autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Alterar e-mail</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer style="background-color: #212529; color: #f8f9fa; padding-top: 10px; margin-top: 7%;">
        <div class="me-5 d-none d-lg-block"></div>
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="bi bi-gem me-2"></i>Minhas Vacinas
                    </h6>
                    <p>
                        <i class="bi bi-info-circle me-1"></i> Protegendo você e sua família com informações e
                        controle digital de vacinas.
                    </p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Serviços</h6>
                    <p>
                        <a href="/src/auth/cadastro/" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Cadastro</a>
                    </p>
                    <p>
                        <a href="/src/ajuda/" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Suporte</a>
                    </p>
                    <p>
                        <a href="/src/painel/" style="text-decoration: none; color: #adb5bd;"
                            class="text-reset">Histórico</a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Contato</h6>
                    <p><i class="bi bi-envelope me-2"></i>contato@minhasvacinas.online</p>
                </div>
            </div>
        </div>

        <div class="text-center p-4" style="background-color: #181a1b; color: #adb5bd;">
            © 2024 Minhas Vacinas. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="script.js"></script>
    <script>

    </script>
</body>

</html>