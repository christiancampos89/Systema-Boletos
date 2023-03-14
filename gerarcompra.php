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
  $linha = $res->fetch_array();
  $id_usuario = $linha['id_usuario'];

  $sqlll = "SELECT f.*
  FROM farmacia f
  INNER JOIN usuario_farmacia uf ON f.id_farmacia = uf.id_farmacia
  INNER JOIN usuarios u ON uf.id_usuario = u.id_usuario
  WHERE u.id_usuario = '$id_usuario' ";   
  $ress = $mysqli->query($sqlll);
  $linhas = $ress->fetch_assoc();
  $lojas = mysqli_num_rows($ress);
  $razao_farmacia = $linhas['razao_farmacia'];
  if ($lojas > 1){
    echo "<script> alert('VOCÊ POSSUI MAIS DE UMA LOJA -- DIRECIONANDO');</script>";
    header('location: gerarcompra2.php');
  }else{
    $vid_farmacia = $linhas['id_farmacia'];
    $sql ="SELECT f.razao_farmacia, c.valor, c.id_usuario, fo.razao_fornecedor, u.nome
    FROM farmacia f 
    INNER JOIN compras c ON f.id_farmacia = c.id_farmacia
    INNER JOIN fornecedor fo ON c.id_fornecedor = fo.id_fornecedor
    INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
    WHERE f.id_farmacia = '$vid_farmacia'";
    $res = $mysqli->query($sql);

    $id_vendedor = $linha['id_usuario'];
    $total = 0;
    $sql_code = "SELECT nome FROM usuarios WHERE id_usuario = '$id_vendedor'";
    $result = $mysqli->query($sql_code);
    $linhaa = $result->fetch_assoc();
    $nome_vendedor = $linhaa['nome'];
  }
   $i = 1;

    

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
   
   .lblrazao{
      font: 600 20px Oswald;
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
      font: 600 16px Oswald;
      color: #000000;
   }

   .txtt:focus{
   border:thin solid:#f00;
   box-shadow:0 2px 10px #f00;
   -webkit-box-shadow:0 2px 10px #f00;
   -moz-box-shadow:0 2px 10px #f00;
   }
   #valortotal{
    border-color: red;
    border-style: dashed;
    border-width: 4px;
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
    <title>Compras Efetuadas</title>
    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='sair.php'" >Sair</button><br/><br/>
    <label class="lblmsg">LOGADO : <?php echo $nome;?></label><br/><br/>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
  </header>
  <body>
    <div class="py-1 text-center">
      <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
      <h2>COMPRAS EFETUADAS</h2>  
    </div></br>    
    <div class="table-responsive">
      <label class="lbl">LOJA: </label> <label class="lblrazao"><?php echo $razao_farmacia; ?></label>
      <table border="3" class="table" border rules="all">
        <tr>
          <td><center>FORNECEDOR</center></td>
          <td><center>VALOR R$</center></td> 
          <td><center>VENDEDOR</center></td>
        </tr> 
        <?php while($linha = $res->fetch_array()){; ?>
        <tr>
          <td><CENTER><?php echo $linha['razao_fornecedor']; ?></CENTER></td>
          <td><CENTER><?php echo number_format($linha['valor'], 2, ',', '.'); ?></CENTER></td>
          <td><CENTER><?php echo $linha['nome']; ?></CENTER></td> 
          <?php $total+= $linha['valor']; ?>
          <?php };?>  
        </tr>
        <tr>
          <td class="lblmsg"><CENTER>TOTAL: </CENTER></td>
          <td class="lblmsg" id="valortotal"><CENTER><?php echo number_format($total, 2, ',', '.'); ?></CENTER></td></center></td> 
        </tr>
      </table>
    </div>
  </body>
</html>       
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

<?php
  $mysqli->close();
?>