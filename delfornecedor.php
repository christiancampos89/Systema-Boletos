<?php
    include("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

    $cod_fornecedor = $_GET['id_fornecedor'];

   if(!isset($_GET['id_fornecedor']))

      echo "<script> alert('Fornecedor Inválido.'); location.href='visfornecedor.php' ; </script>";

      $sql= "DELETE FROM fornecedor WHERE id_fornecedor = '$cod_fornecedor'";
      $res= $mysqli->query($sql) or die($mysqli->error);

      echo '<script> alert("Fornecedor excluido com Sucesso!");</script>';
      echo "<script> location.href='visfornecedor.php'; </script>";


   ?>
<!doctype html>

<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">

</head>
<title>Deleta Fornecedor</title>

<body>
   
</body>

</html>