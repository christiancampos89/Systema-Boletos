<?php
include_once("settings/setting.php");
@session_start();

//$_SESSION['tipo'] = $vstatus;

$sql = $_SESSION['consulta'];

//$sql = "SELECT f.*, b.*
//    FROM fornecedores f 
//    INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
//    WHERE status = '$vstatus'
//    ORDER BY data_vencimento";
$res = $mysqli->query($sql);
$data = [];
$i = 0;
$total = 0;
while($linha = $res->fetch_assoc()){
    $data[$i]['id_boleto']       = $linha['id_boleto'];
    $data[$i]['fornecedor']    = $linha['fornecedor'];
    $data[$i]['data_vencimento']  = $linha['data_vencimento'];
    $data[$i]['nnota']       = $linha['nnota'];
    $data[$i]['valor']           = $linha['valor'];
    $data[$i]['status']  = $linha['status'];
    $data[$i]['tpdespesa']  = $linha['tpdespesa'];
    $data[$i]['id_usuario']  = $linha['id_usuario'];
    $data[$i]['data_lancamento']  = $linha['data_lancamento'];
    $data[$i]['data_pagamento'] = $linha['data_pagamento'];
    $data[$i]['valor_pago'] = $linha['valor_pago'];
    $data[$i]['obs'] = $linha['obs'];
    $i++;
}
require_once('Export.php');
$export = new Export();

if(isset($_GET['export']) && $_GET['export'] == 'excel'){
    $export->excel('Lista de Boletos', $_GET['fileName'], $data);

}
?>

<style type="text/css">
    .lblmsg{
      font: 600 18px Oswald;
      color: #E91115;
   }
</style>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Relação de Boletos</title>
        <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    </head>
    <body>
    <div class="container">
        <div class="row">
            <center><h1>Lista de Boletos a Pagar</h1></center>
        </div>
        <div class="row">
            <buttom class="dropdown-button btn right" data-activates="btn-export">Exportar</buttom>
            <ul id="btn-export" class="dropdown-content" style="margin-top: 40px;">
                <li><a href="?export=excel&&fileName=Boletos">Excel</a></li>
            </ul>
        </div>
        <div class="row">
            <table class="bordered highlight">
                <thead>
                    <tr>
                        <th>FORNECEDOR</th>
                        <th>TIPO DESPESA</th>
                        <th>Nº DOCUMENTO</th>
                        <th>DATA VENCIMENTO</th>
                        <th>SITUAÇÃO</th>
                        <th>OBS</th>
                        <th>VALOR BOLETO R$</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $linha): ?>
                        <tr>
                            <td><?php echo $linha['fornecedor'];  ?></td>
                            <td><?php echo $linha['tpdespesa'];  ?></td>
                            <td><?php echo $linha['nnota'];  ?></td>
                            <td><?php echo date('d/m/Y', strtotime($linha['data_vencimento']));  ?></td>
                            <td><?php echo $linha['status'];  ?></td>
                            <td><?php echo $linha['obs'];  ?></td>
                            <td><?php echo number_format($linha['valor'], 2, ',', '.');  ?></td>
                            <?php $total+= $linha['valor']; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="lblmsg">TOTAL:</td>
                        <td class="lblmsg"><?php echo number_format($total, 2, ',', '.'); ?></td></td> 
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    </body>
    <?php  
        $mysqli->close();
    ?>
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

</html>