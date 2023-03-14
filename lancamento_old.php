<?php
   include_once("settings/setting.php");
   @session_start();

   $nome = $_SESSION['nome'];

   $sqlll = "SELECT id_usuario, permissao FROM usuarios WHERE nome = '$nome'";
   $res = $mysqli->query($sqlll);
   $linha = $res->fetch_assoc();

   $id_usuario = $linha['id_usuario'];
   $permissao = $linha['permissao'];
   
   $sql_code ="SELECT * FROM fornecedores";
   $res = $mysqli->query($sql_code);
   $linha = $res->fetch_assoc();

   $vcod_fornecedor = "";
   $vdata_vencimento = "";
   $vnnota = "";
   $vstatus = "";

   $vcod_fornecedor = isset($_POST["txtbeneficiario"]) ? $_POST["txtbeneficiario"] : '';
   $vdata_vencimento = isset ($_POST["txtdatavencimento"]) ? $_POST["txtdatavencimento"] : '';
   $vnnota = isset($_POST["txtnnota"]) ? $_POST["txtnnota"] : '';
   $vstatus = isset($_POST["txtstatus"]) ? $_POST["txtstatus"] : '' ;
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

  .titulo{
    font: 600 20px Oswald;
    color: black;
   }
   
   .lblmsgg{
      font: 600 22px Oswald;
      color: #201E1E;
   }

   .lblfield{
      font: 600 26px Oswald;
      color: #201E1E;
    }

  .txtt:focus{
   border:thin solid:#f00;
   box-shadow:0 2px 10px #f00;
   -webkit-box-shadow:0 2px 10px #f00;
   -moz-box-shadow:0 2px 10px #f00;
   }

  .txtcompra{
  border: 4px dashed #189FDA;
  height:40px;
  width: 110px;
  text-align: center;
  border: thin solid: #f1f1f1;
  }

    fieldset select{
      width: 355px;
      height: 89px;
      font: 600 24px Oswald;
      text-align: center;
      background-color: #00BFFF;
      color: #fff;
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
    <title>Lançamento de Boletos</title>
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='sair.php'" >Sair</button>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="js/jquery.mask.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function(){
        $('.txtcompra').mask('000.000.000.000.000,00', {reverse: true});
      });
        //$('.txtcompra').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    </script>
  </header>
  <body>
  </br>
    <label class="lblmsgg">USUÁRIO:</label><label class="lblmsg"><?php echo $nome;?></label><br/>
    <div class="py-1 text-center">
      <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
      <h3>LANÇAR VALORES</h3>  
    </div>
    <?php
      $sql_code = "SELECT * FROM fornecedores ORDER BY fornecedor";
      $result = $mysqli->query($sql_code);

      $registro = 0;
    ?>   
       <div class="table-responsive">
        <form action="" method="POST">
         <table class="table" border="3" border rules="all">
          <tr class="titulo">
            <td><center>BENEFICIARIO</center></td>
            <td>DATA DE VENCIMENTO</td>
            <td>Nº DA NOTA</td>
            <td><center>VALOR R$</center></td>
            <td>STATUS</td>   
          </tr>
          <?php
          do{
            $registro++;
          ?>  
          <tr>
            <td><select class="form-control" name="txtbeneficiario" >
                        <option value="nada">SELECIONE O BENEFICIÁRIO</option>
                        <?php while($linha = $result->fetch_array()){ ?>
                        <option class="optforn" value="<?php echo $linha['id_fornecedor']; ?>"><?php echo $linha['fornecedor']; ?></option>
                      <?php } ?>
                     </select></td>
            <td><input type="date" class="form-control" id="datavencimento" placeholder="" name="txtdatavencimento" value=""></td>
            <td><input type="text" class="form-control" id="nnota" placeholder="" name="txtnnota" value=""></td>          
            <td>
              <center><input type="text" class="txtcompra" name="valor[]"></center> 
              <input type="hidden" style="display: none" class="txtcompra" name="fornecedor[]" value="<?php echo $linha['id_fornecedor']; ?>" >      
            </td>
            <td><select class="form-control" name="txtstatus" >
                        <option value="nada">SELECIONE O STATUS</option>
                        <option class="optforn" value="ABERTO">EM ABERTO</option>
                        <option class="optforn" value="PAGO">PAGO</option>
                     </select></td>   
           </tr>

           <?php } while($registro < 10 ); ?>
        </table>
          <center><input type="submit" class="btn btn-lg btn-primary btn-block" value="LANÇAR"></center>
          <center><input type="hidden" name="salvar" value="lancar"></center>

        </form>
        <button type="button" class="btn btn-success" onclick="javascript:window.location.href='vislancamento.php'" >EDITAR LANÇAMENTOS</button>
      </div>
    
      

</body>
</html>
         <?php 
            if(isset($_POST['salvar']) && $_POST['salvar'] == "lancar"){
                    $vcod_fornecedor = $_POST["txtbeneficiario"];
                    $vdata_vencimento = $_POST["txtdatavencimento"];
                    $vnnota = $_POST["txtnnota"];
                    $vstatus = $_POST["txtstatus"];
                    $valor_boleto = $_POST["valor"];

                    var_dump($vcod_fornecedor);
                    echo $vdata_vencimento;
                    echo $vnnota;
                    echo $vstatus;


                    /* if ($valor_boleto > 0){
                      var_dump($valor_boleto);
                      $sql= "INSERT INTO boletos VALUES(NULL,'$cod_fornecedor', '$datavencimento', '$numero_nota', '$valor_correto', '$status', '$id_usuario')";
                      $res= $mysqli->query($sql) or die($mysqli->error);
                    } */         
              //echo '<script> alert("BOLETO LANÇADO COM SUCESSO!");</script>';  
              }
          $mysqli->close();
          ?>
