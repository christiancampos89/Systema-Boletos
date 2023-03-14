<?php
    include("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

    $cod_mesa = $_GET['id_mesa'];

   if(!isset($_GET['id_mesa']))

      echo "<script> alert('Mesa Inválida.'); location.href='vismesas.php' ; </script>";

      $sql= "DELETE FROM mesas WHERE id_mesa = '$cod_mesa'";
      $res= $mysqli->query($sql) or die($mysqli->error);

      echo '<script> alert("Mesa excluida com Sucesso!");</script>';
      echo "<script> location.href='vismesas.php'; </script>";


   ?>
<!doctype html>

<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">

</head>
<title>Deleta Mesas</title>

<body>
   
</body>

</html>