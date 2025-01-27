SET sql_mode = 'STRICT_TRANS_TABLES';
SET time_zone = 'America/Sao_Paulo';
CREATE DATABASE IF NOT EXISTS minhasvacinas;
USE minhasvacinas;

CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    estado ENUM (
        'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 
        'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 
        'RR', 'SC', 'SP', 'SE', 'TO', 'N/A'
    ) DEFAULT 'N/A',
    senha VARCHAR(128),
    email_conf TINYINT(1) DEFAULT 0,
    data_nascimento DATE,
    genero ENUM ('Não Informado', 'Masculino', 'Feminino', 'Outro') DEFAULT 'Não Informado',
    cpf VARCHAR(14) UNIQUE,
    telefone VARCHAR(15),
    cidade VARCHAR(100) DEFAULT 'Não informado',
    ip_cadastro VARCHAR(45),
    foto_perfil LONGBLOB,
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

CREATE TABLE IF NOT EXISTS confirmar_cadastro (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    codigo VARCHAR(6) UNIQUE NOT NULL,
    FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS vacina (
    id_vac INT PRIMARY KEY AUTO_INCREMENT,
    imagem LONGBLOB,
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

CREATE TABLE IF NOT EXISTS postos_vacinacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    tipo VARCHAR(50),
    contato VARCHAR(20),
    adicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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
    email VARCHAR(255) NOT NULL
);

DELIMITER $$

CREATE TRIGGER after_usuario_insert
AFTER INSERT ON usuario
FOR EACH ROW
BEGIN
    INSERT INTO novidades (email) VALUES (NEW.email);
END$$

DELIMITER ;

SELECT @@global.time_zone, @@session.time_zone;