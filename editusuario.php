<?php
  include_once("settings/setting.php");
  session_start();

  $nome = $_SESSION['nome'];
  $usuario = $_SESSION['usuario'];

  if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario']))
  {
    header('location: index.php');
    exit;
  }
  $vusuario = $_GET['usuario'];

   if(!isset($_GET['usuario']))
   {
      echo "<script> alert('Usuario Inválido.'); location.href='visusuario.php' ; </script>";
   }else
   {
      $sql= "SELECT * FROM usuarios WHERE usuario = '$vusuario'";
      $res= $mysqli->query($sql) or die($mysqli->error);
      $linha = $res->fetch_assoc();

      $nome = $linha['nome'];
      $usuario = $linha['usuario'];
      $senha = $linha['senha'];
      $confsenha = $linha['senha'];
      $permissao = $linha['permissao'];
    }
?>


<!doctype html>

<html>
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <title>Alteração de Usuário</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </header>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Alteração de Usuário</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="razaosocial">NOME</label>
              <input type="text" class="form-control" id="razaosocial" placeholder="" name="txtnome" value="<?php echo "$nome";?>" required>
            </div>
            <div class="col-md-6   mb-3">
              <label for="cnpj">USUÁRIO</label>
              <input type="text" class="form-control" id="cnpj" placeholder="" name="txtusuario" value="<?php echo "$usuario";?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="inscestadual">SENHA</label>
              <input type="text" class="form-control" id="inscestadual" placeholder="" name="txtsenha" value="<?php echo "$senha";?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="inscestadual">REPETE SENHA</label>
              <input type="text" class="form-control" id="inscestadual" placeholder="" name="txtconfsenha" value="<?php echo "$senha";?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <fieldset id="tipousu"><label>TIPO DE USUÁRIO</label>
                  <table >
                    <tr>
                      <td><input type="radio" name="txttipo" onclick="mostradiv('admin')" value="admin" id="tadmin"<?php echo ($permissao == 3) ? "checked" : null; ?> /></td>
                      <td><label for="tadmin">ADMIN</label></td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="txttipo" onclick="mostradiv('divfornecedor')" value="fornecedor" id="tfornecedor" <?php echo ($permissao == 2) ? "checked" : null; ?> /></td>
                      <td><label for="tfornecedor">ADM OPERACIONAL</label></td>
                    </tr>
                    <tr>
                      <td><input type="radio" name="txttipo" onclick="mostradiv('divfarmacia')" value="associado" id="tassociado" <?php echo ($permissao == 1) ? "checked" : null; ?> /></td>
                      <td><label for="tassociado">BASICO</label></td>
                    </tr>
                  </table>
               </fieldset> 
            </div>
          </div>         
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="ALTERAR"> 
          <input type="hidden" name="alterar" value="cadastrar">
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
  if(isset($_POST['alterar']) && $_POST['alterar'] == "cadastrar")
  {
    $nome = $_POST['txtnome'];
    $usuario = $_POST['txtusuario'];
    $senha = $_POST['txtsenha'];
    $confsenha = $_POST['txtconfsenha']; 
    $tipo = $_POST['txttipo'];
    if ($tipo == 'admin')
    {
      $permissao = 3;
      $id_fornecedor = 0;
    }else if ($tipo == 'fornecedor')
    {
      $permissao = 2;
    }else
    {
      $permissao = 1;
    }
    if(empty($usuario) || empty($senha) || empty($confsenha) || empty($permissao))
    {
      echo '<script> alert("Preencha todos os campos!");</script>';     
    }else if ($senha != $confsenha)
    {
      echo '<script> alert("Senhas não podem ser diferentes!!!");</script>';
    }else
    {  
      $sql= "UPDATE usuarios SET 
        nome = '$nome',
        usuario = '$usuario',
        senha = '$senha', 
        permissao = '$permissao'
        WHERE usuario = '$vusuario'";
      $res= $mysqli->query($sql) or die($mysqli->error);                
      echo "<script> alert('Usuário alterado com Sucesso') ;</script>";
      echo "<script> location.href='visusuario.php'; </script>";
    }     
  } 
  $mysqli->close(); 
?>
