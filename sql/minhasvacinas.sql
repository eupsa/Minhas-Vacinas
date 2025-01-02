CREATE DATABASE IF NOT EXISTS minhasvacinas;
USE minhasvacinas;

CREATE TABLE
    IF NOT EXISTS usuario (
        id_usuario INT PRIMARY KEY AUTO_INCREMENT,
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
        genero ENUM ('Não Informado', 'Masculino', 'Feminino', 'Outro') DEFAULT 'Não Informado',
        cpf VARCHAR(14) UNIQUE,
        telefone VARCHAR(15),
        cidade VARCHAR(100),
        data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    IF NOT EXISTS confirmar_cadastro (
		id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        codigo VARCHAR(6) UNIQUE NOT NULL,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
        -- o nome tá nessa tabela pq preciso pegar o nome e enviar o email dps q o usuario confirmar o cadastro
    );

CREATE TABLE
    IF NOT EXISTS vacina (
        id_vac INT PRIMARY KEY AUTO_INCREMENT,
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
        obs VARCHAR (500),
        data_adicao DATETIME DEFAULT CURRENT_TIMESTAMP,
        id_usuario INT,
        CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE SET NULL
    );

CREATE TABLE
    IF NOT EXISTS esqueceu_senha (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) UNIQUE NOT NULL,
        token VARCHAR(255) NOT NULL,
        data_expiracao DATETIME NOT NULL,
        data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
    );
    
    
CREATE TABLE
    IF NOT EXISTS mudar_senha (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) UNIQUE NOT NULL,
        codigo VARCHAR(255) NOT NULL,
        id_usuario INT,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE,
        FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
    );

CREATE TABLE
    IF NOT EXISTS excluir_conta (
		id_solicitacao INT PRIMARY KEY AUTO_INCREMENT,
        code_email INT NOT NULL,
        email VARCHAR(255) NOT NULL,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
    );
    
CREATE TABLE
    IF NOT EXISTS excluir_conta (
    acesso INT PRIMARY KEY AUTO_INCREMENT,
    ip VARCHAR (20) NOT NULL,
    continente VARCHAR (30) NOT NULL,
	pais VARCHAR (100) NOT NULL,
    estado VARCHAR (100) NOT NULL,
    cidade VARCHAR (100) NOT NULL,
    empresa VARCHAR (100) NOT NULL
);

SET sql_mode = 'STRICT_TRANS_TABLES';
SET time_zone = 'America/Sao_Paulo';
-- SELECT @@global.time_zone, @@session.time_zone;