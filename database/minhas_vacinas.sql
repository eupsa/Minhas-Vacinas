CREATE DATABASE IF NOT EXISTS minhas_vacinas;
USE minhas_vacinas;

CREATE TABLE IF NOT EXISTS usuario (
    id_user BIGINT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    estado VARCHAR(2) NOT NULL,
    senha VARCHAR(128) NOT NULL,
    email_conf TINYINT(1) DEFAULT 0,
    data_nascimento date,
    genero VARCHAR(10),
    cpf VARCHAR(16) UNIQUE,
    telefone VARCHAR(15),
    cidade VARCHAR(100),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_root TINYINT(1) DEFAULT 0,
    root_user VARCHAR (20)
);

CREATE TABLE IF NOT EXISTS vacina (
    id_vac BIGINT PRIMARY KEY AUTO_INCREMENT,
    nome_vac VARCHAR(100) NOT NULL,
    data_aplicacao DATE NOT NULL,
    local_aplicacao VARCHAR (200) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    dose INT,
    lote VARCHAR(50),
    obs TEXT,
    id_user BIGINT,
    CONSTRAINT fk_usuario FOREIGN KEY (id_user) REFERENCES usuario(id_user) ON DELETE SET NULL
);

INSERT INTO vacina (nome_vac, data_aplicacao, local_aplicacao, tipo, dose, lote, obs, id_user) VALUES
('Hepatite B', '2022-12-21', 'UBS Sul', 'Intramuscular', 1, 'Lote8868', 'Observação sobre a aplicação de Hepatite B.', 2),
('Meningite C', '2020-04-29', 'UBS Sul', 'Injetável', 2, 'Lote8417', 'Observação sobre a aplicação de Meningite C.', 2),
('Meningite C', '2021-07-15', 'UBS Central', 'Intramuscular', 2, 'Lote8039', 'Observação sobre a aplicação de Meningite C.', 2),
('Varicela', '2022-06-02', 'UBS Norte', 'Injetável', 1, 'Lote5557', 'Observação sobre a aplicação de Varicela.', 2),
('DTP', '2021-10-22', 'UBS Sul', 'Oral', 1, 'Lote6574', 'Observação sobre a aplicação de DTP.', 2),
('Febre Amarela', '2021-03-05', 'UBS Sul', 'Injetável', 1, 'Lote9845', 'Observação sobre a aplicação de Febre Amarela.', 2),
('Tétano', '2022-05-12', 'UBS Norte', 'Intramuscular', 3, 'Lote2391', 'Observação sobre a aplicação de Tétano.', 2),
('Hepatite A', '2020-08-13', 'UBS Central', 'Injetável', 1, 'Lote7612', 'Observação sobre a aplicação de Hepatite A.', 2),
('Sarampo', '2022-11-30', 'UBS Sul', 'Injetável', 1, 'Lote5446', 'Observação sobre a aplicação de Sarampo.', 2),
('HPV', '2022-01-10', 'UBS Norte', 'Intramuscular', 1, 'Lote2945', 'Observação sobre a aplicação de HPV.', 2),
('Influenza', '2023-05-17', 'UBS Central', 'Intramuscular', 1, 'Lote4441', 'Observação sobre a aplicação de Influenza.', 2),
('Pneumocócica', '2021-06-25', 'UBS Sul', 'Injetável', 2, 'Lote1210', 'Observação sobre a aplicação de Pneumocócica.', 2),
('BCG', '2020-12-05', 'UBS Norte', 'Intradérmica', 1, 'Lote8094', 'Observação sobre a aplicação de BCG.', 2),
('Hepatite B', '2021-09-23', 'UBS Central', 'Intramuscular', 1, 'Lote6478', 'Observação sobre a aplicação de Hepatite B.', 2),
('Meningite C', '2021-04-30', 'UBS Sul', 'Injetável', 1, 'Lote5192', 'Observação sobre a aplicação de Meningite C.', 2),
('Varicela', '2022-07-18', 'UBS Norte', 'Injetável', 1, 'Lote3592', 'Observação sobre a aplicação de Varicela.', 2),
('DTP', '2021-11-14', 'UBS Sul', 'Oral', 2, 'Lote8263', 'Observação sobre a aplicação de DTP.', 2),
('Febre Amarela', '2021-04-20', 'UBS Norte', 'Injetável', 1, 'Lote7182', 'Observação sobre a aplicação de Febre Amarela.', 2),
('Tétano', '2022-08-06', 'UBS Central', 'Intramuscular', 3, 'Lote6237', 'Observação sobre a aplicação de Tétano.', 2),
('Hepatite A', '2021-01-17', 'UBS Sul', 'Injetável', 1, 'Lote3407', 'Observação sobre a aplicação de Hepatite A.', 2),
('Sarampo', '2023-03-22', 'UBS Norte', 'Injetável', 2, 'Lote8051', 'Observação sobre a aplicação de Sarampo.', 2),
('HPV', '2021-09-09', 'UBS Sul', 'Intramuscular', 1, 'Lote6640', 'Observação sobre a aplicação de HPV.', 2),
('Influenza', '2022-02-26', 'UBS Norte', 'Intramuscular', 1, 'Lote1938', 'Observação sobre a aplicação de Influenza.', 2),
('Pneumocócica', '2021-11-11', 'UBS Sul', 'Injetável', 2, 'Lote2949', 'Observação sobre a aplicação de Pneumocócica.', 2),
('BCG', '2020-09-13', 'UBS Central', 'Intradérmica', 1, 'Lote3091', 'Observação sobre a aplicação de BCG.', 2),
('Hepatite B', '2023-07-09', 'UBS Norte', 'Intramuscular', 1, 'Lote4785', 'Observação sobre a aplicação de Hepatite B.', 2),
('Meningite C', '2021-08-18', 'UBS Central', 'Injetável', 2, 'Lote6847', 'Observação sobre a aplicação de Meningite C.', 2),
('Varicela', '2022-10-29', 'UBS Norte', 'Injetável', 2, 'Lote4932', 'Observação sobre a aplicação de Varicela.', 2),
('DTP', '2021-05-05', 'UBS Sul', 'Oral', 1, 'Lote1774', 'Observação sobre a aplicação de DTP.', 2),
('Febre Amarela', '2021-03-08', 'UBS Norte', 'Injetável', 2, 'Lote9148', 'Observação sobre a aplicação de Febre Amarela.', 2),
('Tétano', '2022-06-29', 'UBS Central', 'Intramuscular', 1, 'Lote5431', 'Observação sobre a aplicação de Tétano.', 2),
('Hepatite A', '2021-10-04', 'UBS Sul', 'Injetável', 2, 'Lote6056', 'Observação sobre a aplicação de Hepatite A.', 2),
('Sarampo', '2021-09-29', 'UBS Norte', 'Injetável', 1, 'Lote7399', 'Observação sobre a aplicação de Sarampo.', 2),
('HPV', '2022-05-02', 'UBS Sul', 'Intramuscular', 1, 'Lote2090', 'Observação sobre a aplicação de HPV.', 2),
('Influenza', '2023-01-15', 'UBS Central', 'Intramuscular', 2, 'Lote4055', 'Observação sobre a aplicação de Influenza.', 2),
('Pneumocócica', '2021-09-06', 'UBS Norte', 'Injetável', 2, 'Lote2876', 'Observação sobre a aplicação de Pneumocócica.', 2),
('BCG', '2020-11-19', 'UBS Sul', 'Intradérmica', 1, 'Lote9645', 'Observação sobre a aplicação de BCG.', 2),
('Hepatite B', '2021-12-16', 'UBS Norte', 'Intramuscular', 2, 'Lote8125', 'Observação sobre a aplicação de Hepatite B.', 2),
('Meningite C', '2021-02-04', 'UBS Sul', 'Injetável', 1, 'Lote4269', 'Observação sobre a aplicação de Meningite C.', 2),
('Varicela', '2021-11-12', 'UBS Norte', 'Injetável', 1, 'Lote3881', 'Observação sobre a aplicação de Varicela.', 2),
('DTP', '2021-07-07', 'UBS Central', 'Oral', 2, 'Lote5214', 'Observação sobre a aplicação de DTP.', 2),
('Febre Amarela', '2023-04-14', 'UBS Sul', 'Injetável', 2, 'Lote1296', 'Observação sobre a aplicação de Febre Amarela.', 2),
('Tétano', '2022-07-27', 'UBS Norte', 'Intramuscular', 1, 'Lote9685', 'Observação sobre a aplicação de Tétano.', 2),
('Hepatite A', '2020-05-20', 'UBS Central', 'Injetável', 2, 'Lote5172', 'Observação sobre a aplicação de Hepatite A.', 2),
('Sarampo', '2023-02-10', 'UBS Sul', 'Injetável', 1, 'Lote5728', 'Observação sobre a aplicação de Sarampo.', 2),
('HPV', '2021-06-15', 'UBS Norte', 'Intramuscular', 1, 'Lote4082', 'Observação sobre a aplicação de HPV.', 2),
('Influenza', '2022-12-11', 'UBS Sul', 'Intramuscular', 2, 'Lote1335', 'Observação sobre a aplicação de Influenza.', 2),
('Pneumocócica', '2020-10-22', 'UBS Central', 'Injetável', 1, 'Lote4426', 'Observação sobre a aplicação de Pneumocócica.', 2);

CREATE TABLE IF NOT EXISTS usuario_vacina (
    id_user BIGINT,
    id_vac BIGINT,
    data_aplicacao DATE,
    PRIMARY KEY (id_user, id_vac),
    FOREIGN KEY (id_user) REFERENCES usuario(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_vac) REFERENCES vacina(id_vac) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS esqueceu_senha (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    token VARCHAR(255) NOT NULL,
    data_expiracao DATETIME NOT NULL,
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (email) REFERENCES usuario(email) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS troca_email (
	email VARCHAR(255) UNIQUE NOT NULL,
    codigo INT NOT NULL
);

-- DELETE FROM `db_mv`.`excluir_conta` WHERE (`email` = 'pedruuu291@gmail.com');

#INSERT INTO usuario (nome, email, estado, senha) 
#VALUES ('Adm_Pedro', 'pedrooosxz@gmail.com', 'BA', SHA2('Chicote1@', 256));

#select * from usuario where email ='pedruuuyt291@gmail.com';

#UPDATE usuario SET email_conf = 1 WHERE email = 'viskp2537@gmail.com'

-- INSERT INTO usuario (nome, email, estado, senha, idade, genero, cpf, telefone, cidade) 
-- VALUES ('João Silva', 'joao@example.com', 'SP', 'senha123', 30, 'Masculino', '123.456.789-00', '11987654321', 'São Paulo');

-- INSERT INTO vacina (nomeVac, dataVacina, tipo, dose, lote, obs, idUsuario) 
-- VALUES ('Vacina XYZ', '2024-01-01', 'Reforço', 1, 'Lote123', 'Nenhuma observação', 1);

-- SELECT 
--     v.idVacina,
--     v.nomeVac,
--     v.dataVacina,
--     v.tipo,
--     v.dose,
--     v.lote,
--     v.obs,
--     u.idUsuarios,
--     u.nome AS nomeUsuario
-- FROM 
--     vacina v
-- LEFT JOIN 
--     usuario u ON v.idUsuario = u.idUsuarios;


-- SELECT * FROM usuario WHERE email = 'pedruuu291@gmail.com' AND senha = SHA2('Chicote1@', 256) AND emailConf = 1;

-- INSERT INTO usuario (nome, email, estado, senha, emailConf, idade, genero, cpf, telefone, cidade)
-- VALUES 
-- ('Pedro', 'viskp25a37a@gmail.com', 'BA', SHA2('Chicote1@', 256), 1, 17, 'Masculino', '123.126.789-09', '(71) 98344-2945', 'Salvador');

-- select , estado, emailConf, , , , telefone, cidade from usuario where email = 'joao.silva@example.com';

-- UPDATE usuario SET nome = 'Paula', estado = 'SP' WHERE idUsuarios = 4

-- DELETE FROM usuario WHERE email = 'viskp2537@gmail.com';

-- DELETE FROM usuario;

-- SET SQL_SAFE_UPDATES = 0;

-- SET @@global.time_zone = '-3:00';

-- SELECT @@global.time_zone, @@session.time_zone;

-- UPDATE usuario SET emailConf = 0 WHERE email = 'pedruuu291@gmail.com'

-- INSERT INTO usuario (nome, email, estado, senha, emailConf, idade, genero, cpf, telefone, cidade)
-- VALUES ('Pedro', 'pedruuu291@gmail.com', 'BA', SHA2('Chicote1@', 256), 1, 18, 'Masculino', '123.456.789-00', '(11) 98765-4321', 'São Paulo');