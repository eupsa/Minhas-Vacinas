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
        xmlhttp.open("GET", 'https://api.ipify.org?format=json', true); // Usando ipify API
        xmlhttp.send();
        xmlhttp.onload = function(e) {
            if (xmlhttp.status === 200) {
                var data = JSON.parse(xmlhttp.responseText);
                alert("Seu IP é: " + data.ip); // Exibe o IP
            } else {
                alert("Erro ao obter o IP. Status: " + xmlhttp.status);
            }
        };

        xmlhttp.onerror = function() {
            alert("Erro de conexão. Não foi possível acessar o servidor.");
        };
    </script>
</body>

</html>