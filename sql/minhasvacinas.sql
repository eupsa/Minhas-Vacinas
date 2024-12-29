CREATE DATABASE IF NOT EXISTS minhasvacinas;
USE minhasvacinas;

CREATE TABLE
    IF NOT EXISTS usuario (
        id_usuario BIGINT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        estado ENUM (
            'AC',
            'AL',
            'AP',
            'AM',
            'BA',
            'CE',
            'DF',
            'ES',
            'GO',
            'MA',
            'MT',
            'MS',
            'MG',
            'PA',
            'PB',
            'PR',
            'PE',
            'PI',
            'RJ',
            'RN',
            'RS',
            'RO',
            'RR',
            'SC',
            'SP',
            'SE',
            'TO'
        ) NOT NULL,
        senha VARCHAR(128) NOT NULL,
        email_conf TINYINT (1) DEFAULT 0,
        data_nascimento DATE,
        genero ENUM ('Não Informado', 'Masculino', 'Feminino', 'Outro'),
        cpf VARCHAR(14) UNIQUE,
        telefone VARCHAR(15),
        cidade VARCHAR(100),
        data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
	);

    INSERT INTO usuario (nome, email, estado, senha, email_conf)
    VALUES 
    ('Pedro', 'email@gmail.com', 'BA', '$2y$10$R5ToR3.obbC1G4bnAzUkZeKTle45W3ywNtse8PeCvFTDTGHu2AudC', 1);

CREATE TABLE
    IF NOT EXISTS confirmar_cadastro (
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
		codigo VARCHAR(6) UNIQUE NOT NULL,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
        -- o nome tá nessa tabela pq preciso pegar o nome e enviar o email dps q o usuario confirmar o cadastro
    );

CREATE TABLE
    IF NOT EXISTS vacina (
        id_vac BIGINT PRIMARY KEY AUTO_INCREMENT,
        nome_vac ENUM (
            'BCG - Proteção contra Tuberculose',
            'Hepatite B',
            'Pentavalente (DTP + Hib + Hepatite B)',
            'Poliomielite (VOP e VIP)',
            'Rotavírus',
            'Pneumocócica 10-Valente',
            'Meningocócica C (Conjugada)',
            'Febre Amarela',
            'Tríplice Viral (Sarampo, Caxumba, Rubéola)',
            'Hepatite A',
            'HPV Quadrivalente',
            'Meningocócica ACWY',
            'DTPa (Tríplice Bacteriana Acelular do Tipo Adulto)',
            'Difteria e Tétano (Dupla Adulto)',
            'Influenza (Gripe)',
            'Pneumocócica 23-Valente',
            'Herpes Zóster',
            'Raiva',
            'Meningocócica B',
            'COVID-19'
        ) NOT NULL,
        data_aplicacao DATE NOT NULL,
        proxima_dose DATE,
        local_aplicacao VARCHAR(200) NOT NULL,
        tipo ENUM (
            'Imunização',
            'Vacina de Vírus Vivo Atenuado',
            'Vacina de Vírus Inativado',
            'Vacina Subunitária',
            'Vacina de RNA Mensageiro (mRNA)',
            'Vacina de Vetor Viral',
            'Vacina de Proteína Recombinante'
        ) NOT NULL,
        dose VARCHAR(50) NOT NULL,
        lote VARCHAR(50),
        obs TEXT,
        id_usuario BIGINT,
        CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE SET NULL
    );

CREATE TABLE
    IF NOT EXISTS esqueceu_senha (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) UNIQUE NOT NULL,
        token VARCHAR(255) NOT NULL,
        data_expiracao DATETIME NOT NULL,
        data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
    );

CREATE TABLE
    IF NOT EXISTS protocolo (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        nome_solicitante VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        motivo VARCHAR(30) NOT NULL,
        mensagem VARCHAR(1000) NOT NULL,
        -- nome_atendente VARCHAR(100) NOT NULL,
        data_registro DATETIME DEFAULT CURRENT_TIMESTAMP
    );

-- DELETE FROM `minhasvacinas`.`esqueceu_senha`
-- WHERE
--   (`email` = 'pedruuu291@gmail.com');

CREATE TABLE
    IF NOT EXISTS excluir_conta (
        code_email INT NOT NULL,
        email VARCHAR(255) NOT NULL,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
    );

SELECT @@global.time_zone, @@session.time_zone;
SET time_zone = 'America/Sao_Paulo';
SET sql_mode = 'STRICT_TRANS_TABLES';