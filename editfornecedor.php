<?php
    include("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

    $cod_fornecedor = $_GET['id_fornecedor'];

   if(!isset($_GET['id_fornecedor']))

      echo "<script> alert('Fornecedor Inválido.'); location.href='visfornecedor.php' ; </script>";

      $sql= "SELECT * FROM fornecedor WHERE id_fornecedor = '$cod_fornecedor'";
      $res= $mysqli->query($sql) or die($mysqli->error);
      $linha = $res->fetch_assoc();

      $vrazao = $linha['razao_fornecedor'];
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
              <input type="text" class="form-control" id="razaosocial" placeholder="" name="txtrazao" value="<?php echo "$vrazao";?>" required><br/>
            </div>
            <!--<div class="col-md-3   mb-3">
              <label for="cnpj">CNPJ</label>
              <input type="text" class="form-control" id="cnpj" placeholder="" name="txtcnpj" value="" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="inscestadual">NOME FANTASIA</label>
              <input type="text" class="form-control" id="inscestadual" placeholder="" name="txtfantasia" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 mb-3">
              <label for="endereco">ENDEREÇO</label>
              <input type="text" class="form-control" id="endereco" placeholder="" name="txtendereco" value="" required>
            </div>
            <div class="col-md-2 mb-3">
              <label for="endereco">NUMERO</label>
              <input type="text" class="form-control" id="endereco" placeholder="" name="txtnumero" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="uf">UF</label>
              <select class="custom-select d-block w-100" id="uf" name="txtuf" required>
                <option value="">SELECIONE...</option>
                <option value="PR">PR</option>
                <option value="SC">SC</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="contato">CIDADE</label>
              <input type="text" class="form-control" id="contato" placeholder="" name="txtcidade" value="" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="contato">BAIRRO</label>
              <input type="text" class="form-control" id="contato" placeholder="" name="txtbairro" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8 mb-3">
              <label for="email">E-MAIL <span class="text-muted">(Opcional)</span></label>
              <input type="email" class="form-control" id="email" name="txtemail" placeholder="exemplo@exemplo.com">    
            </div>
            <div class="col-md-4 mb-3">
              <label for="contato">FUNÇÃO / CARGO</label>
              <input type="text" class="form-control" id="contato" placeholder="" name="txtfuncao" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 mb-3">
              <label for="ddd">DDD</label>
              <input type="text" class="form-control" id="ddd" placeholder="" name="txtddd" value="" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="telefone">TELEFONE</label>
              <input type="text" class="form-control" id="telefone" placeholder="" name="txttelefone" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="telefone">CELULAR</label>
              <input type="text" class="form-control" id="telefone" placeholder="" name="txtcelular" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="telefone">NOME CONTATO</label>
              <input type="text" class="form-control" id="telefone" placeholder="" name="txtnomecontato" required>
            </div>
          </div> -->
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

                $sql = "UPDATE fornecedor SET
                razao_fornecedor = '$vrazao'
                WHERE id_fornecedor = '$cod_fornecedor'";                
                $confirma = $mysqli->query($sql) or die($mysqli->error);

                echo "<script> alert('Fornecedor alterado com Sucesso') ;</script>";

                echo "<script> location.href='visfornecedor.php'; </script>";
                                             
             }     
                
          
          }
          $mysqli->close(); 
?>  