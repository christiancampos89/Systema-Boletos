<?php
   // Removendo dados da sessao
    @session_start();
    session_destroy();
    unset($_SESSION);
    header('location: index.php');
    exit;
?>