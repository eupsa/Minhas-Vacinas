<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    header("Location: ../../../auth/entrar/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../../../../assets/img/img-web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Cadastro de Vacinas</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top"
            style="background-color: #007bff; z-index: 1081; width: 100%; left: 50%; transform: translateX(-50%);">
            <div class="container">
                <a class="navbar-brand" href="/index.html">
                    <img src="../../../../assets/img/logo-head.png" alt="Logo Vacinas" style="height: 50px;">
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
                <div class="d-flex align-items-center justify-content-center" style="height: 10vh;">
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="../../" class="nav-link text-white" aria-current="page">
                            <i class="bi bi-house-door"></i>
                            Início
                        </a>
                    </li>
                    <li>
                        <a href="../" class="nav-link active">
                            <i class="fas fa-syringe"></i>
                            Vacinas
                        </a>
                    </li>
                    <li>
                        <a href="" onclick="alert('Indisponível')" class="nav-link text-white">
                            <i class="fas fa-bullhorn"></i>
                            Campanhas
                        </a>
                    </li>
                    <li>
                        <a href="../../perfil/" class="nav-link text-white">
                            <i class="bi bi-person"></i>
                            Conta
                        </a>
                    </li>
                    <li>
                        <hr>
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
                        <li><a class="dropdown-item" href="../scripts/sair.php"><i class="fas fa-user"></i> Minha conta</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../../../auth/esqueceu-senha/"><i class="fas fa-key"></i> Trocar senha</a></li>
                        <li><a class="dropdown-item" href="../../../ajuda/"><i class="fas fa-headset"></i> Suporte</a></li>
                        <li><a class="dropdown-item" href="../../../auth/excluir-conta/"><i class="fas fa-user-times"></i> Excluir conta</a></li>
                        <li><a class="dropdown-item" href="../../../scripts/sair.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                    </ul>
                </div>
            </div>
    </section>

    <section>
        <div class="content">
            <h2 class="fw-light">Cadastro de Vacinas</h2>
            <form action="../../backend/cadastro-vacina.php" method="post" id="form_vacina">
                <div class="mb-3">
                    <select class="form-select" id="nomeVac" name="nomeVac" aria-label="Selecione a vacina">
                        <option value="" disabled selected>Selecione uma vacina</option>
                        <!-- Vacinas para Crianças -->
                        <optgroup label="Crianças">
                            <option value="BCG - PROTEÇÃO CONTRA TUBERCULOSE">BCG - Proteção contra Tuberculose</option>
                            <option value="HEPATITE-B">Hepatite B</option>
                            <option value="PENTAVALENTE (DTP + Hib + Hepatite B)">Pentavalente (DTP + Hib + Hepatite B)</option>
                            <option value="POLIOMIELITE (VOP e VIP)">Poliomielite (VOP e VIP)</option>
                            <option value="ROTAVÍRUS">Rotavírus</option>
                            <option value="PNEUMOCÓCIA-10">Pneumocócica 10-Valente</option>
                            <option value="MENINGOCÓCICA-C">Meningocócica C (Conjugada)</option>
                            <option value="FEBRE-AMARELA">Febre Amarela</option>
                            <option value="TRÍPLICE-VIRAL">Tríplice Viral (Sarampo, Caxumba, Rubéola)</option>
                            <option value="HEPATITE-A">Hepatite A</option>
                        </optgroup>

                        <!-- Vacinas para Adolescentes -->
                        <optgroup label="Adolescentes">
                            <option value="HPV">HPV Quadrivalente</option>
                            <option value="MENINGOCÓCICA-ACWY">Meningocócica ACWY</option>
                            <option value="DTPa">DTPa (Tríplice Bacteriana Acelular do Tipo Adulto)</option>
                        </optgroup>

                        <!-- Vacinas para Adultos -->
                        <optgroup label="Adultos">
                            <option value="HEPATITE-B">Hepatite B</option>
                            <option value="DIFTERIA E TÉTANO (DUPLA ADULTO)">Difteria e Tétano (Dupla Adulto)</option>
                            <option value="FEBRE-AMARELA">Febre Amarela</option>
                            <option value="INFLUENZA">Influenza (Gripe)</option>
                        </optgroup>

                        <!-- Vacinas para Idosos -->
                        <optgroup label="Idosos">
                            <option value="INFLUENZA">Influenza (Gripe)</option>
                            <option value="PNEUMOCÓCICA-23">Pneumocócica 23-Valente</option>
                            <option value="HERPES-ZÓSTER">Herpes Zóster</option>
                        </optgroup>

                        <!-- Vacinas para Grupos Especiais -->
                        <optgroup label="Grupos Especiais">
                            <option value="COVID-19">COVID-19</option>
                            <option value="RAIVA">Raiva</option>
                            <option value="HEPATITE-B">Hepatite A</option>
                            <option value="MENINGOCÓCICA-B">Meningocócica B</option>
                        </optgroup>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dataAplicacao" class="form-label">Data da Aplicação<span class="required-asterisk">*</span></label>
                    <input type="date" class="form-control" id="dataAplicacao" name="dataAplicacao" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="localAplicacao" class="form-label">Unidade de Vacinação<span class="required-asterisk">*</span></label>
                    <select class="form-select" aria-label="Selecione a unidade de saúde" id="localAplicacao" name="localAplicacao">
                        <option value="" disabled selected>Selecione a unidade</option>
                        <option value="UBS Clementino Fraga">UBS Clementino Fraga</option>
                        <option value="Multicentro Amaralina">Multicentro Amaralina</option>
                        <option value="USF Alto das Pombas">USF Alto das Pombas</option>
                        <option value="USF Menino Joel">USF Menino Joel</option>
                        <option value="USF Vila Matos">USF Vila Matos</option>
                        <option value="USF Candeal Pequeno">USF Candeal Pequeno</option>
                        <option value="UBS Manoel Vitorino">UBS Manoel Vitorino</option>
                        <option value="USF Mãe Olga de Alaketu - Vale do Matatu">USF Mãe Olga de Alaketu - Vale do Matatu</option>
                        <option value="USF Santa Luzia">USF Santa Luzia</option>
                        <option value="USF Zulmira Barros">USF Zulmira Barros</option>
                        <option value="USF Imbui">USF Imbui</option>
                        <option value="USF Curralinho">USF Curralinho</option>
                        <option value="USF Pituaçu">USF Pituaçu</option>
                        <option value="USF Parque de Pituaçu">USF Parque de Pituaçu</option>
                        <option value="UBS Cesar de Araujo">UBS Cesar de Araujo</option>
                        <option value="USF Dep Cristovao Ferreira - Saramandia">USF Dep Cristovao Ferreira - Saramandia</option>
                        <option value="USF Profº Drº Carlos Santana - Doron">USF Profº Drº Carlos Santana - Doron</option>
                        <option value="USF Fernando Filgueiras – Alto da Cachoeirinha - Cabula VI">USF Fernando Filgueiras – Alto da Cachoeirinha - Cabula VI</option>
                        <option value="USF Arenoso">USF Arenoso</option>
                        <option value="CSU Pernambues">CSU Pernambues</option>
                        <option value="UBS Nelson P. Dourado">UBS Nelson P. Dourado</option>
                        <option value="USF Cajazeiras V">USF Cajazeiras V</option>
                        <option value="USF Jardim das Mangabeiras">USF Jardim das Mangabeiras</option>
                        <option value="USF Palestina">USF Palestina</option>
                        <option value="USF Jaguaripe">USF Jaguaripe</option>
                        <option value="UBS Barbalho">UBS Barbalho</option>
                        <option value="UBS Ramiro de Azevedo">UBS Ramiro de Azevedo</option>
                        <option value="USF Gamboa">USF Gamboa</option>
                        <option value="UBS Prof. José Mariane">UBS Prof. José Mariane</option>
                        <option value="UBS Dr. Orlando Imbassahy">UBS Dr. Orlando Imbassahy</option>
                        <option value="USF Parque São Cristóvão">USF Parque São Cristóvão</option>
                        <option value="USF Vila Verde">USF Vila Verde</option>
                        <option value="USF Ceasa">USF Ceasa</option>
                        <option value="USF Coração de Maria">USF Coração de Maria</option>
                        <option value="USF Prof. Eduardo Mamede">USF Prof. Eduardo Mamede</option>
                        <option value="USF Itapuã">USF Itapuã</option>
                        <option value="UBS Virgílio de Carvalho">UBS Virgílio de Carvalho</option>
                        <option value="UBS Ministro Alkimin">UBS Ministro Alkimin</option>
                        <option value="USF Joanes Leste">USF Joanes Leste</option>
                        <option value="USF Joanes Centro Oeste Hamesa">USF Joanes Centro Oeste Hamesa</option>
                        <option value="USF São José de Baixo">USF São José de Baixo</option>
                        <option value="Multicentro Liberdade">Multicentro Liberdade</option>
                        <option value="USF Santa Mônica">USF Santa Mônica</option>
                        <option value="USF San Martin I">USF San Martin I</option>
                        <option value="USF Vila Nova de Pituaçu">USF Vila Nova de Pituaçu</option>
                        <option value="USF Vila Canária">USF Vila Canária</option>
                        <option value="USF São Marcos">USF São Marcos</option>
                        <option value="UBS Edgar Pires da Veiga">UBS Edgar Pires da Veiga</option>
                        <option value="USF Canabrava">USF Canabrava</option>
                        <option value="USF Dom Avelar">USF Dom Avelar</option>
                        <option value="USF Vale do Cambonas">USF Vale do Cambonas</option>
                        <option value="UBS Sete de Abril">UBS Sete de Abril</option>
                        <option value="Saúde dos Bairros">Saúde dos Bairros</option>
                        <option value="USF Lagoa da Paixão">USF Lagoa da Paixão</option>
                        <option value="USF Deputado Luiz Braga">USF Deputado Luiz Braga</option>
                        <option value="USF Antonio Lazzarotto">USF Antonio Lazzarotto</option>
                        <option value="USF Capelinha">USF Capelinha</option>
                        <option value="USF Pirajá">USF Pirajá</option>
                        <option value="USF Alto do Cabrito">USF Alto do Cabrito</option>
                        <option value="USF Fazenda Coutos">USF Fazenda Coutos</option>
                        <option value="USF Itapuã II">USF Itapuã II</option>
                        <option value="USF Suburbana">USF Suburbana</option>
                        <option value="USF Monte Azul">USF Monte Azul</option>
                        <option value="UBS Quingoma">UBS Quingoma</option>
                        <option value="UBS Cajazeiras">UBS Cajazeiras</option>
                        <option value="USF Vila Mariana">USF Vila Mariana</option>
                        <option value="USF Rio Sena">USF Rio Sena</option>
                        <option value="USF São Cristóvão">USF São Cristóvão</option>
                        <option value="USF Sol Nascente">USF Sol Nascente</option>
                        <option value="USF Liberdade">USF Liberdade</option>
                        <option value="USF Tancredo Neves">USF Tancredo Neves</option>
                        <option value="UBS Arembepe">UBS Arembepe</option>
                        <option value="USF Jardim São Paulo">USF Jardim São Paulo</option>
                        <option value="USF Largo do Tanque">USF Largo do Tanque</option>
                        <option value="USF Baixa do Fiscal">USF Baixa do Fiscal</option>
                        <option value="USF Coutos">USF Coutos</option>
                        <option value="USF Periperi">USF Periperi</option>
                        <option value="UBS Bairro da Paz">UBS Bairro da Paz</option>
                        <option value="USF Candeal">USF Candeal</option>
                        <option value="USF Santo Antônio">USF Santo Antônio</option>
                        <option value="USF Massaranduba">USF Massaranduba</option>
                        <option value="USF Nordeste de Amaralina">USF Nordeste de Amaralina</option>
                        <option value="UBS Pirajá">UBS Pirajá</option>
                        <option value="USF Cabula">USF Cabula</option>
                        <option value="USF Calabar">USF Calabar</option>
                        <option value="USF São Gonçalo do Retiro">USF São Gonçalo do Retiro</option>
                        <option value="USF Alto do Maron">USF Alto do Maron</option>
                        <option value="UBS Jardim Armação">UBS Jardim Armação</option>
                        <option value="USF Imbuí II">USF Imbuí II</option>
                        <option value="USF Boa Vista de São Caetano">USF Boa Vista de São Caetano</option>
                        <option value="USF Santa Catarina">USF Santa Catarina</option>
                        <option value="USF Jardim de Alah">USF Jardim de Alah</option>
                        <option value="USF Vilas do Atlântico">USF Vilas do Atlântico</option>
                        <option value="USF Nova Brasília">USF Nova Brasília</option>
                        <option value="Outro">Outro</option>
                    </select>

                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Vacina<span class="required-asterisk">*</span></label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="" selected>Selecione o tipo</option>
                        <option value="Imunização">Imunização</option>
                        <option value="Vacina de Vírus Vivo Atenuado">Vacina de Vírus Vivo Atenuado</option>
                        <option value="Vacina de Vírus Inativado">Vacina de Vírus Inativado</option>
                        <option value="Vacina Subunitária">Vacina Subunitária</option>
                        <option value="Vacina de RNA Mensageiro (mRNA)">Vacina de RNA Mensageiro (mRNA)</option>
                        <option value="Vacina de Vetor Viral">Vacina de Vetor Viral</option>
                        <option value="Vacina de Proteína Recombinante">Vacina de Proteína Recombinante</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dose" class="form-label">Dose<span class="required-asterisk">*</span></label>
                    <select class="form-select" id="dose" name="dose">
                        <option value="" selected>Selecione a dose</option>
                        <option value="1ª Dose">1ª Dose</option>
                        <option value="2ª Dose">2ª Dose</option>
                        <option value="Reforço">Reforço</option>
                        <option value="Dose Única">Dose Única</option>
                        <option value="Dose de Manutenção">Dose de Manutenção</option>
                        <option value="Dose Adicional">Dose Adicional</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="lote" class="form-label">Lote</label>
                    <input type="text" class="form-control" id="lote" name="lote" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="obs" class="form-label">Observações</label>
                    <textarea class="form-control" id="obs" name="obs" rows="3"></textarea autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar Vacina</button>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>