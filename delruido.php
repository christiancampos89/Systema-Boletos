<?php
    include_once("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

    $cod_ruido = $_GET['id_ruido'];

   if(!isset($_GET['id_ruido']))
      echo "<script> alert('Ruído Inválido.'); location.href='visruido.php' ; </script>";

      $sql= "DELETE FROM ruidos WHERE id_ruido = '$cod_ruido'";
      $res= $mysqli->query($sql) or die($mysqli->error);

      echo '<script> alert("Ruído excluido com Sucesso!");</script>';
      echo "<script> location.href='visruido.php'; </script>";

   ?>

<!doctype html>

<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">

</head>
<title>Deleta Ruído</title>

<body>
   
</body>

</html>