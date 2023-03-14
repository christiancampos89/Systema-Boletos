<?php

include_once("settings/setting.php");
@session_start();

$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];

if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
  header('location: index.php');
  exit;
}

$cod_categoria = $_GET['id_categoria'];
if (!isset($_GET['id_categoria']))
{
  echo "<script> alert('Categoria Inválida.'); location.href='viscategoria.php'; </script>";
}else{
  $sql = "SELECT * FROM categorias WHERE id_categoria = $cod_categoria";
  $res = $mysqli->query($sql);
  $linha = $res->fetch_assoc();

  $vcategoria = $linha['categoria'];
  $vissubcategoria = $linha['is_subcategoria'];
  $vispai = $linha['is_pai'];
  $vordem = $linha['ordem'];
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
  <title>Editar Categoria</title>
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container">
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
      <h2>Edição de Categoria</h2>  
    </div>
    <div class="col-md-10   order-md-1">
      <form class="needs-validation" method="post" novalidate>
        <div class="row">
          <div class="col-md-10 mb-3">
            <label for="categoria">CATEGORIA</label>
            <input type="text" class="form-control" id="categoria" placeholder="" name="txtcategoria" value="<?php echo "$vcategoria";?>" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3">
            <label for="ordem">ORDEM</label>
            <input type="number" class="form-control" id="ordem" placeholder="" name="txtordem" value="<?php echo "$vordem";?>" required>
          </div>
        </div></br>
        <div class="row">
          <div class="col-md-6 mb-3">
            <fieldset id="issub"><label>POSSUÍ SUB CATEGORIA</label>
              <table >
                <tr>
                  <td><input type="radio" name="txtsub" value="1" id="issubsim" <?php echo ($vissubcategoria == 1) ? "checked" : null; ?> /></td>
                  <td><label for="issubsim">SIM</label></td>
                </tr>
                <tr>
                  <td><input type="radio" name="txtsub" value="0" id="issubnao" <?php echo ($vissubcategoria == 0) ? "checked" : null; ?> /></td>
                  <td><label for="issubnao">NÃO</label></td>
                </tr>
              </table>
            </fieldset>
          </div>
          <div class="col-md-6 mb-3">
            <fieldset id="ispai"><label>FAZ PARTE DO PAI</label>
              <table >
                <tr>
                  <td><input type="radio" name="txtpai" value="1" id="ispaisim" <?php echo ($vispai == 1) ? "checked" : null; ?> /></td>
                  <td><label for="ispaisim">SIM</label></td>
                </tr>
                <tr>
                  <td><input type="radio" name="txtpai" value="0" id="ispainao" <?php echo ($vispai == 0) ? "checked" : null; ?> /></td>
                  <td><label for="ispainao">NÃO</label></td>
                </tr>
              </table>
            </fieldset>
          </div> 
        </div></br>         
        <input class="btn btn-primary btn-lg btn-block" type="submit" value="SALVAR"> 
        <input type="hidden" name="alterar" value="cadastrar">
      </form>
    </div>  
  </div>
</div>
</body>
</html>

<?php
// 1 - REGISTRO DOS DADOS ----------------------------------------------------            
if(isset($_POST['alterar']) && $_POST['alterar'] == "cadastrar")
{
  $categoria       = $_POST['txtcategoria'];
  $issubcategoria  = $_POST['txtsub'];
  $ispai           = $_POST['txtpai'];
  $ordem           = $_POST['txtordem'];
  // 2 - VALIDAÇÃO DAS INFORMAÇOES SE ESTÃO VAZIAS OU NÃO NO PREENCHIMENTO!!!
  if(empty($categoria) || empty($ordem))
  {
    echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';
  }else if($ispai == null)
  {
    echo '<script> alert("Selecione a opção Faz parte do Pai?!!!"); history.back();</script>';
  }else if($issubcategoria == null)
  {
    echo '<script> alert("Selecione a opção Possui SubCategoria?!!!"); history.back();</script>';
  }else
  {
      $sql= "UPDATE categorias SET 
        categoria = '$categoria',
        is_subcategoria = '$issubcategoria',
        is_pai = '$ispai', 
        ordem = '$ordem'
        WHERE id_categoria = '$cod_categoria'";
      $res= $mysqli->query($sql) or die($mysqli->error);                
      echo "<script> alert('Categoria alterada com Sucesso') ;</script>";
      echo "<script> location.href='viscategoria.php'; </script>";
  }
}    
$mysqli->close(); 
?>