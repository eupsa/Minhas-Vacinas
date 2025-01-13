-- SEMPRE EXECUTAR TUDO --
-- SET GLOBAL event_scheduler = ON;
DELIMITER $$

CREATE EVENT limpar_tabelas
ON SCHEDULE EVERY 6 HOUR
DO
BEGIN
    TRUNCATE TABLE minhasvacinas.esqueceu_senha;
    TRUNCATE TABLE minhasvacinas.confirmar_cadastro;
    TRUNCATE TABLE minhasvacinas.excluir_conta;
    TRUNCATE TABLE minhasvacinas.mudar_email;
END $$

DELIMITER ;

SHOW EVENTS;
-- SEMPRE EXECUTAR TUDO --