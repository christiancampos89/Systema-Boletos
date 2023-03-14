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

    $sqll ="SELECT f.*, b.*
    FROM fornecedores f 
    INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
    ORDER BY data_vencimento";
    
    $res = $mysqli->query($sqll);
    $busca = mysqli_num_rows($res);
    $linha = $res->fetch_assoc();
    $total = 0;     
    
    if($busca > 0){
    }else{
    echo '<script> alert("Nenhum Lançamento Localizado!");</script>';
    echo "<script> location.href='lancamento.php'; </script>";
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
    <title>Relatorio Ger.</title>
    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button><br/><br/>
    <label class="lblmsg">LOGADO : <?php echo $nome;?></label><br/><br/>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
</header>
<body>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Relatório Gerencial</h2></br></br>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">  
              <label class="lblfield">SITUAÇÃO DO BOLETO:</label>
              <select class="form-control" name="txttipo" >
                <option value="nada">SELECIONE O STATUS DO BOLETO</option>
                <option value="todos">TODOS</option>
                <option value="PAGO">PAGOS</option>
                <option value="ABERTO">EM ABERTO</option>
                <option value="PAGAMENTO">PARA PAGAMENTO</option>
              </select></br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 mb-3">
              <label class="lblfield">DATA INICIAL</label>
              <input type="date" class="form-control" id="datainicial" placeholder="" name="txtdatainicial" value=""></br>
            </div>
            <div class="col-md-5 mb-3">
              <label class="lblfield">DATA FINAL</label>
              <input type="date" class="form-control" id="datafinal" placeholder="" name="txtdatafinal" value="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 mb-3">
              <input type="radio" id="MERCADORIA" name="tpmercadoria" value="MERCADORIA"/>MERCADORIA</br>
              <p><input type="radio" id="DIVERSOS" name="tpmercadoria" value="DIVERSOS"/>OUTROS</p></br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 mb-3">
              <center><input type="submit" class="btn btn-success" value="BUSCAR"></center>
              <input type="hidden" name="pesquisar" value="BUSCAR">
            </div>
          </div>
        </form>
      </div>
<?php
  if(isset($_POST['pesquisar']) && $_POST['pesquisar'] == "BUSCAR"){
    $vsituacao = $_POST['txttipo'];
    $vtipo = (isset($_POST['tpmercadoria'])) ? $_POST['tpmercadoria'] : null;
    if($vsituacao == "nada" ){
      echo '<script> alert("Selecione a situação do Boleto!")';
      exit;
    }elseif($vsituacao == "todos"){
      $sql = "SELECT f.*, b.*
              FROM fornecedores f 
              INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
              ORDER BY data_vencimento";
      $res = $mysqli->query($sql);
      $registros = mysqli_num_rows($res);
      $linha = $res->fetch_assoc();
    }elseif(isset($_POST['tpmercadoria'])){
      $sql = "SELECT f.*, b.*
              FROM fornecedores f 
              INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
              WHERE status = '$vsituacao' AND tpdespesa = '$vtipo'
              ORDER BY data_vencimento";
      $res = $mysqli->query($sql);
      $registros = mysqli_num_rows($res);
      $linha = $res->fetch_assoc();
    }else{
      $sql = "SELECT f.*, b.*
              FROM fornecedores f 
              INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
              WHERE status = '$vsituacao'
              ORDER BY data_vencimento";
      $res = $mysqli->query($sql);
      $registros = mysqli_num_rows($res);
      $linha = $res->fetch_assoc();

    }
?>
  <div class="py-1 text-center">
    <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
    <h3>LANÇAMENTOS EFETUADOS</h3>  
  </div>   
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
<SCRIPT TYPE="text/javascript">
  function confirma(el){
    decisao = confirm("Tem certeza?");
    if (decisao){
      javascript:window.location.href='dellancamento.php?id_boleto='+el;
    }else{

    }
  }
</SCRIPT>
</body>
</html>
<?php

$mysqli->close();
 ?>