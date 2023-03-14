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

      $sql= "SELECT * FROM mesas WHERE id_mesa = '$cod_mesa'";
      $res= $mysqli->query($sql) or die($mysqli->error);
      $linha = $res->fetch_assoc();

      $vnummesa = $linha['numero'];
      $vstatus = $linha['status'];
   ?> 

<html>
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <title>Edição Mesas</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </header>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Edição de Mesas</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="razaosocial">Mesas</label>
              <input type="text" class="form-control" id="razaosocial" placeholder="" name="txtrazao" value="<?php echo "$vrazao";?>" required><br/>
            </div>
            
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="SALVAR"> 
          <input type="hidden" name="salvar" value="cadastrar">
        </form>
      </div>
    </div>
  </body>
</html>
  <?php
	
           if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar"){
               $vrazao = $_POST["txtrazao"];
             if(empty($vrazao)){
                echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';  
             }else{               
               //$mysqli = new mysqli('web134.f1.k8.com.br', 'copersistem', 'sede4085sede', 'copersistem');

                $sql = "UPDATE mesas SET
                numero = '$vnummesa',
                status = '$vstatus'
                WHERE id_mesa = '$cod_mesa'";                
                $confirma = $mysqli->query($sql) or die($mysqli->error);

                echo "<script> alert('Mesa alterada com Sucesso') ;</script>";

                echo "<script> location.href='visfornecedor.php'; </script>";
                                             
             }     
                
          
          }
          $mysqli->close(); 
?>  