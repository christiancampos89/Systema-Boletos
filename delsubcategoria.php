<?php
include_once("settings/setting.php");
@session_start();

$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];

if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
  header('location: index.php');
  exit;

}

$cod_subcategoria = $_GET['id_subcategoria'];

if(!isset($_GET['id_subcategoria']))
  echo "<script> alert('SubCategoria Inválida.'); location.href='vissubcategoria.php' ; </script>";

$sql= "DELETE FROM subcategorias WHERE id_subcategoria = '$cod_subcategoria'";
$res= $mysqli->query($sql) or die($mysqli->error);

echo '<script> alert("SubCategoria excluida com Sucesso!");</script>';
echo "<script> location.href='vissubcategoria.php'; </script>";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
  <title>Deleta SubCategoria</title>
</head>


<body>

</body>

</html>