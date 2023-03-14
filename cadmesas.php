<?php
    include("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }
   
   $vrazao = isset($_POST["txtrazao"]) ? $_POST["txtrazao"] : '';
   $vfantasia = isset($_POST["txtfantasia"]) ? $_POST["txtfantasia"] : '';
   $vcnpj = isset($_POST["txtcnpj"]) ? $_POST["txtcnpj"] : '';
   $vie = isset($_POST["txtie"]) ? $_POST["txtie"] : '';
   $vcidade = isset($_POST["txtcidade"]) ? $_POST["txtcidade"] : '';
   ?>

<html>
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <title>Cadastro de Mesas</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </header>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/espetinho.png" alt="" width="100" height="90">
        <h2>Cadastro de Mesas</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-2 mb-3">
              <label for="razaosocial">Nº DA MESA</label>
              <input type="text" class="form-control" id="razaosocial" placeholder="" name="txtnummesa" value="" required><br/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <table >
                <tr>
                  <td><input type="radio" name="txtstatus" value="aberta" id="tadmin" /></td>
                  <td><label for="tadmin">ABERTA</label></td>
                </tr>
                <tr>
                  <td><input type="radio" name="txtstatus" value="fechada" id="tfornecedor" /></td>
                  <td><label for="tfornecedor">FECHADA</label></td>
                </tr>
              </table><br/>
          </div>
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="SALVAR"> 
          <input type="hidden" name="salvar" value="cadastrar">
        </form>
      </div>
    </div>
  </body>
</html>
<?php  
  if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar")
  {
    $vnummesa = $_POST["txtnummesa"];
    $vstatus = $_POST["txtstatus"];
    if(empty($vnummesa))
    {
      echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';  
    }else
    {
      $sql = "INSERT INTO mesas VALUES (NULL, '$vnummesa', '$vstatus')";   
      $confirma = $mysqli->query($sql) or die($mysqli->error);                                 
    }                   
    echo '<script> alert("Mesa Cadastrada Com Sucesso!!!");</script>';
    echo "<script> location.href= 'vismesas.php'; </script> " ;
  }
  $mysqli->close(); 
?>