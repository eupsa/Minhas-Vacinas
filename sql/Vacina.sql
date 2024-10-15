CREATE DATABASE IF NOT EXISTS Vacina;
USE Vacina;

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
    cidade VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS vacina (
    idVacina BIGINT PRIMARY KEY AUTO_INCREMENT,
    nomeVac VARCHAR(100) NOT NULL,
    data_vacina DATE NOT NULL,              
    tipo VARCHAR(50) NOT NULL,
    dose INT,                               
    lote VARCHAR(50),                       
    obs TEXT                                
);

CREATE TABLE IF NOT EXISTS usuario_vacina (
    idUsuario BIGINT,
    idVacina BIGINT,
    data_vacina DATE,
    PRIMARY KEY (idUsuario, idVacina),
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuarios) ON DELETE CASCADE,
    FOREIGN KEY (idVacina) REFERENCES vacina(idVacina) ON DELETE CASCADE
);
