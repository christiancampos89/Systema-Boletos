<?php
   
   include_once("settings/setting.php");
   @session_start();
   
   $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

  
   $vnome = "";
   $vusuario = "";
   $vsenha = "";
   $vconfsenha = "";
   $vpermissao = 0;   
   $vtipo = "";
   $vid_farmacia = 0;

   $vnome = isset($_POST["txtnome"]) ? $_POST["txtnome"] : '';
   $vusuario = isset ($_POST["txtusuario"]) ? $_POST["txtusuario"] : '';
   $vsenha = isset($_POST["txtsenha"]) ? $_POST["txtsenha"] : '';
   $vconfsenha = isset($_POST["txtconfsenha"]) ? $_POST["txtconfsenha"] : '' ;
   $vpermissao = isset($_POST["txtpermissao"]) ? $_POST["txtpermissao"] : '' ;
   $vtipo = isset($_POST["txttipo"]) ? $_POST["txttipo"] : '' ;



   $sql_code = "SELECT * FROM fornecedor ORDER BY razao_fornecedor";
   $result = $mysqli->query($sql_code);

?>
<html>
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <title>Cadastro Usuario</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </header>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Cadastro de Usuário</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="razaosocial">NOME</label>
              <input type="text" class="form-control" id="razaosocial" placeholder="" name="txtnome" value="" required>
            </div>
            <div class="col-md-6   mb-3">
              <label for="cnpj">USUÁRIO</label>
              <input type="text" class="form-control" id="cnpj" placeholder="" name="txtusuario" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="inscestadual">SENHA</label>
              <input type="text" class="form-control" id="inscestadual" placeholder="" name="txtsenha" value="" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="inscestadual">REPETE SENHA</label>
              <input type="text" class="form-control" id="inscestadual" placeholder="" name="txtconfsenha" value="" required>
            </div>
          </div></br>
          <div class="row">
            <div class="col-md-6 mb-3">
              <fieldset id="tipousu"><label>TIPO DE USUÁRIO</label>
                  <table >
                    <tr>
                      <td><input type="radio" name="txttipo" onclick="mostradiv('admin')" value="admin" id="tadmin" /></td>
                      <td><label for="tadmin">ADM TOTAL</label></td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="txttipo" onclick="mostradiv('divfornecedor')" value="admop" id="tfornecedor" /></td>
                      <td><label for="tfornecedor">ADM OP.</label></td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="txttipo" onclick="mostradiv('divfarmacia')" value="basico" id="tassociado" /></td>
                      <td><label for="tassociado">BASICO</label></td>
                    </tr>
                  </table>
               </fieldset>
               </div> 
          </div></br>         
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
    </div>
    <script type="text/javascript">
      function mostradiv(el)
      {
        //document.getElementById("divfarmacia").style.display = 'none';
        document.getElementById("divfornecedor").style.display = 'none';
        if(el != "admin")
        document.getElementById(el).style.display = 'block';
      }
    </script>
  </body>
</html>

<?php
// 1 - REGISTRO DOS DADOS ----------------------------------------------------            
  if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar")
  {
    $vnome          = $_POST['txtnome'];
    $vusuario       = $_POST['txtusuario'];
    $vsenha         = $_POST['txtsenha'];
    $vconfsenha     = $_POST['txtconfsenha'];
    $vtipo          = $_POST['txttipo'];
    // DEFININDO A PERMISSÃO DO USUÁRIO PELO TIPO DE USUÁRIO ESCOLHIDO NO CADASTRO!!! 
    if ($vtipo == 'admin')
    {
      $vpermissao = 3;
    }else if ($vtipo == '')
    {
      $vpermissao = 2;
    }else
    {
      $vpermissao = 1;
    }
  // 2 - VALIDAÇÃO DAS INFORMAÇOES SE ESTÃO VAZIAS OU NÃO NO PREENCHIMENTO!!!
    if(empty($vnome) || empty($vusuario) || empty($vsenha) || empty($vconfsenha))
    {
      echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';
    }else if ($vtipo == '')
    {
      echo '<script> alert("Selecione o tipo de usúario!"); history.back();</script>';
    }else if ($vsenha != $vconfsenha)
    {
      echo '<script> alert("Senhas não podem ser diferentes!"); history.back();</script>';
    }else
    {
      $sql= "INSERT INTO usuarios VALUES (NULL, '$vnome', '$vusuario','$vsenha', '$vpermissao')";
      $res= $mysqli->query($sql);
      echo '<script> alert("Usuário Gravado Com Sucesso!!!");</script>';
      echo "<script> location.href='visusuario.php'; </script>";
    }
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
          $nome = $linha->getElementsByTagName("Data")->item(0)->nodeValue;       
          $usuario = $linha->getElementsByTagName("Data")->item(1)->nodeValue;        
          $senha = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
          $permissao = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
          //Inserir o usuário no BD
          $sql= "INSERT INTO usuarios VALUES (NULL, '$nome', '$usuario','$senha', '$permissao')";
          $res= $mysqli->query($sql);
          echo '<script> alert("Usuários Importados Com Sucesso!!!");</script>';
          echo "<script> location.href='visusuario.php'; </script>";
        }
        $primeira_linha = false;
      }
    }
  }    
  $mysqli->close(); 
?>