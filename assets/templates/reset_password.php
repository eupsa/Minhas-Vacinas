<?php
require '../../src/backend/scripts/const.php';
?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="x-apple-disable-message-reformatting" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="color-scheme" content="light dark" />
  <meta name="supported-color-schemes" content="light dark" />
  <title>Alteração de Senha</title>
  <style type="text/css" rel="stylesheet" media="all">
    /* Base ------------------------------ */
    @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");

    body {
      width: 100% !important;
      height: 100%;
      margin: 0;
      -webkit-text-size-adjust: none;
    }

    a {
      color: #3869D4;
    }

    td {
      word-break: break-word;
    }

    /* Type ------------------------------ */
    body,
    td,
    th {
      font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
    }

    h1 {
      margin-top: 0;
      color: #333333;
      font-size: 22px;
      font-weight: bold;
      text-align: left;
    }

    p {
      color: #51545E;
      font-size: 16px;
      line-height: 1.625;
      margin: 0.4em 0 1.1875em;
    }

    .email-body {
      background-color: #F2F4F6;
      color: #51545E;
    }

    .email-body_inner {
      width: 570px;
      margin: 0 auto;
      padding: 0;
      background-color: #FFFFFF;
    }

    .email-footer {
      text-align: center;
      margin: 0 auto;
      padding: 0;
    }

    .button {
      background-color: #3869D4;
      color: #FFF;
      text-decoration: none;
      border-radius: 3px;
      display: inline-block;
      padding: 10px 20px;
    }
  </style>
</head>

<body>
  <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
      <td align="center">
        <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td class="email-masthead">
              <a href="content.html" class="email-masthead_name">
                VACINAS
              </a>
            </td>
          </tr>
          <tr>
            <td class="email-body">
              <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="content-cell">
                    <h1>Olá, {{nome}}!</h1>
                    <p>Sua senha foi alterada com sucesso. Para garantir a segurança da sua conta, mantenha essa informação em um local seguro.</p>
                    <p>Se você não solicitou essa alteração, por favor, entre em contato com o suporte imediatamente.</p>
                    <!-- Action -->
                    <p style="text-align: center;">
                      <a href="http://vacinas.agenci.one/src/account/auth/login/login.php" class="button" target="_blank">Entre na sua conta</a>
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td class="email-footer">
              <p>
                Minhas Vacinas, LLC
                <br>https://minhasvacinas.online
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>