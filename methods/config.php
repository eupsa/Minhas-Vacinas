<?php

//try {
// Criando a conexão com o banco de dados
$pdo = new PDO("mysql:dbname=sosVacina;host=localhost:3306", "root", "");

// Configurar o PDO para lançar exceções em caso de erro
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* echo "Banco conectado com sucesso!";
} catch (PDOException $e) {
    // Exibir o erro se houver falha na conexão
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
}


Teste de conexão
$sql = $pdo->query('SELECT *FROM usuario');

$dados = $sql->fetchAll(pdo::FETCH_ASSOC);

echo '<pre>';

print_r($dados);
*/
