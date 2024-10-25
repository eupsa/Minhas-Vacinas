CREATE DATABASE IF NOT EXISTS MinhasVacinas;
USE MinhasVacinas;

CREATE TABLE IF NOT EXISTS usuario (
    idUsuarios BIGINT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    estado VARCHAR(2) NOT NULL,
    senha VARCHAR(128) NOT NULL,
    emailConf TINYINT(1) DEFAULT 0,
    idade INT,
    genero VARCHAR(10),
    cpf VARCHAR(14) UNIQUE,
    telefone VARCHAR(15),
    cidade VARCHAR(100),
    dataCadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS vacina (
    idVacina BIGINT PRIMARY KEY AUTO_INCREMENT,
    nomeVac VARCHAR(100) NOT NULL,
    dataAplicacao DATE NOT NULL,
    localAplicacao VARCHAR (200) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    dose INT,
    lote VARCHAR(50),
    obs TEXT,
    idUsuario BIGINT,
    CONSTRAINT fk_usuario FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuarios) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS usuario_vacina (
    idUsuario BIGINT,
    idVacina BIGINT,
    dataVacina DATE,
    PRIMARY KEY (idUsuario, idVacina),
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuarios) ON DELETE CASCADE,
    FOREIGN KEY (idVacina) REFERENCES vacina(idVacina) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS redefinicaoSenha (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    token VARCHAR(255) NOT NULL,
    dataExpiracao DATETIME NOT NULL,
    dataSolicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (email) REFERENCES usuario(email) ON DELETE CASCADE
);

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