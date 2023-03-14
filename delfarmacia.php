<?php
    include_once("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

    $cod_farmacia = $_GET['id_farmacia'];

   if(!isset($_GET['id_farmacia']))
      echo "<script> alert('Farmácia Inválida.'); location.href='visfarmacia.php' ; </script>";

      $sql= "DELETE FROM farmacia WHERE id_farmacia = '$cod_farmacia'";
      $res= $mysqli->query($sql) or die($mysqli->error);

      echo '<script> alert("Farmácia excluida com Sucesso!");</script>';
      echo "<script> location.href='visfarmacia.php'; </script>";

   ?>

<!doctype html>

<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">

</head>
<title>Deleta Farmácia</title>

<body>
   
</body>

</html>