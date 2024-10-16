<?php
session_start();
function VefNoLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login/index.php");
        exit();
    }
}

function VefLogin()
{
    if (isset($_SESSION['user_id'])) {
        header("Location: ../painel/index.php");
        exit();
    }
}
