<?php
	
	include_once("settings/setting.php");
	@session_start();

	//$sql = "SELECT * FROM login";
	//$res = $mysqli->query($sql);
	//$linha = $res->fetch_assoc();

   $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

   $sql = "SELECT * FROM usuarios ORDER BY nome";
   $res = $mysqli->query($sql);
   $linha = $res->fetch_assoc();
   $total = mysqli_num_rows($res);

?>

<!doctype html>

<html lang="pt-br">
<header>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
    <title>Pesquisar Usuário</title>
    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</header>
<body>
	<div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
      <h2>Usuários</h2>  
    </div>
	<form name="frmpesqusu" action="" method="POST">
		<fieldset id="pesusua"><legend>Selecione o Tipo de Usuário</legend></br>
   			<select class="form-control" name="txttipo" >
                <option value="nada">SELECIONE TIPO DE USUÁRIO</option>
                <option value="admin">ADM TOTAL</option>
                <option value="admop">ADM OPERACIONAL</option>
                <option value="basico">BASICO</option>
                <option value="todos">Todos</option>
            </select>
   			<center><input type="submit" class="sb bradius" value="BUSCAR"></center>
   			<input type="hidden" name="pesquisar" value="BUSCAR">
   			<br/><br/>
		</fieldset>
	</form>
<?php
if(isset($_POST['pesquisar']) && $_POST['pesquisar'] == "BUSCAR"){
		$vtipo = $_POST['txttipo'];
		if($vtipo == 'nada'){
            echo '<script> alert("Selecione um Filtro!!!");</script>';
            exit;
	    }else if($vtipo == 'todos'){
	    	$sql = "SELECT * FROM usuarios";
			$res = $mysqli->query($sql);
			$linha = $res->fetch_assoc();
			$total = mysqli_num_rows($res);
	    }else{
	    	$sql = "SELECT * FROM usuarios WHERE tipo = '$vtipo' ORDER BY nome";
			$res = $mysqli->query($sql);
			$linha = $res->fetch_assoc();
        	$total = mysqli_num_rows($res);
        }
    }
	    
	 ?>
	 <div class="table-responsive">   
		 <table class="table" border="2" border rules="all">
			<tr class="titulo">
				<td><center>ID</center></td>
				<td><center>NOME</center></td>
				<td><center>USUÁRIO</center></td>
				<td><center>PERMISSÃO</center></td>
				<td><center>AÇÃO</center></td>		
			</tr>
	    	<?php
	    	do{
	    	?>	
	    	<tr>
	    		<td><CENTER><?php echo $linha['id_usuario']; ?></CENTER></td>
				<td><CENTER><?php echo $linha['nome']; ?></CENTER></td>
				<td><CENTER><?php echo $linha['usuario']; ?></CENTER></td>
				<td><CENTER><?php echo $linha['permissao']; ?></CENTER></td>
				<td><CENTER>
					<button onclick="javascript:window.location.href='editusuario.php?usuario=<?php echo $linha['usuario']; ?>'"><img src="imagens/minidetail.gif">EDITAR</button>
					<button type="button" onclick="confirma('<?php echo $linha['usuario']; ?>')"><img src="imagens/miniremove.gif">EXCLUIR</button>
				</CENTER></td>		
			</tr>

			<?php } while($linha = $res->fetch_assoc());
			//<?php echo ($tipo == "fornecedor") ? "checked" : null;
			?>


		 </table>
	 </div>
<?php echo "$total - REGISTROS"; ?>
		
<CENTER><a href="cadusuario.php" class="btn btn-danger"> Cadastrar Usuário </a> </CENTER>
<?php  
$mysqli->close();
?>
<SCRIPT TYPE="text/javascript">
	function confirma(el){
		decisao = confirm("Tem certeza?");
		if (decisao){
			javascript:window.location.href='delusuario.php?usuario='+el;
		}else{

		}
	}
</SCRIPT>

</body>

</html>