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

   $sql = "SELECT id_usuario FROM usuarios WHERE usuario = '$usuario'";
   $res = $mysqli->query($sql);
   $linha = $res->fetch_assoc();
   $id_usuario = $linha['id_usuario'];

    $sqll ="SELECT f.*, b.*
    FROM fornecedores f 
    INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
    WHERE status = 'ABERTO'
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
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
    <title>Lançamentos Efetuados</title>
    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button><br/><br/>
    <label class="lblmsg">LOGADO : <?php echo $nome;?></label><br/><br/>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
</head>
<body>
  <div class="py-1 text-center">
    <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
    <h3>LANÇAMENTOS EFETUADOS</h3>  
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
          <td><center>OBS</center></td>
          <td><center>MARCAR</center></td>
          <td><center>VALOR R$</center></td>     
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
          <td><?php echo $linha['obs']; ?></td>
          <td><center><input type="checkbox" name="txtboleto[]" value="<?php echo $linha['id_boleto']; ?>"></center></td>
          <td><CENTER><?php echo number_format($linha['valor'], 2, ',', '.'); ?></CENTER></td>
          <?php $total+= $linha['valor']; ?>
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
      <center><input type="submit" class="btn btn-lg btn-primary btn-block" value="ENVIAR"></center>
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
</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/validacao.js"></script>
</html>
<?php 
if(isset($_POST['salvar']) && $_POST['salvar'] == "lancar")
{
  $boletos = isset($_POST['txtboleto']) ? $_POST['txtboleto'] : null;
  if($boletos !== null)
  {    
    for ($i = 0; $i< count($boletos); $i++)
    {

      $sql= "UPDATE boletos SET 
      status = 'PAGAMENTO'
      WHERE id_boleto = '$boletos[$i]'";          
      $confirma= $mysqli->query($sql);
    }          
      echo "<script> alert('Boleto Enviado Com Sucesso!!!') ;</script>";
      echo "<script> location.href= 'relatorio_titulos.php'; </script> " ;
  }
}          
$mysqli->close();
?>