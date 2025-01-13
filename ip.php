<?php
$ip = $_SERVER['REMOTE_ADDR'];
echo "Seu IP público é: " . $ip;
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturar IP Público IPv4</title>
</head>

<body>
    <h1>Seu IP Público (Somente IPv4)</h1>
    <p id="ip-info">Carregando...</p>

    <script>
        // Função para capturar o IP usando a API de endereço IP público
        function getIP() {
            fetch('https://api-bdc.net/data/client-ip')
                .then(response => response.json()) // Converte a resposta para JSON
                .then(data => {
                    // Verifica se o tipo de IP é "IPv4"
                    if (data.ipType === "IPv4") {
                        // Exibe o IP público IPv4 na página
                        document.getElementById('ip-info').innerText = `Seu IP público IPv4 é: ${data.ipString}`;
                    } else {
                        document.getElementById('ip-info').innerText = 'O seu IP não é IPv4.';
                    }
                })
                .catch(error => {
                    // Caso haja um erro na requisição
                    document.getElementById('ip-info').innerText = 'Não foi possível capturar o IP.';
                    console.error('Erro ao capturar o IP:', error);
                });
        }

        // Chama a função para obter o IP quando a página carregar
        getIP();
    </script>
</body>

</html>