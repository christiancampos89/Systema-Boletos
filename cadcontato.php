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
   $vtelefone = "";
   $vsenha = "";
   $vconfsenha = "";
   $vpermissao = 0;   
   $vtipo = "";
   $vid_empresa = 0;

   $vnome = isset($_POST["txtnome"]) ? $_POST["txtnome"] : '';
   $vtelefone = isset ($_POST["txttelefone"]) ? $_POST["txttelefone"] : '';
   $vempresa = isset($_POST["txtempresa"]) ? $_POST["txtempresa"] : '';
   $vregiao = isset($_POST["txtregiao"]) ? $_POST["txtregiao"] : '' ;


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
    <title>Cadastro Contatos</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </header>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Cadastro de Contatos</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nome">NOME</label>
              <input type="text" class="form-control" id="nome" placeholder="" name="txtnome" value="" required>
            </div>
            <div class="col-md-6   mb-3">
              <label for="telefone">TELEFONE</label>
              <input type="text" class="form-control" id="telefone" placeholder="" name="txttelefone" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="inscestadual">EMPRESA</label>
              <input type="text" class="form-control" id="inscestadual" placeholder="" name="txtempresa" value="" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="regiao">REGIÃO</label>
              <input type="text" class="form-control" id="regiao" placeholder="" name="txtregiao" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-6">
              <fieldset id="tipousu"><label>TIPO DE USUÁRIO</label>
                  <table >
                    <tr>
                      <td><input type="radio" name="txttipo" onclick="mostradiv('adminN')" value="industria" id="tadmin" /></td>
                      <td><label for="tadmin">INDÚSTRIA</label></td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="txttipo" onclick="mostradiv('divfornecedorR')" value="distribuidor" id="tfornecedor" /></td>
                      <td><label for="tfornecedor">DISTRIBUIDOR</label></td>
                    </tr>
                  </table>
               </fieldset> 
            </div>
            <div class="col-md-6 mb-3">
              <div id="divfornecedor" style="display: none;">
                   <p><label for="tfornecedor">FORNECEDOR:</label>
                   <select class="txt bradius" name="txtfornecedor" id="tfornecedor" >
                      <option value="0">SELECIONE UM FORNECEDOR</option>
                      <?php while($linha = $result->fetch_array()){ ?>
                      <option class="optforn" value="<?php echo $linha['id_fornecedor'] ?>"><?php echo $linha['razao_fornecedor'] ?></option>
                      <?php } ?>
                   </select></p>    
              </div>      
            </div>
          </div>         
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="SALVAR"> 
          <input type="hidden" name="salvar" value="cadastrar">
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
    $vtelefone       = $_POST['txttelefone'];
    $vempresa         = $_POST['txtempresa'];
    $vregiao     = $_POST['txtregiao'];
    $vtipo          = $_POST['txttipo']; 

  // 2 - VALIDAÇÃO DAS INFORMAÇOES SE ESTÃO VAZIAS OU NÃO NO PREENCHIMENTO!!!
    if(empty($vnome) || empty($vtelefone) || empty($vempresa))
    {
      echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';
    }else if ($vtipo == '')
    {
      echo '<script> alert("Selecione o tipo de usúario!"); history.back();</script>';
    }else
    {
      $sql= "INSERT INTO contatos VALUES (NULL, '$vnome', '$vtelefone','$vempresa', '$vregiao', '$vtipo')";
      $res= $mysqli->query($sql);
      echo '<script> alert("Contato Gravado Com Sucesso!!!");</script>';
      echo "<script> location.href='viscontato.php'; </script>";
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
        $tpusuario = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
        $id_fornecedor = $linha->getElementsByTagName("Data")->item(5)->nodeValue;
        //Inserir o usuário no BD
        $sql= "INSERT INTO usuarios VALUES (NULL, '$nome', '$usuario','$senha', '$permissao', '$tpusuario', '$id_fornecedor')";
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