CREATE DATABASE IF NOT EXISTS minhasvacinas;
USE minhasvacinas;

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
    
-- INSERT INTO usuario (nome, email, estado, senha, email_conf, data_nascimento, genero, cpf, telefone, cidade, user_root)
-- VALUES 
-- ('Pedro Silva', 'pedruuu291@gmail.com', 'BA', '$2y$10$R5ToR3.obbC1G4bnAzUkZeKTle45W3ywNtse8PeCvFTDTGHu2AudC', 1, '2007-02-15', 'Masculino', '086-415-560-90', '(71) 98765-4321', 'Salvador', 1);

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
    
INSERT INTO vacina 
    (nome_vac, data_aplicacao, proxima_dose, local_aplicacao, tipo, dose, lote, obs, id_user) 
VALUES
    ('Hepatite B', '2024-01-01', '2025-01-01', 'Clínica Saúde', 'Adulto', 1, 'L123', 'Primeira dose aplicada com sucesso.', 1),
    ('Febre Amarela', '2024-01-05', '2034-01-05', 'UBS Central', 'Adulto', 1, 'FA456', 'Vacina aplicada sem reações adversas.', 1),
    ('Tétano', '2024-01-10', NULL, 'Hospital Regional', 'Adulto', 2, 'T789', 'Reforço de tétano.', 1),
    ('COVID-19', '2024-01-15', '2025-01-15', 'Drive Thru Vacinas', 'Adulto', 3, 'C0123', 'Vacina bivalente.', 1),
    ('Influenza', '2024-01-20', NULL, 'Clínica Saúde', 'Adulto', 1, 'I987', 'Aplicação anual recomendada.', 1),
    ('Sarampo', '2024-01-25', '2026-01-25', 'Centro de Vacinação', 'Infantil', 2, 'S456', 'Primeira dose administrada.', 1),
    ('Poliomielite', '2024-01-30', NULL, 'UBS Oeste', 'Infantil', 3, 'P789', 'Vacina aplicada sem complicações.', 1),
    ('HPV', '2024-02-04', '2024-08-04', 'Clínica Especializada', 'Adulto', 1, 'H123', 'Primeira dose do ciclo.', 1),
    ('Meningite', '2024-02-09', '2024-08-09', 'Hospital Central', 'Adulto', 2, 'M456', 'Dose inicial administrada.', 1),
    ('Rotavírus', '2024-02-14', NULL, 'UBS Norte', 'Infantil', 1, 'R789', 'Vacina aplicada sem efeitos colaterais.', 1),
    -- Adicione mais entradas seguindo o padrão abaixo
    ('Difteria', '2024-02-19', NULL, 'Clínica Saúde', 'Adulto', 1, 'D012', 'Vacina aplicada com sucesso.', 1),
    ('Pneumocócica', '2024-02-24', '2025-02-24', 'Centro de Vacinação', 'Adulto', 1, 'P345', 'Primeira dose administrada.', 1),
    ('Varicela', '2024-02-28', '2025-02-28', 'UBS Central', 'Infantil', 2, 'V678', 'Vacina aplicada sem reações.', 1),
    ('Hepatite A', '2024-03-05', '2025-03-05', 'Clínica Especializada', 'Adulto', 1, 'HA901', 'Dose única aplicada.', 1),
    ('Meningocócica', '2024-03-10', NULL, 'Hospital Regional', 'Adulto', 2, 'MN234', 'Reforço administrado.', 1),
    ('HPV', '2024-03-15', '2024-09-15', 'Clínica Saúde', 'Adulto', 1, 'H567', 'Segunda dose do ciclo.', 1),
    ('Influenza', '2024-03-20', NULL, 'UBS Oeste', 'Adulto', 1, 'I890', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2024-03-25', '2025-03-25', 'Drive Thru Vacinas', 'Adulto', 3, 'C3456', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2024-03-30', '2026-03-30', 'Centro de Vacinação', 'Infantil', 2, 'S789', 'Segunda dose administrada.', 1),
    ('Poliomielite', '2024-04-04', NULL, 'UBS Norte', 'Infantil', 3, 'P0123', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2024-04-09', NULL, 'Hospital Central', 'Adulto', 2, 'T4567', 'Reforço administrado.', 1),
    ('Hepatite B', '2024-04-14', '2025-04-14', 'Clínica Especializada', 'Adulto', 1, 'L890', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2024-04-19', '2034-04-19', 'UBS Central', 'Adulto', 1, 'FA789', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2024-04-24', NULL, 'Clínica Saúde', 'Adulto', 1, 'D345', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2024-04-29', '2025-04-29', 'Centro de Vacinação', 'Adulto', 1, 'P678', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2024-05-04', '2025-05-04', 'UBS Central', 'Infantil', 2, 'V901', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2024-05-09', '2025-05-09', 'Clínica Especializada', 'Adulto', 1, 'HA234', 'Dose única aplicada.', 1),
    ('Meningocócica', '2024-05-14', NULL, 'Hospital Regional', 'Adulto', 2, 'MN567', 'Reforço administrado.', 1),
    ('HPV', '2024-05-19', '2024-11-19', 'Clínica Saúde', 'Adulto', 1, 'H890', 'Terceira dose do ciclo.', 1),
    ('Influenza', '2024-05-24', NULL, 'UBS Oeste', 'Adulto', 1, 'I123', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2024-05-29', '2025-05-29', 'Drive Thru Vacinas', 'Adulto', 3, 'C6789', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2024-06-03', '2026-06-03', 'Centro de Vacinação', 'Infantil', 2, 'S012', 'Terceira dose administrada.', 1),
    ('Poliomielite', '2024-06-08', NULL, 'UBS Norte', 'Infantil', 3, 'P3456', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2024-06-13', NULL, 'Hospital Central', 'Adulto', 2, 'T7890', 'Reforço administrado.', 1),
    ('Hepatite B', '2024-06-18', '2025-06-18', 'Clínica Especializada', 'Adulto', 1, 'L234', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2024-06-23', '2034-06-23', 'UBS Central', 'Adulto', 1, 'FA012', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2024-06-28', NULL, 'Clínica Saúde', 'Adulto', 1, 'D678', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2024-07-03', '2025-07-03', 'Centro de Vacinação', 'Adulto', 1, 'P901', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2024-07-08', '2025-07-08', 'UBS Central', 'Infantil', 2, 'V234', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2024-07-13', '2025-07-13', 'Clínica Especializada', 'Adulto', 1, 'HA567', 'Dose única aplicada.', 1),
    ('Meningocócica', '2024-07-18', NULL, 'Hospital Regional', 'Adulto', 2, 'MN890', 'Reforço administrado.', 1),
    ('HPV', '2024-07-23', '2024-01-23', 'Clínica Saúde', 'Adulto', 1, 'H345', 'Quarta dose do ciclo.', 1),
    ('Influenza', '2024-07-28', NULL, 'UBS Oeste', 'Adulto', 1, 'I456', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2024-08-02', '2025-08-02', 'Drive Thru Vacinas', 'Adulto', 3, 'C9012', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2024-08-07', '2026-08-07', 'Centro de Vacinação', 'Infantil', 2, 'S345', 'Quarta dose administrada.', 1),
    ('Poliomielite', '2024-08-12', NULL, 'UBS Norte', 'Infantil', 3, 'P6789', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2024-08-17', NULL, 'Hospital Central', 'Adulto', 2, 'T0123', 'Reforço administrado.', 1),
    ('Hepatite B', '2024-08-22', '2025-08-22', 'Clínica Especializada', 'Adulto', 1, 'L567', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2024-08-27', '2034-08-27', 'UBS Central', 'Adulto', 1, 'FA345', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2024-09-01', NULL, 'Clínica Saúde', 'Adulto', 1, 'D890', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2024-09-06', '2025-09-06', 'Centro de Vacinação', 'Adulto', 1, 'P678', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2024-09-11', '2025-09-11', 'UBS Central', 'Infantil', 2, 'V567', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2024-09-16', '2025-09-16', 'Clínica Especializada', 'Adulto', 1, 'HA890', 'Dose única aplicada.', 1),
    ('Meningocócica', '2024-09-21', NULL, 'Hospital Regional', 'Adulto', 2, 'MN345', 'Reforço administrado.', 1),
    ('HPV', '2024-09-26', '2024-03-26', 'Clínica Saúde', 'Adulto', 1, 'H678', 'Quinta dose do ciclo.', 1),
    ('Influenza', '2024-10-01', NULL, 'UBS Oeste', 'Adulto', 1, 'I789', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2024-10-06', '2025-10-06', 'Drive Thru Vacinas', 'Adulto', 3, 'C2345', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2024-10-11', '2026-10-11', 'Centro de Vacinação', 'Infantil', 2, 'S678', 'Quinta dose administrada.', 1),
    ('Poliomielite', '2024-10-16', NULL, 'UBS Norte', 'Infantil', 3, 'P9012', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2024-10-21', NULL, 'Hospital Central', 'Adulto', 2, 'T3456', 'Reforço administrado.', 1),
    ('Hepatite B', '2024-10-26', '2025-10-26', 'Clínica Especializada', 'Adulto', 1, 'L789', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2024-10-31', '2034-10-31', 'UBS Central', 'Adulto', 1, 'FA901', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2024-11-05', NULL, 'Clínica Saúde', 'Adulto', 1, 'D123', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2024-11-10', '2025-11-10', 'Centro de Vacinação', 'Adulto', 1, 'P345', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2024-11-15', '2025-11-15', 'UBS Central', 'Infantil', 2, 'V678', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2024-11-20', '2025-11-20', 'Clínica Especializada', 'Adulto', 1, 'HA012', 'Dose única aplicada.', 1),
    ('Meningocócica', '2024-11-25', NULL, 'Hospital Regional', 'Adulto', 2, 'MN567', 'Reforço administrado.', 1),
    ('HPV', '2024-11-30', '2024-05-30', 'Clínica Saúde', 'Adulto', 1, 'H890', 'Sexta dose do ciclo.', 1),
    ('Influenza', '2024-12-05', NULL, 'UBS Oeste', 'Adulto', 1, 'I012', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2024-12-10', '2025-12-10', 'Drive Thru Vacinas', 'Adulto', 3, 'C4567', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2024-12-15', '2026-12-15', 'Centro de Vacinação', 'Infantil', 2, 'S901', 'Sexta dose administrada.', 1),
    ('Poliomielite', '2024-12-20', NULL, 'UBS Norte', 'Infantil', 3, 'P2345', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2024-12-25', NULL, 'Hospital Central', 'Adulto', 2, 'T6789', 'Reforço administrado.', 1),
    ('Hepatite B', '2024-12-30', '2025-12-30', 'Clínica Especializada', 'Adulto', 1, 'L012', 'Segunda dose aplicada.', 1),
    
    -- Continuando até 100 registros
    ('Febre Amarela', '2025-01-04', '2035-01-04', 'UBS Central', 'Adulto', 1, 'FA234', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2025-01-09', NULL, 'Clínica Saúde', 'Adulto', 1, 'D456', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2025-01-14', '2026-01-14', 'Centro de Vacinação', 'Adulto', 1, 'P567', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2025-01-19', '2026-01-19', 'UBS Central', 'Infantil', 2, 'V789', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2025-01-24', '2026-01-24', 'Clínica Especializada', 'Adulto', 1, 'HA345', 'Dose única aplicada.', 1),
    ('Meningocócica', '2025-01-29', NULL, 'Hospital Regional', 'Adulto', 2, 'MN678', 'Reforço administrado.', 1),
    ('HPV', '2025-02-03', '2024-08-03', 'Clínica Saúde', 'Adulto', 1, 'H012', 'Sétima dose do ciclo.', 1),
    ('Influenza', '2025-02-08', NULL, 'UBS Oeste', 'Adulto', 1, 'I234', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2025-02-13', '2026-02-13', 'Drive Thru Vacinas', 'Adulto', 3, 'C7890', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2025-02-18', '2027-02-18', 'Centro de Vacinação', 'Infantil', 2, 'S234', 'Sétima dose administrada.', 1),
    ('Poliomielite', '2025-02-23', NULL, 'UBS Norte', 'Infantil', 3, 'P5678', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2025-02-28', NULL, 'Hospital Central', 'Adulto', 2, 'T9012', 'Reforço administrado.', 1),
    ('Hepatite B', '2025-03-05', '2026-03-05', 'Clínica Especializada', 'Adulto', 1, 'L345', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2025-03-10', '2035-03-10', 'UBS Central', 'Adulto', 1, 'FA456', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2025-03-15', NULL, 'Clínica Saúde', 'Adulto', 1, 'D789', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2025-03-20', '2026-03-20', 'Centro de Vacinação', 'Adulto', 1, 'P890', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2025-03-25', '2026-03-25', 'UBS Central', 'Infantil', 2, 'V012', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2025-03-30', '2026-03-30', 'Clínica Especializada', 'Adulto', 1, 'HA456', 'Dose única aplicada.', 1),
    ('Meningocócica', '2025-04-04', NULL, 'Hospital Regional', 'Adulto', 2, 'MN901', 'Reforço administrado.', 1),
    ('HPV', '2025-04-09', '2024-10-09', 'Clínica Saúde', 'Adulto', 1, 'H345', 'Oitava dose do ciclo.', 1),
    ('Influenza', '2025-04-14', NULL, 'UBS Oeste', 'Adulto', 1, 'I345', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2025-04-19', '2026-04-19', 'Drive Thru Vacinas', 'Adulto', 3, 'C01234', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2025-04-24', '2027-04-24', 'Centro de Vacinação', 'Infantil', 2, 'S567', 'Oitava dose administrada.', 1),
    ('Poliomielite', '2025-04-29', NULL, 'UBS Norte', 'Infantil', 3, 'P8901', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2025-05-04', NULL, 'Hospital Central', 'Adulto', 2, 'T2345', 'Reforço administrado.', 1),
    ('Hepatite B', '2025-05-09', '2026-05-09', 'Clínica Especializada', 'Adulto', 1, 'L456', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2025-05-14', '2035-05-14', 'UBS Central', 'Adulto', 1, 'FA567', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2025-05-19', NULL, 'Clínica Saúde', 'Adulto', 1, 'D890', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2025-05-24', '2026-05-24', 'Centro de Vacinação', 'Adulto', 1, 'P901', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2025-05-29', '2026-05-29', 'UBS Central', 'Infantil', 2, 'V345', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2025-06-03', '2026-06-03', 'Clínica Especializada', 'Adulto', 1, 'HA789', 'Dose única aplicada.', 1),
    ('Meningocócica', '2025-06-08', NULL, 'Hospital Regional', 'Adulto', 2, 'MN234', 'Reforço administrado.', 1),
    ('HPV', '2025-06-13', '2024-12-13', 'Clínica Saúde', 'Adulto', 1, 'H678', 'Nona dose do ciclo.', 1),
    ('Influenza', '2025-06-18', NULL, 'UBS Oeste', 'Adulto', 1, 'I456', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2025-06-23', '2026-06-23', 'Drive Thru Vacinas', 'Adulto', 3, 'C3456', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2025-06-28', '2027-06-28', 'Centro de Vacinação', 'Infantil', 2, 'S678', 'Nona dose administrada.', 1),
    ('Poliomielite', '2025-07-03', NULL, 'UBS Norte', 'Infantil', 3, 'P1234', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2025-07-08', NULL, 'Hospital Central', 'Adulto', 2, 'T5678', 'Reforço administrado.', 1),
    ('Hepatite B', '2025-07-13', '2026-07-13', 'Clínica Especializada', 'Adulto', 1, 'L678', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2025-07-18', '2035-07-18', 'UBS Central', 'Adulto', 1, 'FA678', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2025-07-23', NULL, 'Clínica Saúde', 'Adulto', 1, 'D901', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2025-07-28', '2026-07-28', 'Centro de Vacinação', 'Adulto', 1, 'P012', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2025-08-02', '2026-08-02', 'UBS Central', 'Infantil', 2, 'V678', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2025-08-07', '2026-08-07', 'Clínica Especializada', 'Adulto', 1, 'HA890', 'Dose única aplicada.', 1),
    ('Meningocócica', '2025-08-12', NULL, 'Hospital Regional', 'Adulto', 2, 'MN345', 'Reforço administrado.', 1),
    ('HPV', '2025-08-17', '2025-02-17', 'Clínica Saúde', 'Adulto', 1, 'H789', 'Décima dose do ciclo.', 1),
    ('Influenza', '2025-08-22', NULL, 'UBS Oeste', 'Adulto', 1, 'I567', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2025-08-27', '2026-08-27', 'Drive Thru Vacinas', 'Adulto', 3, 'C4567', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2025-09-01', '2027-09-01', 'Centro de Vacinação', 'Infantil', 2, 'S789', 'Décima dose administrada.', 1),
    ('Poliomielite', '2025-09-06', NULL, 'UBS Norte', 'Infantil', 3, 'P2345', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2025-09-11', NULL, 'Hospital Central', 'Adulto', 2, 'T7890', 'Reforço administrado.', 1),
    ('Hepatite B', '2025-09-16', '2026-09-16', 'Clínica Especializada', 'Adulto', 1, 'L890', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2025-09-21', '2035-09-21', 'UBS Central', 'Adulto', 1, 'FA901', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2025-09-26', NULL, 'Clínica Saúde', 'Adulto', 1, 'D234', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2025-09-30', '2026-09-30', 'Centro de Vacinação', 'Adulto', 1, 'P345', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2025-10-05', '2026-10-05', 'UBS Central', 'Infantil', 2, 'V901', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2025-10-10', '2026-10-10', 'Clínica Especializada', 'Adulto', 1, 'HA012', 'Dose única aplicada.', 1),
    ('Meningocócica', '2025-10-15', NULL, 'Hospital Regional', 'Adulto', 2, 'MN456', 'Reforço administrado.', 1),
    ('HPV', '2025-10-20', '2025-04-20', 'Clínica Saúde', 'Adulto', 1, 'H0123', 'Décima primeira dose do ciclo.', 1),
    ('Influenza', '2025-10-25', NULL, 'UBS Oeste', 'Adulto', 1, 'I678', 'Aplicação anual recomendada.', 1),
    ('COVID-19', '2025-10-30', '2026-10-30', 'Drive Thru Vacinas', 'Adulto', 3, 'C5678', 'Dose de reforço aplicada.', 1),
    ('Sarampo', '2025-11-04', '2027-11-04', 'Centro de Vacinação', 'Infantil', 2, 'S012', 'Décima primeira dose administrada.', 1),
    ('Poliomielite', '2025-11-09', NULL, 'UBS Norte', 'Infantil', 3, 'P3456', 'Vacina aplicada com sucesso.', 1),
    ('Tétano', '2025-11-14', NULL, 'Hospital Central', 'Adulto', 2, 'T8901', 'Reforço administrado.', 1),
    ('Hepatite B', '2025-11-19', '2026-11-19', 'Clínica Especializada', 'Adulto', 1, 'L0123', 'Segunda dose aplicada.', 1),
    ('Febre Amarela', '2025-11-24', '2035-11-24', 'UBS Central', 'Adulto', 1, 'FA123', 'Vacina aplicada sem complicações.', 1),
    ('Difteria', '2025-11-29', NULL, 'Clínica Saúde', 'Adulto', 1, 'D567', 'Vacina administrada com sucesso.', 1),
    ('Pneumocócica', '2025-12-04', '2026-12-04', 'Centro de Vacinação', 'Adulto', 1, 'P678', 'Dose de reforço aplicada.', 1),
    ('Varicela', '2025-12-09', '2026-12-09', 'UBS Central', 'Infantil', 2, 'V234', 'Segunda dose administrada.', 1),
    ('Hepatite A', '2025-12-14', '2026-12-14', 'Clínica Especializada', 'Adulto', 1, 'HA345', 'Dose única aplicada.', 1),
    ('Meningocócica', '2025-12-19', NULL, 'Hospital Regional', 'Adulto', 2, 'MN789', 'Reforço administrado.', 1),
    ('HPV', '2025-12-24', '2025-06-24', 'Clínica Saúde', 'Adulto', 1, 'H3456', 'Décima segunda dose do ciclo.', 1),
    ('Influenza', '2025-12-29', NULL, 'UBS Oeste', 'Adulto', 1, 'I890', 'Aplicação anual recomendada.', 1);


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
    
    
DELETE FROM `minhasvacinas`.`esqueceu_senha` WHERE (`email` = 'pedruuu291@gmail.com');


CREATE TABLE
    IF NOT EXISTS excluir_conta (
        code_email INT NOT NULL,
        email VARCHAR(255) NOT NULL,
        FOREIGN KEY (email) REFERENCES usuario (email) ON DELETE CASCADE
    );
  
CREATE TABLE 
	IF NOT EXISTS cidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    estado VARCHAR(100) NOT NULL
);

    

-- SET @@global.time_zone = '-3:00';
-- SELECT @@global.time_zone, @@session.time_zone;
-- SET time_zone = 'America/Sao_Paulo';