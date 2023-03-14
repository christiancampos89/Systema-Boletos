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
    <title>Cadastro Fornecedor</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </header>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Cadastro de Fornecedor</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="razaosocial">RAZAO SOCIAL</label>
              <input type="text" class="form-control" id="razaosocial" placeholder="" name="txtrazao" value="" required><br/>
            </div>
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="SALVAR"> 
          <input type="hidden" name="salvar" value="cadastrar">
        </form>
      </div>
      <div class="py-5 text-center">
          <h2>Importar Arquivo</h2>  
        </div>
        <form class="needs-validation" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-10 mb-3">
              <label for="arquivo">ARQUIVO</label>
              <input type="file" class="form-control" name="arquivo">
            </div>
          </div></br>         
          <input class="btn btn-success" type="submit" value="IMPORTAR"> 
          <input type="hidden" name="salvar" value="importar">
        </form>
    </div>
  </body>
</html>
<?php  
  if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar")
  {
    $vrazao = $_POST["txtrazao"];
    if(empty($vrazao))
    {
      echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';  
    }else
    {
      $sql = "INSERT INTO fornecedores VALUES (NULL, '$vrazao')";   
      $confirma = $mysqli->query($sql) or die($mysqli->error);                                 
    }                   
    echo '<script> alert("Fornecedor Gravado Com Sucesso!!!");</script>';
    echo "<script> location.href= 'visfornecedor.php'; </script> " ;
  }
  if(isset($_POST['salvar']) && $_POST['salvar'] == "importar")
  {
    if(!empty($_FILES['arquivo']['tmp_name']))
    {  
      $arquivo = new DomDocument();
      $arquivo->load($_FILES['arquivo']['tmp_name']);
      //var_dump($arquivo);
    
      $linhas = $arquivo->getElementsByTagName("Row");
      //var_dump($linhas);
    
      $primeira_linha = true;
      $total = 0;
      foreach($linhas as $linha)
      {

        if($primeira_linha == false)
        {
          $razao = $linha->getElementsByTagName("Data")->item(0)->nodeValue;       
          //Inserir o usuário no BD
          $sql= "INSERT INTO fornecedores VALUES (NULL, '$razao')";
          $res= $mysqli->query($sql);
          echo '<script> alert("Fornecedores Importados Com Sucesso!!!");</script>';
          echo "<script> location.href='visfornecedor.php'; </script>";
        }
        $primeira_linha = false;
      }
    }
  }
  $mysqli->close(); 
?>