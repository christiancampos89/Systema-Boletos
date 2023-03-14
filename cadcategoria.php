<?php

include_once("settings/setting.php");
@session_start();

$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];

if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
  header('location: index.php');
  exit;
}

$vcategoria = "";
$vordem = 0;   

$vnome = isset($_POST["txtcategoria"]) ? $_POST["txtcategoria"] : '';
$vusuario = isset ($_POST["txtordem"]) ? $_POST["txtordem"] : '';

?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <title>Cadastro Categoria</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Cadastro de Categoria</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-10 mb-3">
              <label for="categoria">CATEGORIA</label>
              <input type="text" class="form-control" id="categoria" placeholder="" name="txtcategoria" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="ordem">ORDEM</label>
              <input type="number" class="form-control" id="ordem" placeholder="" name="txtordem" value="" required>
            </div>
          </div></br>
          <div class="row">
            <div class="col-md-6 mb-3">
              <fieldset id="issub"><label>POSSUÍ SUB CATEGORIA</label>
                <table >
                  <tr>
                    <td><input type="radio" name="txtsub" value="1" id="issubsim" /></td>
                    <td><label for="issubsim">SIM</label></td>
                  </tr>
                  <tr>
                    <td><input type="radio" name="txtsub" value="0" id="issubnao" /></td>
                    <td><label for="issubnao">NÃO</label></td>
                  </tr>
                </table>
              </fieldset>
            </div>
            <div class="col-md-6 mb-3">
              <fieldset id="ispai"><label>FAZ PARTE DO PAI</label>
                <table >
                  <tr>
                    <td><input type="radio" name="txtpai" value="1" id="ispaisim" /></td>
                    <td><label for="ispaisim">SIM</label></td>
                  </tr>
                  <tr>
                    <td><input type="radio" name="txtpai" value="0" id="ispainao" /></td>
                    <td><label for="ispainao">NÃO</label></td>
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
          <h2>Importar Arquivo de Categorias</h2>  
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
  </body>
</html>

<?php
// 1 - REGISTRO DOS DADOS ----------------------------------------------------            
if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar")
{
  $vcategoria       = $_POST['txtcategoria'];
  $vissubcategoria  = $_POST['txtsub'];
  $vispai           = $_POST['txtpai'];
  $vordem           = $_POST['txtordem'];
  // 2 - VALIDAÇÃO DAS INFORMAÇOES SE ESTÃO VAZIAS OU NÃO NO PREENCHIMENTO!!!
  if(empty($vcategoria) || empty($vordem))
  {
    echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';
  }else if($vispai == NULL)
  {
    echo '<script> alert("Selecione a opção se Faz parte do PAI!!!"); history.back();</script>';
  }else if($vissubcategoria == NULL)
  {
    echo '<script> alert("Selecione a opção se possuí SUBCATEGORIA!!!"); history.back();</script>';
  }else
  {
    $sql= "INSERT INTO categorias VALUES (NULL, '$vcategoria', '$vissubcategoria','$vispai', '$vordem')";
    $res= $mysqli->query($sql);
    echo '<script> alert("Categoria Gravada Com Sucesso!!!");</script>';
    echo "<script> location.href='viscategoria.php'; </script>";
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
        $categoria = $linha->getElementsByTagName("Data")->item(0)->nodeValue;       
        $issubcategoria = $linha->getElementsByTagName("Data")->item(1)->nodeValue;        
        $ispai = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
        $ordem = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
          //Inserir o usuário no BD
        $sql= "INSERT INTO categorias VALUES (NULL, '$categoria', '$issubcategoria','$ispai', '$ordem')";
        $res= $mysqli->query($sql);
        echo '<script> alert("Categorias Importadas Com Sucesso!!!");</script>';
        echo "<script> location.href='viscategoria.php'; </script>";
      }
      $primeira_linha = false;
    }
  }
}    
$mysqli->close(); 
?>