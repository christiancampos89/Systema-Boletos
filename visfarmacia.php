<?php
	
	include_once("settings/setting.php");
	@session_start();

	$nome = $_SESSION['nome'];
  $usuario = $_SESSION['usuario'];

  if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario']))
  {
    header('location: index.php');
    exit;
  }
?>
<style type="text/css">
  .titulo
  {
    font: 600 16px Oswald;
  }
</style>
<html>
  
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
    <title>Pesquisar Farmácia</title>
    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </header>
  <body>
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
      <h2>Farmácias</h2>  
    </div>
    <?php
      //$sql = "SELECT * FROM farmacia ORDER BY razao_farmacia";
      $sql= "SELECT f.*, e.sigla, c.nome
      FROM farmacia f
      INNER JOIN estados e ON f.id_uf = e.cod_estados
      INNER JOIN cidades c ON e.cod_estados = c.estados_cod_estados
      WHERE f.id_cidade = c.cod_cidades ORDER BY razao_farmacia";
      $res = $mysqli->query($sql);
      $linha = $res->fetch_assoc();
      $total = mysqli_num_rows($res);
    ?>   
    	 <div class="table-responsive">
         <table class="table" border="2" border rules="all">
      		<tr class="titulo">
        		<td><center>ID</center></td>
        		<td>RAZÃO SOCIAL</td>
        		<td><center>CNPJ</center></td>
        		<td><center>UF</center></td>
        		<td><center>CIDADE</center></td>
            <td><center>REGIÃO</center></td>
        		<td><center>AÇÃO</center></td>		
      	  </tr>
          <?php
          do{
          ?>	
          <tr>
        		<td><center><?php echo $linha['id_farmacia']; ?></center></td>
        		<td><?php echo $linha['razao_farmacia']; ?></td>
        		<td><CENTER><?php echo $linha['cnpj']; ?></CENTER></td>
        		<td><CENTER><?php echo $linha['sigla']; ?></CENTER></td>
        		<td><CENTER><?php echo utf8_encode($linha['nome']); ?></CENTER></td>
            <td><CENTER><?php echo $linha['regiao']; ?></CENTER></td>
        		<td><center>
        			<button onclick="javascript:window.location.href='editfarmacia.php?id_farmacia=<?php echo $linha['id_farmacia']; ?>'"><img src="imagens/minidetail.gif">EDITAR</button>
              <button type="button" onclick="confirma('<?php echo $linha['id_farmacia']; ?>')"><img src="imagens/miniremove.gif">EXCLUIR</button>
        		</center></td>		
      	   </tr>
      	   <?php } while($linha = $res->fetch_assoc()); ?>
        </table>
      </div>
      <?php echo "$total - REGISTROS"; ?>
		
<CENTER><a href="cadfarmacia.php" class="btn btn-danger"> Cadastrar Farmácia</a> </CENTER>
<?php
$mysqli->close();
 ?>
 <SCRIPT TYPE="text/javascript">
  function confirma(el){
    decisao = confirm("Tem certeza?");
    if (decisao){
      javascript:window.location.href='delfarmacia.php?id_farmacia='+el;
    }else{

    }
  }
</SCRIPT>
</body>
</html> 