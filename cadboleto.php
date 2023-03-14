<?php
	
	include_once("settings/setting.php");
	@session_start();

   $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;
   }
   
   $sql_code = "SELECT * FROM fornecedores ORDER BY fornecedor";
   $result = $mysqli->query($sql_code);
?>

<!doctype html>

<html lang="pt-br">
   <header>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="">
      <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
      <title>Cadastro de Boletos</title>
      <!-- Bootstrap core CSS -->
      <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
   </header>
   <body class="bg-light">
      <div class="container">
         <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
            <h2>Cadastro de Boletos</h2>  
         </div><br/><br/><br/>
         <div class="col-md-10   order-md-1">
            <form class="needs-validation" method="post" novalidate>
               <div class="row">
                  <div class="col-md-5 mb-3">
                     <label for="beneficiario">BENEFICIÁRIO</label>
                     <select class="form-control" name="txtbeneficiario" >
                        <option value="nada">SELECIONE O BENEFICIÁRIO</option>
                        <?php while($linha = $result->fetch_array()){ ?>
                        <option class="optforn" value="<?php echo $linha['id_fornecedor'] ?>"><?php echo $linha['fornecedor'] ?></option>
                      <?php } ?>
                     </select>
                  </div>
                  <div class="col-md-3 mb-3">
                     <label for="datavencimento">DATA VENCIMENTO</label>
                     <input type="date" class="form-control" id="datavencimento" placeholder="" name="txtdatavencimento" value="" required>
                  </div>
                  <div class="col-md-3,5 mb-3">
                     <label for="ndocumento">Nº DOCUMENTO</label>
                     <input type="text" class="form-control" id="ndocumento" placeholder="" name="txtndocumento" value="" required>
                  </div>
               </div></br>         
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="SALVAR"> 
          <input type="hidden" name="salvar" value="cadastrar">
        </form>
      </div>
  </body>
</html>
<?php
   if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar"){
      $vtxtdetalhes = $_POST['txtdetalhes'];
      $vtxtdata = $_POST['txtdata'];
      $vtxtretorno = $_POST['txtretorno'];
		if($vtxtdetalhes == ''){
         echo '<script> alert("Selecione uma Farmácia ou Preencha Detalhes!!!");</script>';
	   }else{
         $sql= "INSERT INTO ruidos VALUES (NULL,'$vid_farmacia', '$vid_fornecedor', '$vtxtdetalhes', '$vtxtdata', '$vtxtretorno')";
         $res= $mysqli->query($sql);
         echo '<script> alert("Ruído Cadastrado Com Sucesso!!!");</script>';
      } 
   }  

$mysqli->close();
?>
