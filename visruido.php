<?php
include_once("settings/setting.php");
@session_start();
$sql = "SELECT * FROM ruidos";
$res = $mysqli->query($sql);
$data = [];
$i = 0;
while($linha = $res->fetch_assoc()){
    $data[$i]['id_ruido']       = $linha['id_ruido'];
    $data[$i]['id_farmacia']    = $linha['id_farmacia'];
    $data[$i]['id_fornecedor']  = $linha['id_fornecedor'];
    $data[$i]['detalhes']       = $linha['detalhes'];
    $data[$i]['data']           = $linha['data'];
    $data[$i]['fazer_contato']  = $linha['fazer_contato'];
    $i++;
}
require_once('Export.php');
$export = new Export();

if(isset($_GET['export']) && $_GET['export'] == 'excel'){
    $export->excel('Lista de Contatos', $_GET['fileName'], $data);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ruídos Dpto Comercial</title>
        <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    </head>
    <body>

    <div class="container">
        <div class="row">
            <center><h1>Lista de Ruídos</h1></center>
        </div>
        <div class="row">
            <buttom class="dropdown-button btn right" data-activates="btn-export">Exportar</buttom>
            <ul id="btn-export" class="dropdown-content" style="margin-top: 40px;">
                <li><a href="?export=excel&&fileName=contatos">Excel</a></li>
            </ul>
        </div>
        <div class="row">
            <table class="bordered highlight">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID FARMÁCIA</th>
                        <th>ID FORNECEDOR</th>
                        <th>DETALHES</th>
                        <th>DATA</th>
                        <th>FAZER CONTATO?</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $linha): ?>
                        <tr>
                            <td><?php echo $linha['id_ruido'];  ?></td>
                            <td><?php echo $linha['id_farmacia'];  ?></td>
                            <td><?php echo $linha['id_fornecedor'];  ?></td>
                            <td><?php echo $linha['detalhes'];  ?></td>
                            <td><?php echo $linha['data'];  ?></td>
                            <td><?php echo $linha['fazer_contato'];  ?></td>
                            <td><button onclick="javascript:window.location.href='editruido.php?id_ruido=<?php echo $linha['id_ruido']; ?>'"><img src="imagens/minidetail.gif"></button></td>
                            <td><button type="button" onclick="confirma('<?php echo $linha['id_ruido']; ?>')"><img src="imagens/miniremove.gif"></button></td>
                        </tr>
                    <?php endforeach; ?>
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
    <SCRIPT TYPE="text/javascript">
        function confirma(el){
            decisao = confirm("Tem certeza?");
            if (decisao){
                javascript:window.location.href='delruido.php?id_ruido='+el;
            }else{

            }
        }
    </SCRIPT>

</html>