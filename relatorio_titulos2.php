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
<style type="text/css">
   .lbllanc{
      font: 600 38px Oswald;
      color: #189FDA;
   }
   .lblmsg{
      font: 600 18px Oswald;
      color: #E91115;
   }
   
   .tablanc td{
     font: 400 24px Oswald;
   }
   
   
   .lblfield{
      font: 600 22px Oswald;
      color: #201E1E;
      text-align: center;
    }

    fieldset select{
      width: 344px;
      height: 84px;
      font: 600 22px Oswald;
      text-align: center;
      background-color: #189FDA;
      color: #FFFAFA;
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
      #div1 {
        float:left; 
        margin-bottom: 15px;
        width:50%;
        height:345px;
        border-width: 3px;
        border-style: dashed;
        border-color: #f00; 
        padding: 10px;
      }
      #div2{
        float:left;
        margin-left: 25px;
        margin-bottom: 15px; 
        width:50%;
        height:345px;
        border-width: 3px;
        border-style: dashed;
        border-color: #f00;
        padding: 10px;
      }

</style>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
    <title>Relatório</title>
    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button><br/><br/>
    <label class="lblmsg">LOGADO : <?php echo $nome;?></label><br/><br/>
    <button type="button" class="btn btn-success" onclick="javascript:window.location.href='exportparapagar.php'" >EXPORTAR EXCEL</button><br><br>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
</head>
<body>
  <div id="div1" class="col-md-3   order-md-1">
    <form class="needs-validation" name="frmpesqfar" action="" method="POST">
      <p><label class="lblfield">PESQUISA BOLETOS LANÇADOS:</label></p>
      <table class="bordered highlight">
        <thead>
          <tr>
            <th><input type="radio" id="MERCADORIA" name="tpmercadoria" value="MERCADORIA"/></th>
            <th>MERCADORIA</th>
          </tr>
          <tr><th></th> </tr>
        </thead>
        <tbody>
          <tr>
            <th><input type="radio" id="DIVERSOS" name="tpmercadoria" value="DIVERSOS"/></th>
            <th>OUTROS</th>
          </tr>
        </tbody>
      </table></br>
      <div class="row">
        <div class="col-md-5 mb-3">
          <label for="datainicial">DATA INICIAL</label>
          <input type="date" class="form-control" id="datainicial" placeholder="" name="txtdatainicial" value="">
        </div>
        <div class="col-md-5 mb-3">
          <label for="datafinal">DATA FINAL</label>
          <input type="date" class="form-control" id="datafinal" placeholder="" name="txtdatafinal" value="">
        </div>
      </div></br>
      <center><input type="submit" class="btn btn-success" value="BUSCAR"></center>
      <input type="hidden" name="pesquisar1" value="BUSCAR">
    </form>
  </div>
<?php
  if(isset($_POST['pesquisar1']) && $_POST['pesquisar1'] == "BUSCAR"){
    $vtipo = (isset($_POST['tpmercadoria'])) ? $_POST['tpmercadoria'] : null;
    $vdata_inicial = (isset($_POST['txtdatainicial'])) ? $_POST['txtdatainicial'] : null;
    $vdata_final = (isset($_POST['txtdatafinal'])) ? $_POST['txtdatafinal'] : null;
    if(empty($vdata_inicial) AND empty($vdata_final) AND empty($vtipo)){
      echo '<script> alert("É necessário Selecionar uma Data Inicial!");</script>';
      exit();
    }elseif(!empty($vdata_inicial) || !empty($vdata_final) AND empty($vtipo)){
      if ($vdata_inicial == null){
          echo '<script> alert("É necessário Selecionar uma Data Inicial!");</script>';
          exit();
        }elseif ($vdata_final == null){
          echo '<script> alert("É necessário Selecionar uma Data Final!"); </script>';
          exit();
        }else{
          $sql = "SELECT f.*, b.*
                    FROM fornecedores f 
                    INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
                    WHERE data_lancamento BETWEEN '$vdata_inicial' AND '$vdata_final'
                    ORDER BY data_lancamento";
          $res = $mysqli->query($sql);
          $registros = mysqli_num_rows($res);
          $linha = $res->fetch_assoc();
          $_SESSION['consulta'] = $sql;
        }
    }elseif(!empty($vdata_inicial) || !empty($vdata_final) AND !empty($vtipo)){
      if ($vdata_inicial == null){
        echo '<script> alert("É necessário Selecionar uma Data Inicial!");</script>';
        exit();
      }elseif ($vdata_final == null){
        echo '<script> alert("É necessário Selecionar uma Data Final!"); </script>';
        exit();
      }else{
        $sql = "SELECT f.*, b.*
          FROM fornecedores f 
          INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
          WHERE tpdespesa = '$vtipo' AND data_lancamento BETWEEN '$vdata_inicial' AND '$vdata_final'
          ORDER BY data_lancamento";
        $res = $mysqli->query($sql);
        $registros = mysqli_num_rows($res);
        $linha = $res->fetch_assoc();
        $_SESSION['consulta'] = $sql;
      }
    }
?> 
  <div class="table-responsive">
    <label class="lblmsg">Nº DE REGISTROS LOCALIZADOS : <?php echo $registros;?></label> 
    <table class="table" border="3" border rules="all">
          <tr class="titulo">
            <td><center>FORNECEDOR</center></td>
            <td><center>TIPO DESPESA</center></td>
            <td><center>Nº DOC.</center></td>
            <td><center>DATA VENCIMENTO</center></td>
            <td><center>SITUAÇÃO</center></td>
            <td><center>VALOR R$</center></td> 
            <td><center>OBS</center></td>
            <td><center>VALOR PAGO</center></td>
            <td><center>DATA PAG.</center></td>     
          </tr>
          <?php
          do{
          ?>   
          <tr>
            <td><?php echo $linha['fornecedor']; ?></td>
            <td><?php echo $linha['tpdespesa']; ?></td>
            <td><?php echo $linha['nnota']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($linha['data_vencimento'])); ?></td>
            <td><?php echo $linha['status']; ?></td>
            <td><CENTER><?php echo number_format($linha['valor'], 2, ',', '.'); ?></CENTER></td>
            <?php $total+= $linha['valor']; ?>
            <td><?php echo $linha['obs']; ?></td>
            <td><CENTER><?php echo number_format($linha['valor_pago'], 2, ',', '.'); ?></CENTER></td>
            <?php $total2+= $linha['valor_pago']; ?>
            <td><?php echo date('d/m/Y', strtotime($linha['data_pagamento'])); ?></td> 
          </tr>
          <?php } while($linha = $res->fetch_assoc()); ?>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="lblmsg"><CENTER>TOTAL: </CENTER></td>
            <td class="lblmsg"><CENTER><?php echo number_format($total, 2, ',', '.'); ?></CENTER></td></center></td>
            <td><td class="lblmsg"><CENTER><?php echo number_format($total2, 2, ',', '.'); ?></CENTER></td></center></td></td> 
          </tr>
    </table>
  </div>
  <?php } ?>       

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
<script>
function somar2(){
  var total2 = "<?php echo $row; ?>";
  var soma = 0;
  for(var i=0; i<total2; i++){
    soma += Number(document.getElementById("status_"+i).value);
  }
  document.getElementById("soma").value = soma;
}
somar();
</script>
</body>
</html>
<?php
$mysqli->close();
 ?>