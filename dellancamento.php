<?php
   
   include_once("settings/setting.php");
      session_start();

      $nome = $_SESSION['nome'];
      $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }
      $vboleto = $_GET['id_boleto'];

   if(!isset($_GET['id_boleto']))
      echo "<script> alert('Boleto Inválido.'); location.href='vislancamento.php' ; </script>";

      $sql= "DELETE FROM boletos WHERE id_boleto = '$vboleto'";
      $res= $mysqli->query($sql) or die($mysqli->error);
      
      echo '<script> alert("Boleto excluido com Sucesso!");</script>';
      echo "<script> location.href='vislancamento.php'; </script>";


?>

<!doctype html>

<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">

</head>
<title>Deleta Boletos</title>

<body>
   
</body>

</html>