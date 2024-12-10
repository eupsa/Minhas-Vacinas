CREATE DATABASE IF NOT EXISTS u193725571_minhasvacinas;
USE u193725571_minhasvacinas;

CREATE TABLE
    IF NOT EXISTS usuario (
        id_user BIGINT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        estado VARCHAR(2) NOT NULL,
        senha VARCHAR(128) NOT NULL,
        email_conf TINYINT (1) DEFAULT 0,
        data_nascimento DATE,
        genero VARCHAR(10),
        cpf VARCHAR(14) UNIQUE,
        telefone VARCHAR(15),
        cidade VARCHAR(100),
        data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
        user_root TINYINT (1) DEFAULT 0
    );
    
    -- INSERT INTO usuario (
    -- nome, email, estado, senha, email_conf, data_nascimento, genero, cpf, telefone, cidade, user_root, root_user) 
    -- VALUES 
    -- ('João Silva', 'pedruuu291@gmail.com', 'BA', '$2y$10$R5ToR3.obbC1G4bnAzUkZeKTle45W3ywNtse8PeCvFTDTGHu2AudC', 1, '2007-02-15', 'Masculino', '123.456.789-00', '(11) 91234-5678', 'São Paulo', 0, NULL);

CREATE TABLE
    IF NOT EXISTS vacina (
        id_vac BIGINT PRIMARY KEY AUTO_INCREMENT,
        nome_vac VARCHAR(100) NOT NULL,
        data_aplicacao DATE NOT NULL,
        proxima_dose DATE,
        local_aplicacao VARCHAR(200) NOT NULL,
        tipo VARCHAR(50) NOT NULL,
        dose INT,
        lote VARCHAR(50),
        obs TEXT,
        id_user BIGINT,
        CONSTRAINT fk_usuario FOREIGN KEY (id_user) REFERENCES usuario (id_user) ON DELETE SET NULL
    );

CREATE TABLE
    IF NOT EXISTS usuario_vacina (
        id_user BIGINT,
        id_vac BIGINT,
        data_aplicacao DATE,
        PRIMARY KEY (id_user, id_vac),
        FOREIGN KEY (id_user) REFERENCES usuario (id_user) ON DELETE CASCADE,
        FOREIGN KEY (id_vac) REFERENCES vacina (id_vac) ON DELETE CASCADE
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
    IF NOT EXISTS excluir_conta (
        code_email INT NOT NULL,
        email VARCHAR(255) NOT NULL,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
    );
    

-- SET @@global.time_zone = '-3:00';
-- SELECT @@global.time_zone, @@session.time_zone;