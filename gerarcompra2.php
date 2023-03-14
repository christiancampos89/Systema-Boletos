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

   $sqlll = "SELECT lo.id_usuario, f.*
   FROM farmacia f
   INNER JOIN usuario_farmacia uf ON f.id_farmacia = uf.id_farmacia
   INNER JOIN usuarios lo ON uf.id_usuario = lo.id_usuario
   WHERE lo.id_usuario = '$id_usuario'";   
   $ress = $mysqli->query($sqlll);
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

   .lblmssg{
      font: 600 22px Oswald;
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
    <form name="frmpesqfar" action="" method="POST">
      <select class="form-control" name="txtfarmacia" >
        <option value="nada">SELECIONE UMA FARMÁCIA</option>
        <option value="todas">TODAS</option>
        <?php while($linha = $ress->fetch_array()){ ?>
          <option class="optforn" value="<?php echo $linha['id_farmacia'] ?>"><?php echo $i .' '.'-'.' '. $linha['razao_farmacia'] ?></option>
        <?php $i++; } ?>
      </select></br>
      <center><input type="submit" class="btn btn-lg btn-primary btn-block" value="BUSCAR"></center>
      <input type="hidden" name="pesquisar" value="BUSCAR">
    </form>
<?php
  if(isset($_POST['pesquisar']) && $_POST['pesquisar'] == "BUSCAR"){
    $vid_farmacia = $_POST['txtfarmacia'];
    if($vid_farmacia == "nada" ){
      echo '<script> alert("Selecione uma Farmácia!"); history.back();</script>';
      exit;
    }elseif($vid_farmacia == "todas"){
      $sql ="SELECT f.*, c.valor, c.id_usuario, fo.razao_fornecedor
      FROM farmacia f 
      INNER JOIN compras c ON f.id_farmacia = c.id_farmacia
      INNER JOIN fornecedor fo ON c.id_fornecedor = fo.id_fornecedor
      INNER JOIN usuario_farmacia uf ON f.id_farmacia = uf.id_farmacia
      INNER JOIN usuarios lo ON uf.id_usuario = lo.id_usuario
      WHERE lo.id_usuario = '$id_usuario'";
      $res = $mysqli->query($sql);
      $busca = mysqli_num_rows($res);
      $linha = $res->fetch_assoc();
      $id_vendedor = $linha['id_usuario'];
      $total = 0;
      $sql_code = "SELECT nome FROM usuarios WHERE id_usuario = '$id_vendedor'";
      $result = $mysqli->query($sql_code);
      $linhas = $result->fetch_assoc();
      $nome_vendedor = $linhas['nome'];
    }else{
      $sql ="SELECT f.*, c.valor, c.id_usuario, fo.razao_fornecedor
      FROM farmacia f 
      INNER JOIN compras c ON f.id_farmacia = c.id_farmacia
      INNER JOIN fornecedor fo ON c.id_fornecedor = fo.id_fornecedor
      WHERE f.id_farmacia = '$vid_farmacia' ";
      $res = $mysqli->query($sql);
      $busca = mysqli_num_rows($res);
      $linha = $res->fetch_assoc();
      $id_vendedor = $linha['id_usuario'];
      $total = 0;
      $sql_code = "SELECT nome FROM usuarios WHERE id_usuario = '$id_vendedor'";
      $result = $mysqli->query($sql_code);
      $linhas = $result->fetch_assoc();
      $nome_vendedor = $linhas['nome'];
    }   
    if($busca > 0){

    }else{
      echo '<script> alert("Nenhuma Compra Localizada!");</script>';
      exit;
    }
?>
<div class="table-responsive">
  <table border="3" class="table" border rules="all">
    <tr class="titulo">
      <td><center>RAZÃO SOCIAL</center></td>
      <td><center>VALOR R$</center></td>
      <td><center>FORNECEDOR</center></td>
      <td><center>VENDEDOR</center></td>
            
    </tr>
    <?php
    do{
    ?>   
    <tr>
      <td><?php echo $linha['razao_farmacia']; ?></td>
      <td><CENTER><?php echo number_format($linha['valor'], 2, ',', '.'); ?></CENTER></td>
      <?php $total+= $linha['valor']; ?>
      <td><CENTER><?php echo $linha['razao_fornecedor']; ?></CENTER></td>
      <td><CENTER><?php echo $nome_vendedor; ?></CENTER></td>
    </tr>
    <?php } while($linha = $res->fetch_assoc()); ?>
    <tr>
      <td class="lblmsg"><CENTER>TOTAL: </CENTER></td>
      <td class="lblmssg" id="valortotal"><CENTER><?php echo number_format($total, 2, ',', '.'); ?></CENTER></td></center></td> 
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
  }
  $mysqli->close();
?>