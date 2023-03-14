<?php
   
   include_once("settings/setting.php");
      session_start();

      $nome = $_SESSION['nome'];
      $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

?>

<!doctype html>

<html lang="pt-br">
   <head>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <!-- Bootstrap core CSS -->
      <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
      <title>Deleta Lançamentos</title>
   </head>
<body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>SENHA MASTER</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="senha">SENHA MASTER</label>
              <input type="text" class="form-control" id="senha" placeholder="" name="txtsenha" value="" required><br/>
            </div>
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="EXCLUIR"> 
          <input type="hidden" name="salvar" value="cadastrar">
        </form>
      </div>
    </div>
  </body>
</html>
<?php  
  if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar")
   {
      $vsenha = $_POST["txtsenha"];
      if(empty($vsenha))
      {
         echo '<script> alert("Preencha o campo senha!!!"); history.back();</script>';  
      }else if ($vsenha == 'sede4085sede')
      {
         $sql= "TRUNCATE TABLE compras";
         $res= $mysqli->query($sql) or die($mysqli->error);
         echo '<script> alert("Lançamentos excluidos com Sucesso!");</script>';
         echo "<script> location.href='vislancamento.php'; </script>";
      }else
      {
         echo '<script> alert("Senha Inválida!!!"); history.back();</script>';
      }
  }
  $mysqli->close(); 
?>