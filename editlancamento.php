<?php
  include("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
    $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

    $cod_boleto = $_GET['id_boleto'];

   if(!isset($_GET['id_boleto']))

      echo "<script> alert('Boleto Inválido.'); location.href='vislancamento.php' ; </script>";

      $sql= "SELECT * FROM boletos WHERE id_boleto = '$cod_boleto'";
      $res= $mysqli->query($sql) or die($mysqli->error);
      $linha = $res->fetch_assoc();

      $vid_fornecedor = $linha['id_fornecedor'];
      $vvalor = $linha['valor'];
      $vid_usuario = $linha['id_usuario'];
      $vdata_vencimento = $linha['data_vencimento'];
      $vnnota = $linha['nnota'];
      $vstatus = $linha['status'];
      $vtpdespesa = $linha['tpdespesa'];

      $sql_fornecedor = "SELECT fornecedor FROM fornecedores WHERE id_fornecedor = '$vid_fornecedor'";
      $resultado = $mysqli->query($sql_fornecedor);
      $linhas = $resultado->fetch_assoc();
      $vfornecedor = $linhas['fornecedor'];

      $j = 0;
      $sql_beneficiario = "SELECT * FROM fornecedores ORDER BY fornecedor";
      $result = $mysqli->query($sql_beneficiario);
        while($row = $result->fetch_array()){
          $id_fornecedor = $row['id_fornecedor'];
          $fornecedor = $row['fornecedor'];

          $arrayid_fornecedor[$j] = $id_fornecedor;
          $arrayfornecedor[$j] = $fornecedor;

          $j++;
        }
?>
<style type="text/css">
   .lbllanc{
      padding: 20px;
      font: 600 40px Oswald;
      color: #189FDA;
   }
   .lblmsg{
      font: 600 18px Oswald;
      color: #E91115;
   }
   
   .lblmsgg{
      font: 600 22px Oswald;
      color: #201E1E;
   }

   .lblfield{
      font: 600 26px Oswald;
      color: #201E1E;
    }

    fieldset select{
      width: 355px;
      height: 89px;
      font: 600 24px Oswald;
      text-align: center;
      background-color: #00BFFF;
      color: #fff;
    }
    .txtt:focus{
   border:thin solid:#f00;
   box-shadow:0 2px 10px #f00;
   -webkit-box-shadow:0 2px 10px #f00;
   -moz-box-shadow:0 2px 10px #f00;
   }

  .txtcompra{
  border: 3px solid #189FDA;
  height:45px;
  width: 135px;
  border: thin solid: #f1f1f1;
  }
</style>

<!doctype html>
<html>
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
    <title>Editar Valores de Compras</title>
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='lancamento.php'">Voltar</button>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </header>
  <body>
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
      <h2>EDITAR VALORES</h2>  
    </div>
       <div class="table-responsive">
        <form action="" method="POST">
         <table class="table" border="3">
          <tr class="titulo">
            <td><center>FORNECEDOR</center></td>
            <td><center>TIPO DESPESA</center></td>
            <td><center>Nº DOC.</center></td>
            <td><center>DATA VENCIMENTO</center></td>
            <td><center>SITUAÇÃO</center></td>
            <td><center>VALOR R$</center></td> 
          </tr> 
          <tr>
            <td><select class="form-control" name="txtfornecedor">
                  <option value="<?php echo "$vid_fornecedor";?>"><? echo $vfornecedor; ?></option>
                    <?php for($k = 0; $k <  $j; $k++){ ?>
                  <option class="optforn" value="<?php echo $arrayid_fornecedor[$k]; ?> <?= $vid_fornecedor == $arrayid_fornecedor[$k] ? 'selected' : ''; ?>"><?php echo $arrayfornecedor[$k]; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><select class="form-control" name="txttpdespesa" >
                  <option value="nada">SELECIONE O TIPO DE DESPESA</option>
                  <option class="form-control" value="MERCADORIA" <?= $vtpdespesa == "MERCADORIA" ? 'selected' : ''; ?>>MERCADORIA</option>
                  <option class="form-control" value="DIVERSOS" <?= $vtpdespesa == "DIVERSOS" ? 'selected' : ''; ?>>DIVERSOS</option>
                </select>
            </td>          
            <td>
                <input type="text" class="form-control" id="ndocumento" placeholder="" name="txtndocumento" value="<?php echo "$vnnota";?>">
            </td>  
            <td>
                <input type="date" class="form-control" id="datavencimento" placeholder="" name="txtdatavencimento" value="<?php echo "$vdata_vencimento";?>">
            </td>
            <td><select class="form-control" name="txtsituacao">
                  <option value="nada">SELECIONE A SITUAÇÃO</option>
                  <option class="form-control" value="ABERTO" <?= $vstatus == "ABERTO" ? 'selected' : ''; ?>>A VENCER</option>
                  <option class="form-control" value="PAGO" <?= $vstatus == "PAGO" ? 'selected' : ''; ?>>PAGO</option>
                  <option class="form-control" value="VENCIDO" <?= $vstatus == "VENCIDO" ? 'selected' : ''; ?>>VENCIDO</option>
                </select>
            </td>
            <td>
              <center><input type="text" class="txtvalor" name="valor" value="<?php echo "$vvalor";?>"></center>      
            </td>   
           </tr>
        </table>
          <center><input type="submit" class="btn btn-lg btn-primary btn-block" value="ALTERAR"></center>
          <center><input type="hidden" name="salvar" value="lancar"></center>
        </form>
      </div>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
      <script src="js/jquery.maskMoney.js" type="text/javascript"></script>
           
      <script>
        $('.txtvalor').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
      </script>

</body>
</html>
  <?php 
    if(isset($_POST['salvar']) && $_POST['salvar'] == "lancar"){
      $id_fornecedor = $_POST['txtfornecedor'];
      $ndocumento = $_POST['txtndocumento'];
      $datavencimento = $_POST['txtdatavencimento'];
      $status = $_POST['txtsituacao'];
      $tpdespesa = $_POST['txttpdespesa'];
      $valor_boleto = $_POST['valor'];
      $valor_correto = str_replace(".","",trim($valor_boleto));
      $valor_correto = str_replace(",",".",($valor_correto));
      $data_lancamento = date('Y/m/d');  
      if(empty($valor_correto)){
        echo '<script> alert("Preencha o campo VALOR!!!"); history.back();</script>';  
      }else{
        $sql= "UPDATE boletos SET 
          id_fornecedor = '$id_fornecedor',
          data_vencimento = '$datavencimento',
          nnota = '$ndocumento',
          valor = '$valor_correto',
          status = '$status',
          tpdespesa = '$tpdespesa',
          data_lancamento = '$data_lancamento'
          WHERE id_boleto = '$cod_boleto'";          
          $confirma= $mysqli->query($sql);          
          echo "<script> alert('Lançamento Alterado Com Sucesso!!!') ;</script>";
          echo "<script> location.href= 'vislancamento.php'; </script> " ;                
      }
    }                   
    $mysqli->close();
  ?>
