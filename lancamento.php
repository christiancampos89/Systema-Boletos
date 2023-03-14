<?php
   include_once("settings/setting.php");
   @session_start();

   $nome = $_SESSION['nome'];
   $filial = $_SESSION['filial'];

   $sqlll = "SELECT id_usuario, permissao FROM usuarios WHERE nome = '$nome'";
   $res = $mysqli->query($sqlll);
   $linha = $res->fetch_assoc();

   $id_usuario = $linha['id_usuario'];
   $permissao = 2;
   $registro = 0;
   $vfornecedor = "";
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
      padding-top: 20px;
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

  .txtvalor{
  border: 4px dashed #189FDA;
  height:40px;
  width: 110px;
  text-align: center;
  border: thin solid: #f1f1f1;
  }

.txtvalor2{
  border: 4px dashed #FE2E2E;
  height:40px;
  width: 110px;
  text-align: center;
  border: thin solid: #f1f1f1;
  }

  .txtvalormodel{
  border: 4px dashed #FF0000;
  height:40px;
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
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title>Lançamento de Boletos</title>
    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button></br>
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
    <label class="lblmsgg">USUÁRIO: </label><label class="lblmsg"><?php echo $nome;?></label><br/>
    <label class="lblmsgg">FILIAL: </label><label class="lblmsg"><?php echo $filial;?></label><br/>
    <div class="py-1 text-center">
      <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
      <h3>BOLETOS / DESPESAS</h3>
        <?php
          if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
          }
          if(isset($_SESSION['msgcad'])){
            echo $_SESSION['msgcad'];
            unset($_SESSION['msgcad']);
          }
        ?>  
    </div>
    <?php
      $j = 0;
      $sql = "SELECT * FROM fornecedores ORDER BY fornecedor";
      $res = $mysqli->query($sql);
        while($linha = $res->fetch_array()){
          $id_fornecedor = $linha['id_fornecedor'];
          $fornecedor = $linha['fornecedor'];

          $arrayid_fornecedor[$j] = $id_fornecedor;
          $arrayfornecedor[$j] = $fornecedor;

          $j++;
        }
    ?>   
      <div class="table-responsive">
        <form action="" method="POST">
         <table class="table" border="3" border rules="all">
          <tr class="titulo">
            <td><center>FORNECEDOR</center></td>
            <td><center>TIPO DESPESA</center></td>
            <td><center>Nº DOC.</center></td>
            <td><center>DATA VENCIMENTO</center></td>
            <td><center>SITUAÇÃO</center></td>
            <td><center>OBS.</center></td>
            <!--<td><center>VALOR NOTA</center></td>-->
            <td><center>VALOR BOLETO</center></td>
            <!--<td><center>CUSTO DO BOLETO</center></td> -->   
          </tr>
          <?php
          do{
          $registro++;  
          ?>  
          <tr>
            <td><select class="form-control" name="txtfornecedor[]" >
                  <option value="nada">SELECIONE O BENEFICIÁRIO</option>
                    <?php for($k = 0; $k <  $j; $k++){ ?>
                  <option class="optforn" value="<?php echo $arrayid_fornecedor[$k]; ?>"><?php echo $arrayfornecedor[$k]; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><select class="form-control" name="txttpdespesa[]" >
                  <option value="nada">SELECIONE O TIPO DE DESPESA</option>
                  <option class="form-control" value="MERCADORIA" <?= 'selected'; ?>>MERCADORIA</option>
                  <option class="form-control" value="DIVERSOS">DIVERSOS</option>
                </select>
            </td>          
            <td>
                <input type="text" class="form-control" id="ndocumento" placeholder="" name="txtndocumento[]" value="">
            </td>  
            <td>
                <input type="date" class="form-control" id="datavencimento" placeholder="" name="txtdatavencimento[]" value="">
            </td>
            <td><select class="form-control" name="txtsituacao[]" >
                  <option value="nada">SELECIONE A SITUAÇÃO</option>
                  <option class="form-control" value="ABERTO" <?= 'selected'; ?>>A VENCER</option>
                  <option class="form-control" value="PAGO">PAGO</option>
                  <option class="form-control" value="VENCIDO">VENCIDO</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" id="obs" placeholder="" name="txtobs[]" value="">
            </td>
            <!--<td>
              <center><input type="text" class="txtvalor2" name="valor2[]"></center>      
            </td> -->
            <td>
              <center><input type="text" class="txtvalor" name="valor[]"></center>      
            </td>
            <!--<td>
                <input type="text" class="form-control" id="custoboleto" placeholder="" name="txtcustoboleto[]" value="">
            </td> -->   
           </tr>
           <?php } while($registro < 12); ?>
        </table>
          <center><input type="submit" class="btn btn-lg btn-primary btn-block" value="LANÇAR"></center>
          <center><input type="hidden" name="salvar" value="lancar"></center>

        </form>
        <button type="button" class="btn btn-success" onclick="javascript:window.location.href='vislancamento.php'" >EDITAR LANÇAMENTOS</button></br></br>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#caddespesa" m-3>
          CADASTRAR OUTRAS DESPESAS
        </button>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="caddespesa" tabindex="-1" aria-labelledby="caddespesaLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="py-1 text-center">
              <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
              <h3>CADASTRO DE DESPESAS</h3>  
            </div>
            <div class="modal-body">
              <form id="caddespesa-form" method="POST" action="proc_cad_despesa.php">
                <span id="msgAlertError"> </span>
                <div class="mb-3">
                  <label for="txttpdespesamodel" class="col-form-label">TIPO DE DESPESA</label>
                  <select class="form-control" name="txttpdespesamodel" id="txttpdespesamodel" >
                    <option value="">SELECIONE O TIPO DE DESPESA</option>
                    <option class="form-control" value="MERCADORIA" <?= 'selected'; ?>>MERCADORIA</option>
                    <option class="form-control" value="DIVERSOS">DIVERSOS</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="txtobsmodel" class="col-form-label">OBSERVAÇÃO</label>
                  <input type="text" class="form-control" name="txtobsmodel" id="txtobsmodel">
                </div>
                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="txtdatavencimento" class="col-form-label">VENCIMENTO</label>
                    <input type="date" class="form-control" id="datavencimento" placeholder="" name="txtdatavencimento" value="">
                  </div>
                  <div class="col-md-5 mb-3">
                    <label for="txtdatapagamento" class="col-form-label">PAGAMENTO</label>
                    <input type="date" class="form-control" id="datapagamento" placeholder="" name="txtdatapagamento" value=""></br>
                  </div>
                </div>
                <div class="mb-3">
                  <center><label for="valormodel" class="titulo" >VALOR</label></center></br>
                  <center><input type="text" class="txtvalor" name="valormodel" style="width: 200px;" id="valormodel"></center></br>
                </div>
                <div class="mb-3">
                  <center><input type="submit" class="btn btn-primary" value="LANÇAR"></center>
                  <center><input type="hidden" name="salvar" value="lancarr"></center>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      <script src="js/custom.js"> </script>
</body>
</html>
         <?php 
            if(isset($_POST['salvar']) && $_POST['salvar'] == "lancar"){
              if($permissao != 2){
                echo "<script> alert('VOCÊ NÃO TEM PERMISSÃO PARA EFETUAR LANÇAMENTOS!') ; </script>";
              }else{
                for ($i = 0; $i< $k; $i++){
                    $codfornecedor = $_POST['txtfornecedor'][$i];
                    $valor_boleto = $_POST['valor'][$i];
                    $valor_correto = str_replace(".","",trim($valor_boleto));
                    $valor_correto = str_replace(",",".",($valor_correto));
                    $valor_nota = $_POST['valor2'][$i];
                    $valor_correto_nota = str_replace(".","",trim($valor_nota));
                    $valor_correto_nota = str_replace(",",".",($valor_correto_nota));
                    $data_vencimento = $_POST['txtdatavencimento'][$i];
                    $tpdespesa = $_POST['txttpdespesa'][$i];
                    $nnota = $_POST['txtndocumento'][$i];
                    $status = $_POST['txtsituacao'][$i];
                    $data_hoje = date('Y/m/d');
                    $obs = $_POST['txtobs'][$i];
                    $data_pagamento = '1900/01/01';
                    $valor_pago = '0,00';
                    if ($status == 'PAGO'){
                      $data_pagamento = date('Y/m/d');
                      $valor_pago = $valor_correto;
                    }
                    if ($valor_boleto > 0){
                      $sql= "INSERT INTO boletos VALUES (NULL,'$codfornecedor', '$data_vencimento','$nnota', '$valor_correto', '$status', '$tpdespesa', '$id_usuario', '$data_hoje', '$data_pagamento', '$valor_pago', '$obs')";
                      $res= $mysqli->query($sql) or die($mysqli->error);

                    }
                }          
              echo '<script> alert("LANÇAMENTO EFETUADO COM SUCESSO!");</script>';  
              }
            }
          $mysqli->close();
          shell_exec('C:\Program Files (x86)\EasyPHP-DevServer-14.1VC9\binaries\mysql\bin\mysqldump -u root itaipu > "C:\Users\Escritorio Itaipu\Desktop\System_Itaipu\backup_banco\backup.sql"');
          ?>
