<?php
include_once("settings/setting.php");
@session_start();

$nome = $_SESSION['nome'];
$usuario = $_SESSION['usuario'];
$filial = $_SESSION['filial'];

if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
  header('location: index.php');
  exit;
}

$total = isset($_POST["valor"]) ? $_POST["valor"] : '';
$sql = "SELECT id_usuario FROM usuarios WHERE usuario = '$usuario'";
$res = $mysqli->query($sql);
$linha = $res->fetch_assoc();
$id_usuario = $linha['id_usuario'];

if (!empty($_GET['search']))
{
  $data = $_GET['search'];
  $sqll ="SELECT f.*, b.*
  FROM fornecedores f 
  INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
  WHERE status = 'PAGAMENTO' AND f.fornecedor LIKE '%$data%' OR b.nnota LIKE '%$data%' OR b.data_vencimento LIKE '%$data%' OR b.valor LIKE '%$data%' OR b.obs LIKE '%$data%' ORDER BY data_vencimento";
  $res = $mysqli->query($sqll);
  $busca = mysqli_num_rows($res);
  $linha = $res->fetch_assoc();
  $total = 0;
}else{
  $sqll ="SELECT f.*, b.*
  FROM fornecedores f 
  INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
  WHERE status = 'PAGAMENTO'
  ORDER BY data_vencimento";
  $res = $mysqli->query($sqll);
  $busca = mysqli_num_rows($res);
  $linha = $res->fetch_assoc();
  $total = 0;
  if($busca > 0){
  }else{
    echo '<script> alert("Não existem boletos no Pagamento!");</script>';
    echo "<script> location.href='relatorio_titulos.php'; </script>";
  }
}
$k = 0;
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

.txtvalor{
  border: 4px dashed #189FDA;
  height:40px;
  width: 110px;
  text-align: center;
  border: thin solid: #f1f1f1;
}
.box-search{
  display: flex;
  justify-content: center;
  gap: .1%;
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
  <title>Baixa de Boletos</title>
  <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button><br/><br/>
  <label class="lblmsg">LOGADO : <?php echo $nome;?></label><br/><br/>
  <label class="lblmsgg">FILIAL: </label><label class="lblmsg"><?php echo $filial;?></label><br/>
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
  <script src="js/jquery.mask.min.js" type="text/javascript"></script>
  <script>
    $(document).ready(function(){
      $('.txtvalor').mask('000.000.000.000.000,00', {reverse: true});
    });
        //$('.txtcompra').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
      </script>
    </head>
    <body>
      <div class="py-1 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h3>BOLETOS A SEREM BAIXADOS</h3>  
      </div>
      <div class="box-search">
        <input type="search" class="form-control w-15" style="text-align:center; font-size: 26px; " placeholder="Pesquisar" id="pesquisar">
        <button onclick="searchData()" class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>
        </button>
      </div>   
      <div class="table-responsive">
        <form action="" method="POST"> 
          <table class="table" border="3" border rules="all">
            <tr class="titulo">

              <td><center>FORNECEDOR</center></td>
              <td><center>TIPO DESPESA</center></td>
              <td><center>Nº DOC.</center></td>
              <td><center>DATA VENCIMENTO</center></td>
              <td><center>SITUAÇÃO</center></td>
              <td><center>VALOR BOLETO</center></td>
              <td><center>OBS</center></td>
              <td><center>MARCAR</center></td>
              <td><center>VALOR PAGO R$</center></td>     
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
                <td><?php echo number_format($linha['valor'], 2, ',', '.');  ?></td>
                <td><?php echo $linha['obs']; ?></td>
                <td>
                  <center><input type="checkbox" name="txtboleto[]" value="<?php echo $k; ?>"></center>             
                </td>
                <td>
                  <center><input type="text" class="txtvalor" text-align="center" name="valor[]" value="<?php echo number_format($linha['valor'], 2, ',', '.'); ?>"></center>
                  <input type="hidden" name="boleto[]" value="<?php echo $linha['id_boleto']; ?>">          
                </td>
                <?php $total+= $linha['valor'];
                $k++; ?>
              </tr>
            <?php } while($linha = $res->fetch_assoc());?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="lblmsg"><CENTER>TOTAL: </CENTER></td>
              <td class="lblmsg"><CENTER><?php echo number_format($total, 2, ',', '.'); ?></CENTER></td></center></td> 
            </tr>
          </table>
          <center><input type="submit" class="btn btn-lg btn-primary btn-block" value="BAIXAR"></center>
          <center><input type="hidden" name="salvar" value="lancar"></center>
        </form>
      </div>       

      <script>
        function somar(){
          var total = "<?php echo $row; ?>";
          var soma = 0;
          for(var i=0; i<total; i++)
          {
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
      <script type="text/javascript">
        var search = document.getElementById('pesquisar');
        function confirma(el){
          decisao = confirm("Tem certeza?");
          if (decisao){
            javascript:window.location.href='dellancamento.php?id_boleto='+el;
          }else{

          }
        }
        search.addEventListener("keydown", function(event){
          if(event.key === "Enter")
          {
            searchData();
          }
        });

        function searchData() {
          window.location = 'baixarboletos.php?search='+search.value;
        }
      </script>
    </body>
    </html>
    <?php 
    if(isset($_POST['salvar']) && $_POST['salvar'] == "lancar")
    {

      for ($i = 0; $i<= $busca; $i++)
      {
        $teste1 = ($_POST['txtboleto'][$i] !== null)?'selecionado':'Não selecionado';
        if ($teste1 == 'selecionado')
        {
          $num_linha = (int)$_POST['txtboleto'][$i];
          $cod_boleto = (int)$_POST['boleto'][$num_linha];
          $valor_boleto = isset($_POST['valor'][$num_linha]) ? $_POST['valor'][$num_linha] : null;
          $valor_correto = str_replace(".","",trim($valor_boleto));
          $valor_correto = str_replace(",",".",($valor_correto));
          $valor_boleto = $valor_correto;
          $data_pagamento = date('Y/m/d');

          $sql= "UPDATE boletos SET 
          status = 'PAGO',
          valor_pago = '$valor_boleto',
          data_pagamento = '$data_pagamento'
          WHERE id_boleto = '$cod_boleto'";          
          $confirma= $mysqli->query($sql);

        }else{

        }
        


      }          
      echo "<script> alert('Boletos Baixados Com Sucesso!!!') ;</script>";
      echo "<script> location.href= 'relatorio_titulos.php'; </script> " ;
    }         
    $mysqli->close();
    ?>