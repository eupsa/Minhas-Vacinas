SET sql_mode = 'STRICT_TRANS_TABLES';
-- SET time_zone = 'America/Sao_Paulo';
CREATE DATABASE IF NOT EXISTS minhasvacinas;
USE minhasvacinas;

CREATE TABLE 
	IF NOT EXISTS usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    estado ENUM (
        'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 
        'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 
        'RR', 'SC', 'SP', 'SE', 'TO', 'N/A'
    ) DEFAULT 'N/A',
    senha VARCHAR(255),
    email_conf TINYINT(1) DEFAULT 0,
    data_nascimento DATE,
    genero ENUM ('Não Informado', 'Masculino', 'Feminino', 'Outro') DEFAULT 'Não Informado',
    cpf VARCHAR(14),
    telefone VARCHAR(15),
    cidade VARCHAR(100) DEFAULT 'Não informado',
    ip_cadastro VARCHAR(45),
    foto_perfil VARCHAR (200),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE 
	IF NOT EXISTS usuario_google (
    id_usuario_google INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    google_id VARCHAR(255) NOT NULL UNIQUE,
    foto_url VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

CREATE TABLE 
	IF NOT EXISTS admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nome_admin VARCHAR (100) NOT NULL,
    email_admin VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(128), 
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS confirmar_cadastro (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    codigo VARCHAR(6) UNIQUE NOT NULL,
    
    FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS vacina (
    id_vac INT PRIMARY KEY AUTO_INCREMENT,
    nome_vac VARCHAR(255) NOT NULL,
    data_aplicacao DATE NOT NULL,
    proxima_dose DATE,
    local_aplicacao VARCHAR(200) NOT NULL,
    tipo ENUM (
        'Imunização', 'Vacina de Vírus Vivo Atenuado', 'Vacina de Vírus Inativado', 
        'Vacina Subunitária', 'Vacina de RNA Mensageiro (mRNA)', 'Vacina de Vetor Viral', 
        'Vacina de Proteína Recombinante'
    ) NOT NULL,
    dose VARCHAR(50) NOT NULL,
    lote VARCHAR(50),
    obs VARCHAR(200),
    path_card VARCHAR (200),
    data_adicao DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS esqueceu_senha (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    data_expiracao DATETIME NOT NULL,
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS mudar_email (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    codigo VARCHAR(255) NOT NULL,
    data_adicao DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS excluir_conta (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
	codigo INT NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS vacinas_existentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_vac VARCHAR(255) NOT NULL,
    tipo VARCHAR(100),
    descricao TEXT,
    adicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO vacinas_existentes (nome_vac, tipo, descricao) VALUES
('BCG', 'Vacina de Vírus Vivo Atenuado', 'Vacina contra a tuberculose, aplicada logo após o nascimento.'),
('Hepatite A', 'Vacina de Vírus Inativado', 'Vacina contra o vírus da Hepatite A, transmitido principalmente por alimentos e água contaminada.'),
('Hepatite B', 'Vacina de Proteína Recombinante', 'Vacina contra o vírus da Hepatite B, administrada em três doses.'),
('Penta', 'Vacina de Proteína Recombinante', 'Vacina combinada contra difteria, tétano, coqueluche, Hib e hepatite B.'),
('Pneumocócica 10-valente', 'Vacina de Polissacarídeo', 'Vacina contra infecções causadas pela bactéria pneumocócica, incluindo pneumonia e meningite.'),
('Vacina Inativada Poliomielite (VIP)', 'Vacina de Vírus Inativado', 'Vacina inativada contra a poliomielite, administrada em várias doses.'),
('Vacina Oral Poliomielite (VOP)', 'Vacina de Vírus Vivo Atenuado', 'Vacina oral contra a poliomielite, administrada em várias doses.'),
('Vacina Rotavírus Humano (VRH)', 'Vacina de Vírus Vivo Atenuado', 'Vacina contra o rotavírus, causador de diarreia grave em crianças.'),
('Meningocócica C (conjugada)', 'Vacina de Polissacarídeo', 'Vacina contra meningite causada pelo meningococo do tipo C.'),
('Febre Amarela', 'Vacina de Vírus Vivo Atenuado', 'Vacina contra o vírus da febre amarela, indicada para regiões de risco.'),
('Tríplice Viral', 'Vacina de Vírus Vivo Atenuado', 'Vacina combinada contra sarampo, caxumba e rubéola.'),
('Tetraviral', 'Vacina de Vírus Vivo Atenuado', 'Vacina combinada contra sarampo, caxumba, rubéola e varicela.'),
('DTP', 'Vacina de Vetor Viral', 'Vacina contra difteria, tétano e coqueluche, administrada em várias doses.'),
('Varicela', 'Vacina de Vírus Vivo Atenuado', 'Vacina contra a varicela (catapora), indicada principalmente para crianças.'),
('HPV Quadrivalente', 'Vacina de Proteína Recombinante', 'Vacina contra o Papilomavírus Humano, que pode causar câncer de colo de útero.'),
('dT', 'Vacina de Vetor Viral', 'Vacina dupla contra difteria e tétano, indicada para adultos.'),
('dTpa', 'Vacina de Vetor Viral', 'Vacina contra difteria, tétano e coqueluche acelular, indicada para adultos e crianças.'),
('Meningocócica ACWY', 'Vacina de Polissacarídeo', 'Vacina contra meningite causada pelos meningococos dos tipos A, C, W e Y.');

CREATE TABLE IF NOT EXISTS ip_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45) NOT NULL,
    cidade VARCHAR(255),
    estado VARCHAR(255),
    pais VARCHAR(255),
    empresa VARCHAR(255),
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS dispositivos (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    id_usuario INT NOT NULL,
    nome_dispositivo VARCHAR(255) NOT NULL,
    tipo_dispositivo VARCHAR(100),
    ip VARCHAR(45),
    cidade VARCHAR(255),
    estado VARCHAR(255),
    pais VARCHAR(255),
    navegador VARCHAR(255),
    confirmado BOOLEAN DEFAULT 0,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS novidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS suporte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(100) NOT NULL,
    email_usuario VARCHAR(100) NOT NULL,
    motivo_contato VARCHAR(50) NOT NULL,
    mensagem TEXT,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE
	IF NOT EXISTS 2FA (
	id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    chave_secreta VARCHAR (100) NOT NULL UNIQUE,
    adicao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
);

DELIMITER $$

CREATE TRIGGER Cadastro_Novidades
AFTER INSERT ON usuario
FOR EACH ROW
BEGIN
    INSERT INTO novidades (email) VALUES (NEW.email);
END$$

DELIMITER ;

DELIMITER $$

CREATE EVENT IF NOT EXISTS LimparTabelas
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    TRUNCATE TABLE minhasvacinas.esqueceu_senha;
    TRUNCATE TABLE minhasvacinas.confirmar_cadastro;
    TRUNCATE TABLE minhasvacinas.excluir_conta;
    TRUNCATE TABLE minhasvacinas.mudar_email;
END $$

-- CREATE EVENT IF NOT EXISTS definir_fuso_horario
-- ON SCHEDULE EVERY 1 HOUR
-- DO
-- BEGIN
--     SET time_zone = 'America/Sao_Paulo';
-- END $$

DELIMITER ;

SHOW EVENTS;

SELECT * FROM .triggers;