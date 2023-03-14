<?php
	
	include_once("settings/setting.php");
	@session_start();

   $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }
   $sql = "SELECT * FROM usuarios WHERE tipo = 'associado' ORDER BY usuario";
   $res = $mysqli->query($sql);

   $sql_code = "SELECT * FROM farmacia ORDER BY razao_farmacia";
   $ress = $mysqli->query($sql_code);
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
      <title>Vincular Usuário a Farmácia</title>
      <!-- Bootstrap core CSS -->
      <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
   </header>
   <body>
         <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
            <h2>USUÁRIOS E FARMÁCIAS</h2>  
         </div>
         <form name="frmpesqusu" action="" method="POST">
   			<p><label for="cusuario">USUÁRIO:</label>
   			<select class="form-control" name="txtusuario" >
               <option value="nada">SELECIONE UM USUÁRIO</option>
               <?php while($linha = $res->fetch_array()){ ?>
               <option class="optforn" value="<?php echo $linha['id_usuario'] ?>"><?php echo $linha['usuario'] ?></option>
               <?php } ?>
            </select><br/><br/><br/>
            <p><label for="cusuario">FARMÁCIA:</label>
   			<select class="form-control" name="txtfarmacia" >
               <option value="nada">SELECIONE UMA FARMÁCIA</option>
               <?php while($linha = $ress->fetch_array()){ ?>
               <option  value="<?php echo $linha['id_farmacia'] ?>"><?php echo $linha['razao_farmacia'] ?></option>
               <?php } ?>
            </select>
   			<center><input type="submit" class="btn btn-success" value="ASSOCIAR"></center>
   			<input type="hidden" name="gravar" value="associar">
   			<br/><br/>
         </form>
   </body>
</html>
<?php
   if(isset($_POST['gravar']) && $_POST['gravar'] == "associar"){
		$vid_usuario = $_POST['txtusuario'];
		$vid_farmacia = $_POST['txtfarmacia'];
		if($vid_usuario == 'nada' || $vid_farmacia == 'nada'){
         echo '<script> alert("Selecione um Usuário e uma Farmácia!!!");</script>';
	   }else{
         $squery1 = ("SELECT * FROM usuario_farmacia WHERE id_usuario = '$vid_usuario' AND id_farmacia = '$vid_farmacia'");
         $res = $mysqli->query($squery1);
         $total = mysqli_num_rows($res);
         if($total == 1){
            echo '<script> alert("LOJA JÁ ASSOCIADA A ESSE USUÁRIO");</script>';                  
         }else{
	         $sql= "INSERT INTO usuario_farmacia VALUES ('$vid_usuario', '$vid_farmacia')";
            $res= $mysqli->query($sql);
		      echo '<script> alert("Usuário Vinculado Com Sucesso!!!");</script>';
         } 
      }
   }  

$mysqli->close();
?>
