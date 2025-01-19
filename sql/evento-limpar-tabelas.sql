SET time_zone = 'America/Sao_Paulo';
SET GLOBAL event_scheduler = ON;

DELIMITER $$

CREATE EVENT IF NOT EXISTS limpar_tabelas
ON SCHEDULE EVERY 6 HOUR
DO
BEGIN
    TRUNCATE TABLE minhasvacinas.esqueceu_senha;
    TRUNCATE TABLE minhasvacinas.confirmar_cadastro;
    TRUNCATE TABLE minhasvacinas.excluir_conta;
    TRUNCATE TABLE minhasvacinas.mudar_email;
END $$

CREATE EVENT IF NOT EXISTS definir_fuso_horario
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
    SET time_zone = 'America/Sao_Paulo';
END $$

CREATE EVENT IF NOT EXISTS aplicar_regras_sql
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
    SET sql_mode = 'STRICT_TRANS_TABLES';
END $$

DELIMITER ;

SHOW EVENTS;
