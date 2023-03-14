<?php
	include_once("settings/setting.php");
	@session_start();

	$nome = $_SESSION['nome'];
   	$usuario = $_SESSION['usuario'];

   	if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
    	header('location: index.php');
      	exit;
   	}
?>
<html>
<style type="text/css">
	.titulo{
	font: 600 16px Oswald;
}
</style>
<header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
      <title>Mesas</title>
    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</header>
<body>
	<div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
      <h2>MESAS</h2>  
    </div>
		<?php
			$i = 1;
			$k = 1;
			$sql= "SELECT * FROM mesas";
			$res= $mysqli->query($sql);
			$total = mysqli_num_rows($res);
      		while($vreg = $res->fetch_row()){
      			$vid_mesa = $vreg[0];
      			$vnum_mesa = $vreg[1];
      			$vstatus_mesa = $vreg[2];

      			$mesa[$i] = $vnum_mesa;
      			$id_mesa[$i] =  $vid_mesa;
      			$status[$i] = $vstatus_mesa;

      			$i = $i + 1;
      		}

      			//echo "<input type=checkbox name=fmesa[] value=$vid_mesa>$vnum_mesa<br/>";
      		$j = 1;
		?>
		<?php
    		while($j <= $total){
    	?>
			<div class="table-responsive">
    			<table class="table" border="2" border rules="all">
    			<?php
    				while($k <= 3){
    			?>
				<td><center>
					<button <?php echo ($status[$j] == "aberta") ? "echo class='btn btn-success'" : "echo class='btn btn-danger'" ; ?> onclick="javascript:window.location.href='lancamento.php?id_mesa=<?php echo $id_mesa[$j]; ?>'"><img src="imagens/minidetail.gif"><?php echo $mesa[$j]; ?></button>
				</center></td>
				<?php $j = $j + 1;
				$k = $k + 1; 
			} ?>
		</table></CENTER>
		<?php $k = 1; ?>
	</div>
	<?php } ?>

<?php 
$mysqli->close();
 ?>
</body>

</html>