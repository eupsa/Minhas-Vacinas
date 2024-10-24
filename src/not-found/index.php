<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        animation: gradient 5s ease-in-out infinite;
        background: linear-gradient(-45deg, #A569BD, #76D7C4, #17202A, #641E16) no-repeat;
        background-size: 300% 300%;
        height: 100vh;
    }

    .container {
        width: 100%;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        text-align: center;
        color: whitesmoke;
    }

    .container h1 {
        font-size: 160px;
        margin: 0;
        font-weight: 900;
        letter-spacing: 20px;
    }

    .container h2 {
        font-size: 20pt;
    }

    .container p {
        font-size: 16pt;
    }

    .container a {
        text-decoration: none;
        background: #000080;
        padding: 16px 32px;
        display: inline-block;
        border-radius: 25px;
        border: none;
        font-size: 16pt;
        text-transform: uppercase;
        transition: 1s;
        letter-spacing: 1px;
        color: antiquewhite;
    }

    .container a:hover {
        background: none;
        border: none;
        opacity: inherit;
    }

    @keyframes gradient {
        0% {
            background-position: 0 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0 50%;
        }
    }
</style>

<body>
    <div class="container">
        <h2>Página não encontrada!</h2>
        <h1>404</h1>
        <p>Clique no botão para voltar!</p>
        <a href="/index.html">Voltar</a>
    </div>
</body>

</html>