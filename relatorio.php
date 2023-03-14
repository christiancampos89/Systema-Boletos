<?php
    include_once("settings/setting.php");
    @session_start();
   
    $nome = $_SESSION['nome'];
    $usuario = $_SESSION['usuario'];

    if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
        header('location: index.php');
        exit;
    }

    $total = isset($_POST["valor"]) ? $_POST["valor"] : '';
    $totall = isset($_POST["valor"]) ? $_POST["valor"] : '';

?>
<style type="text/css">
   .lbllanc{
      font: 600 38px Oswald;
      color: #189FDA;
   }
   .lblmsg{
      font: 600 18px Oswald;
      color: #E91115;
   }

   .lbl{
      font: 600 18px Oswald;
      color: #000000;
   }

.txtt:focus{
   border:thin solid:#f00;
   box-shadow:0 2px 10px #f00;
   -webkit-box-shadow:0 2px 10px #f00;
   -moz-box-shadow:0 2px 10px #f00;
   }
   
   .lblfield{
      font: 600 22px Oswald;
      color: #201E1E;
      text-align: center;
    }

    fieldset select{
      width: 344px;
      height: 84px;
      font: 600 18px Oswald;
      text-align: center;
    }
  
  
  .tablanc input{
      font: 600 18px Oswald;
      background-color: #FFFF00;
      text-align: center;
      width: 140px;
   }
   
   .tablanc td{
     font: 400 24px Oswald;
   }
   
   .total{
     font: 600 26px Oswald;
     color : red;
   }
</style>

<!doctype html>

<html lang="pt-br">
<header>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="">
  <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
  <title>Rel Compras Assoc/Conv</title>
  <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button><br/><br/>
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
</header>
<body class="bg-light">
        <center><h2>RELATÓRIO DE COMPRAS EFETUADAS</h2></center>   
    <form class="needs-validation" name="frmpesqfar" action="" method="POST">
              <p><label class="lblfield">TIPO DE LOJA:</label>
              <select class="form-control" name="txttipo" >
                    <option value="nada">SELECIONE O TIPO DE LOJA</option>
                    <option value="todas">TODOS</option>
                    <option value="associado">ASSOCIADO</option>
                    <option value="convidado">CONVIDADO</option>
              </select></br>
              <center><input type="submit" class="btn btn-success" value="BUSCAR"></center>
              <input type="hidden" name="pesquisar" value="BUSCAR">
      </form>

<?php
  if(isset($_POST['pesquisar']) && $_POST['pesquisar'] == "BUSCAR"){
    $vtipo = $_POST['txttipo'];
    $total = 0;
    if($vtipo == "nada" ){
      echo '<script> alert("Selecione um tipo de loja!"); history.back();</script>';
      exit;
    }elseif($vtipo == "todas"){
      $sql ="SELECT farmacia.razao_farmacia, farmacia.tipo, SUM(valor) AS total
      FROM fornecedor, farmacia, compras 
      WHERE compras.id_fornecedor = fornecedor.id_fornecedor AND compras.id_farmacia = farmacia.id_farmacia GROUP BY razao_farmacia ORDER BY tipo";
      $res = $mysqli->query($sql);
      $linha = $res->fetch_assoc();
    }else{
      $sql ="SELECT f.razao_farmacia, f.tipo, SUM(valor) AS total
      FROM farmacia f
      INNER JOIN compras c ON f.id_farmacia = c.id_farmacia
      INNER JOIN fornecedor fo ON c.id_fornecedor = fo.id_fornecedor 
      WHERE f.tipo = '$vtipo' GROUP BY razao_farmacia ORDER BY razao_farmacia";
      $res = $mysqli->query($sql);
      $linha = $res->fetch_assoc();
      $total = 0;
    }
?>
  <div class="table-responsive">
    <table border="3" class="table">
      <tr class="titulo">
        <td><center>FARMÁCIA</center></td>
        <td><center>TIPO DE LOJA</center></td>
        <td><center>R$ COMPRA</center></td>      
      </tr>
      <?php
      do{
      ?>   
      <tr>
        <td><?php echo $linha['razao_farmacia']; ?></td>
        <td><CENTER><?php echo strtoupper($linha['tipo']); ?></CENTER></td>
        <td><CENTER><?php echo 'R$'.' '. number_format($linha['total'], 2, ',', '.'); ?></CENTER></td>
        <?php $total+= $linha['total']; ?>  
      </tr>
      <?php } while($linha = $res->fetch_assoc()); ?>
      <tr>
        <td></td>
        <td class="lbl"><CENTER>TOTAL: </CENTER></td>
        <td class="total"><CENTER><?php echo 'R$'.' '. number_format($total, 2, ',', '.'); ?></CENTER></td></center></td> 
      </tr>
    </table>
  </div>     
<script>
function somar(){
  var total = "<?php echo $row; ?>";
  var soma = 0;
  for(var i=0; i<total; i++){
    soma += Number(document.getElementById("status_"+i).value);
  }
  document.getElementById("soma").value = soma;
}
somar();
</script>

<?php
  }
  $mysqli->close();
 ?>


</body>

</html>