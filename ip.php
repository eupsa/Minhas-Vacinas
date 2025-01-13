<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script>
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", 'https://meuip.com/api/meuip.php', true); // A requisição é assíncrona
        xmlhttp.send();
        xmlhttp.onload = function(e) {
            if (xmlhttp.status === 200) { // Verifica se a requisição foi bem-sucedida
                alert("Seu IP é: " + xmlhttp.responseText); // Corrige para 'responseText' para obter a resposta correta
            } else {
                alert("Erro ao obter o IP. Status: " + xmlhttp.status); // Exibe o status HTTP se falhar
            }
        };

        xmlhttp.onerror = function() {
            alert("Erro de conexão. Não foi possível acessar o servidor.");
        };
    </script>
</body>

</html>