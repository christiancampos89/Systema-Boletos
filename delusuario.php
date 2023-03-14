<?php
   
   include_once("settings/setting.php");
      session_start();

      $nome = $_SESSION['nome'];
      $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }
      $vusuario = $_GET['usuario'];

   if(!isset($_GET['usuario']))
      echo "<script> alert('Usuario Inválido.'); location.href='visusuario.php' ; </script>";

      $sql= "DELETE FROM usuarios WHERE usuario = '$vusuario'";
      $res= $mysqli->query($sql) or die($mysqli->error);
      
      echo '<script> alert("Usuário excluido com Sucesso!");</script>';
      echo "<script> location.href='visusuario.php'; </script>";


?>

<!doctype html>

<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">

</head>
<title>Deleta Usuário</title>

<body>
   
</body>

</html>