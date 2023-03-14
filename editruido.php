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
  $vid_ruido = $_GET['id_ruido'];

   if(!isset($_GET['id_ruido']))
   {
      echo "<script> alert('Ruido Inválido.'); location.href='visruido.php' ; </script>";
   }else
   {
      $sql= "SELECT * FROM ruidos WHERE id_ruido = '$vid_ruido'";
      $res= $mysqli->query($sql) or die($mysqli->error);
      $linha = $res->fetch_assoc();

      $id_farmacia = $linha['id_farmacia'];
      $id_fornecedor = $linha['id_fornecedor'];
      $detalhes = $linha['detalhes'];
      $data = $linha['data'];
      $fazer_contato = $linha['fazer_contato'];
    }

    $sql_fornecedor = "SELECT * FROM fornecedor ORDER BY razao_fornecedor";
    $result_fornecedor = $mysqli->query($sql_fornecedor);

    $sql_farmacia = "SELECT * FROM farmacia ORDER BY razao_farmacia";
    $result_farmacia = $mysqli->query($sql_farmacia);

    $sfornecedor = "SELECT id_fornecedor, razao_fornecedor FROM fornecedor WHERE id_fornecedor = '$id_fornecedor'";
    $resultt = $mysqli->query($sfornecedor);
    $linhas = $resultt->fetch_assoc();
    $vid_fornecedor = $linhas['id_fornecedor'];
    $vrazao_fornecedor = $linhas['razao_fornecedor'];

    $sfarmacia = "SELECT id_farmacia, razao_farmacia FROM farmacia WHERE id_farmacia = '$id_farmacia'";
    $resulttt = $mysqli->query($sfarmacia);
    $linhass = $resulttt->fetch_assoc();
    $vid_farmacia = $linhass['id_farmacia'];
    $vrazao_farmacia = $linhass['razao_farmacia'];
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
      <title>Alteração de Ruídos</title>
      <!-- Bootstrap core CSS -->
      <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
   </header>
   <body class="bg-light">
      <div class="container">
         <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
            <h2>Alteração de Ruído</h2>  
         </div><br/><br/><br/>
         <div class="col-md-10   order-md-1">
            <form class="needs-validation" method="post" novalidate>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label for="razaosocial">FARMÁCIA</label>
                     <select class="form-control" id="razaosocial" name="txtfarmacia" required>
                        <option value="<?php echo $vid_farmacia ?>"><?php echo $vrazao_farmacia ?></option>
                        <?php while($linha = $result_farmacia->fetch_array()){ ?>
                        <option  value="<?php echo $linha['id_farmacia'] ?>"><?php echo $linha['razao_farmacia'] ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-md-6   mb-3">
                     <label for="cnpj">FORNECEDOR</label>
                     <select class="form-control" name="txtfornecedor" >
                        <option value="<?php echo $vid_fornecedor ?>"><?php echo $vrazao_fornecedor ?></option>
                        <?php while($linha = $result_fornecedor->fetch_array()){ ?>
                        <option class="optforn" value="<?php echo $linha['id_fornecedor'] ?>"><?php echo $linha['razao_fornecedor'] ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div><br/>
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label for="inscestadual">DETALHES</label>
                     <textarea class="form-control" placeholder="" name="txtdetalhes" value="<?php echo "$detalhes";?>" required><?php echo "$detalhes";?></textarea>
                  </div>
                  <div class="col-md-3 mb-3">
                     <label for="inscestadual">DATA</label>
                     <input type="date" class="form-control" id="inscestadual" placeholder="" name="txtdata" value="<?php echo "$data";?>" required>
                  </div>
                  <div class="col-md-3 mb-3">
                     <label for="inscestadual">DAR RETORNO?</label>
                     <select class="form-control" name="txtretorno">
                        <option value="<?php echo "$fazer_contato";?>"><?php echo "$fazer_contato";?></option>
                        <option value="SIM">SIM</option>
                        <option value="NÃO">NÃO</option>
                     </select>
                  </div>
               </div><br/><br/>         
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="ALTERAR"> 
          <input type="hidden" name="alterar" value="cadastrar">
        </form>
      </div>
  </body>
</html>
<?php
  // 1 - REGISTRO DOS DADOS ----------------------------------------------------
  if(isset($_POST['alterar']) && $_POST['alterar'] == "cadastrar")
  {
    $id_farmacia = $_POST['txtfarmacia'];
    $id_fornecedor = $_POST['txtfornecedor'];
    $detalhes = $_POST['txtdetalhes'];
    $data = $_POST['txtdata'];
    $fazer_contato = $_POST['txtretorno'];
    if ($id_farmacia == '')
    {
      echo '<script> alert("Selecione uma farmácia!");</script>';
      exit;
    }
    else if(empty($detalhes) || empty($data))
    {
      echo '<script> alert("Preencha todos os campos!");</script>';     
    }else
    {  
      $sql= "UPDATE ruidos SET 
        id_farmacia = '$id_farmacia',
        id_fornecedor = '$id_fornecedor',
        detalhes = '$detalhes', 
        data = '$data',
        fazer_contato = '$fazer_contato'
        WHERE id_ruido = '$vid_ruido'";
      $res= $mysqli->query($sql) or die($mysqli->error);                
      echo "<script> alert('Ruído alterado com Sucesso') ;</script>";
      echo "<script> location.href='visruido.php'; </script>";
    }     
  } 
  $mysqli->close(); 
?>