<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login com Google</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function onGoogleSignIn(googleUser) {
            const token = googleUser.credential;

            // Envie o token ao backend para verificação e autenticação do usuário
            fetch('login_go.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        token
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Usuário autenticado
                        console.log('Login bem-sucedido', data);
                        window.location.href = '/dashboard'; // redirecionar após login
                    } else {
                        console.error('Erro de login', data.message);
                    }
                })
                .catch(error => console.error('Erro:', error));
        }
    </script>
</head>

<body>
    <div id="g_id_onload"
        data-client_id="AIzaSyBA2Alz5ZgpAdY84N8LouBa1qlsu5Sh2YU"
        data-context="signin"
        data-callback="onGoogleSignIn">
    </div>
    <div class="g_id_signin" data-type="standard"></div>
</body>

</html>