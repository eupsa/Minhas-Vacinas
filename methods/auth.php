<?php
session_start();
function authLog()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login/index.php");
        exit();
    }
}

function authPainel()
{
    if (isset($_SESSION['user_id'])) {
        header("Location: ../painel/index.php");
        exit();
    }
}
