<?php
include_once("settings/setting.php");
@session_start();

$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];

if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
	header('location: index.php');
	exit;
}
$sql = "SELECT * FROM subcategorias s
INNER JOIN categorias c ON s.id_categoria = c.id_categoria ORDER BY subcategoria";
$res = $mysqli->query($sql);
$linha = $res->fetch_assoc();
$total = mysqli_num_rows($res);
?>
<html>
<style type="text/css">
	.titulo{
		font: 600 16px Oswald;
	}
</style>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="">
	<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
	<title>Pesquisar SubCategoria</title>
	<button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="py-5 text-center">
		<img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
		<h2>SubCategorias</h2>  
	</div>
	<div class="table-responsive">
		<table class="table" border="2" border rules="all">
			<tr class="titulo">
				<td><center>ID</center></td>
				<td><center>CATEGORIA</center></td>
				<td><center>SUBCATEGORIA</center></td>
				<td><center>AÇÃO</center></td>		
			</tr>
			<?php
			do{
				?>	
				<tr>
					<td><center><?php echo $linha['id_subcategoria']; ?></center></td>
					<td><center><?php echo $linha['categoria']; ?></center></td>
					<td><center><?php echo $linha['subcategoria']; ?></center></td>
					<td><center>
						<button onclick="javascript:window.location.href='editsubcategoria.php?id_subcategoria=<?php echo $linha['id_subcategoria']; ?>'"><img src="imagens/minidetail.gif">EDITAR</button>
						<button type="button" onclick="confirma('<?php echo $linha['id_subcategoria']; ?>')"><img src="imagens/miniremove.gif">EXCLUIR</button>
					</center></td>		
				</tr>
			<?php } while($linha = $res->fetch_assoc()); ?>
		</table></CENTER>
	</div>
	<?php echo "$total - REGISTROS"; ?> 
	
	<CENTER><a href="cadsubcategoria.php" class="btn btn-danger"> Cadastrar SubCategoria </a> </CENTER>
	<?php 
	$mysqli->close();
	?>
	<SCRIPT TYPE="text/javascript">
		function confirma(el){
			decisao = confirm("Tem certeza?");
			if (decisao){
				javascript:window.location.href='delsubcategoria.php?id_subcategoria='+el;
			}else{

			}
		}
	</SCRIPT>
</body>

</html>