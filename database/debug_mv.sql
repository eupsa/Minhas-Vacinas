CREATE DATABASE IF NOT EXISTS DB_MV;
USE DB_MV;

-- CREATE DATABASE IF NOT EXISTS minhas-vacinas;
-- USE minhas-vacinas;

CREATE TABLE
    IF NOT EXISTS USUARIO (
        ID_USER BIGINT PRIMARY KEY AUTO_INCREMENT,
        NOME VARCHAR(100) NOT NULL,
        EMAIL VARCHAR(255) UNIQUE NOT NULL,
        ESTADO VARCHAR(2) NOT NULL,
        SENHA VARCHAR(128) NOT NULL,
        EMAIL_CONF TINYINT(1) DEFAULT 0,
        DATA_NASCIMENTO DATE,
        GENERO VARCHAR(10),
        CPF VARCHAR(14) UNIQUE,
        TELEFONE VARCHAR(15),
        CIDADE VARCHAR(100),
        DATA_CADASTRO DATETIME DEFAULT CURRENT_TIMESTAMP,
        USER_ROOT TINYINT(1) DEFAULT 0
    );

CREATE TABLE
    IF NOT EXISTS VACINA (
        ID_VAC BIGINT PRIMARY KEY AUTO_INCREMENT,
        NOME_VAC VARCHAR(100) NOT NULL,
        DATA_APLICACAO DATE NOT NULL,
        PROXIMA_DOSE DATE,
        LOCAL_APLICACAO VARCHAR(200) NOT NULL,
        TIPO VARCHAR(50) NOT NULL,
        DOSE INT,
        LOTE VARCHAR(50),
        OBS TEXT,
        ID_USER BIGINT,
        CONSTRAINT FK_USUARIO FOREIGN KEY (ID_USER) REFERENCES USUARIO (ID_USER) ON DELETE SET NULL
    );

CREATE TABLE
    IF NOT EXISTS USUARIO_VACINA (
        ID_USER BIGINT,
        ID_VAC BIGINT,
        DATA_APLICACAO DATE,
        PRIMARY KEY (ID_USER, ID_VAC),
        FOREIGN KEY (ID_USER) REFERENCES USUARIO (ID_USER) ON DELETE CASCADE,
        FOREIGN KEY (ID_VAC) REFERENCES VACINA (ID_VAC) ON DELETE CASCADE
    );

CREATE TABLE
    IF NOT EXISTS ESQUECEU_SENHA (
        ID BIGINT PRIMARY KEY AUTO_INCREMENT,
        EMAIL VARCHAR(255) UNIQUE NOT NULL,
        TOKEN VARCHAR(255) NOT NULL,
        DATA_EXPIRACAO DATETIME NOT NULL,
        DATA_SOLICITACAO DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (EMAIL) REFERENCES USUARIO (EMAIL) ON DELETE CASCADE
    );

CREATE TABLE
    IF NOT EXISTS EXCLUIR_CONTA (
        CODE_EMAIL INT NOT NULL,
        EMAIL VARCHAR(255) NOT NULL,
        FOREIGN KEY (EMAIL) REFERENCES USUARIO (EMAIL) ON DELETE CASCADE
    );

DELETE FROM `DB_MV`.`EXCLUIR_CONTA` WHERE (`EMAIL` = 'PEDRUUU291@GMAIL.COM');

-- INSERT INTO usuario (nome, email, estado, senha) 
-- VALUES ('Adm_Pedro', 'pedrooosxz@gmail.com', 'BA', SHA2('Chicote1@', 256));
-- select * from usuario where email ='pedruuuyt291@gmail.com';
-- UPDATE usuario SET email_conf = 1 WHERE email = 'viskp2537@gmail.com'
-- INSERT INTO usuario (nome, email, estado, senha, idade, genero, cpf, telefone, cidade) 
-- VALUES ('João Silva', 'joao@example.com', 'SP', 'senha123', 30, 'Masculino', '123.456.789-00', '11987654321', 'São Paulo');
-- INSERT INTO vacina (nomeVac, dataVacina, tipo, dose, lote, obs, idUsuario) 
-- VALUES ('Vacina XYZ', '2024-01-01', 'Reforço', 1, 'Lote123', 'Nenhuma observação', 1);

-- select , estado, emailConf, , , , telefone, cidade from usuario where email = 'joao.silva@example.com';

-- UPDATE usuario SET nome = 'Paula', estado = 'SP' WHERE idUsuarios = 4

-- DELETE FROM usuario WHERE email = 'viskp2537@gmail.com';