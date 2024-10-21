<!-- require '../backend/scripts/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_GET['token'];
    $novaSenha = $_POST['nova_senha'];
    $confirmarSenha = $_POST['confirmar_senha'];

    if (empty($novaSenha) || empty($confirmarSenha)) {
        echo json_encode(['status' => false, 'msg' => 'Por favor, preencha todos os campos.']);
        exit();
    }

    if ($novaSenha !== $confirmarSenha) {
        echo json_encode(['status' => false, 'msg' => 'As senhas não coincidem.']);
        exit();
    }

    try {
        // Verifica se o token é válido e não expirou
        $sql = $pdo->prepare("SELECT * FROM redefinicaoSenha WHERE token = :token AND dataExpiracao > NOW()");
        $sql->bindValue(':token', $token);
        $sql->execute();

        if ($sql->rowCount() === 1) {
            $dadosToken = $sql->fetch(PDO::FETCH_ASSOC);
            $email = $dadosToken['email'];

            $hashSenha = password_hash($novaSenha, PASSWORD_DEFAULT);
            $sqlUpdateSenha = $pdo->prepare("UPDATE usuario SET senha = :senha WHERE email = :email");
            $sqlUpdateSenha->bindValue(':senha', $hashSenha);
            $sqlUpdateSenha->bindValue(':email', $email);
            $sqlUpdateSenha->execute();

            // Deleta o token após uso
            $sqlDeleteToken = $pdo->prepare("DELETE FROM redefinicaoSenha WHERE token = :token");
            $sqlDeleteToken->bindValue(':token', $token);
            $sqlDeleteToken->execute();

            echo json_encode(['status' => true, 'msg' => 'Senha alterada com sucesso!']);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Token inválido ou expirado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => false, 'msg' => 'Erro ao alterar a senha: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => false, 'msg' => 'Método inválido.']);
} -->


<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página em Construção</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <style>
        html,
        body {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
        }

        * {
            box-sizing: border-box;
        }

        body {
            text-align: center;
            background: #2a9df4;
            /* Azul de fundo */
            color: #fff;
            font-family: 'Open Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 100;
            margin-top: 20px;
        }

        article {
            width: 90%;
            max-width: 700px;
            padding: 20px;
            margin: 0 auto;
        }

        a {
            color: #ffdd57;
            /* Cor dos links */
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .loader {
            border: 8px solid rgba(255, 255, 255, 0.2);
            border-top: 8px solid #ffdd57;
            /* Cor da parte superior da engrenagem */
            border-radius: 50%;
            width: 75px;
            height: 75px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
            }

            article {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <article>
        <div class="loader"></div>
        <h1>Página em Construção!</h1>
        <div>
            <p>Desculpe pela inconveniência. Estamos trabalhando para melhorar nosso site. Enquanto isso, você pode nos
                seguir no <a href="https://x.com/pssilvagg">X</a> para atualizações. Em breve, estaremos de volta!</p>
            <p>Você pode voltar para a <a href="http://vacinas.agenci.one">página inicial</a>.</p>
            <p>&mdash; A Equipe do <a href="http://vacinas.agenci.one">vacinas.agenci.one</a></p>
        </div>
    </article>
</body>

</html>