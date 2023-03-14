<?php
include_once("settings/setting.php");
@session_start();

$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];

if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
  header('location: index.php');
  exit;

}

$cod_categoria = $_GET['id_categoria'];

if(!isset($_GET['id_categoria']))
  echo "<script> alert('Categoria Inválida.'); location.href='viscategoria.php' ; </script>";

$sql= "DELETE FROM categorias WHERE id_categoria = '$cod_categoria'";
$res= $mysqli->query($sql) or die($mysqli->error);

echo '<script> alert("Categoria excluida com Sucesso!");</script>';
echo "<script> location.href='viscategoria.php'; </script>";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
  <title>Deleta Categoria</title>
</head>


<body>

</body>

</html>