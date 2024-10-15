<?php
session_start();
//Usar em todas as páginas que o usuário precisa fazer login p ver
function VefNoLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../login/index.php");
        exit();
    }
}

//Inverso da função acima
function VefLogin()
{
    if (isset($_SESSION['user_id'])) {
        header("Location: ../../painel/index.php");
        exit();
    }
}
