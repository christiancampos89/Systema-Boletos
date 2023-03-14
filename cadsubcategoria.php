<?php

include_once("settings/setting.php");
@session_start();

$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];

if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
  header('location: index.php');
  exit;
}

$vsubcategoria = "";
$vidcategoria = "";

$vsubcategoria = isset($_POST["txtsubcategoria"]) ? $_POST["txtsubcategoria"] : '';
$vidcategoria = isset ($_POST["txtcategoria"]) ? $_POST["txtcategoria"] : '';

$j = 0;
$sql = "SELECT * FROM categorias Where is_subcategoria = 1";
$res = $mysqli->query($sql);
while($linha = $res->fetch_array()){
  $id_categoria = $linha['id_categoria'];
  $categoria = $linha['categoria'];
  $arrayid_categoria[$j] = $id_categoria;
  $arraycategoria[$j] = $categoria;
  $j++;
}

?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <title>Cadastro SubCategoria</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Cadastro de SubCategoria</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-10 mb-3">
              <label for="subcategoria">SUBCATEGORIA</label>
              <input type="text" class="form-control" id="subcategoria" placeholder="" name="txtsubcategoria" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 mb-3">
              <label for="categoria">CATEGORIA</label>
              <select class="form-control" name="txtcategoria" >
                <option value="nada">SELECIONE UMA CATEGORIA</option>
                <?php for($k = 0; $k <  $j; $k++){ ?>
                  <option class="optforn" value="<?php echo $arrayid_categoria[$k]; ?>"><?php echo $arraycategoria[$k]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div></br>         
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="SALVAR"> 
          <input type="hidden" name="salvar" value="cadastrar">
        </form>
      </div>
</body>
</html>
<?php
// 1 - REGISTRO DOS DADOS ----------------------------------------------------            
if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar")
{
  $vsubcategoria       = $_POST['txtsubcategoria'];
  $vcategoria  = $_POST['txtcategoria'];
  // 2 - VALIDAÇÃO DAS INFORMAÇOES SE ESTÃO VAZIAS OU NÃO NO PREENCHIMENTO!!!
  if(empty($vsubcategoria) || empty($vcategoria))
  {
    echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';
  }else
  {
    $sql= "INSERT INTO subcategorias VALUES (NULL, '$vsubcategoria', '$vcategoria')";
    $res= $mysqli->query($sql);
    echo '<script> alert("SubCategoria Gravada Com Sucesso!!!");</script>';
    echo "<script> location.href='vissubcategoria.php'; </script>";
  }
}    
$mysqli->close(); 
?>