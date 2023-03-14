<?php
include_once("settings/setting.php");
@session_start();
if (!empty($_GET['search']))
{
    $data = $_GET['search'];
    $sql = "SELECT f.*, b.*
    FROM fornecedores f 
    INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
    WHERE f.fornecedor LIKE '%$data%' OR b.nnota LIKE '%$data%' OR b.status LIKE '%$data%' OR b.data_vencimento LIKE '%$data%' OR b.valor LIKE '%$data%' OR b.obs LIKE '%$data%' ORDER BY data_vencimento";
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
}else{
    $sql = "SELECT f.*, b.*
    FROM fornecedores f 
    INNER JOIN boletos b ON f.id_fornecedor = b.id_fornecedor
    ORDER BY data_vencimento";
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
    .box-search{
        display: flex;
        justify-content: center;
        gap: .1%;
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
            <div class="box-search">
                <input type="search" class="form-control w-15" style="text-align:center; font-size: 26px; " placeholder="Pesquisar" id="pesquisar">
                <button onclick="searchData()" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
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
                            <th>VALOR R$</th>
                            <th><center>AÇÃO</center></th>
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
                                <td><button onclick="javascript:window.location.href='editlancamento.php?id_boleto=<?php echo $linha['id_boleto']; ?>'"><img src="imagens/minidetail.gif"></button></td>
                                <td><button type="button" onclick="confirma('<?php echo $linha['id_boleto']; ?>')"><img src="imagens/miniremove.gif"></button></td>
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
                window.location = 'vislancamento.php?search='+search.value;
            }
        </script>
    </body>
</html>
    <?php  
        $mysqli->close();
    ?>

