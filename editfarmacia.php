<?php
    include_once("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

    $cod_farmacia = $_GET['id_farmacia'];

   if(!isset($_GET['id_farmacia']))
      echo "<script> alert('Farmácia Inválida.'); location.href='visfarmacia.php' ; </script>";

      $sql= "SELECT f.*, e.cod_estados, e.sigla, c.nome, c.cod_cidades
      FROM farmacia f
      INNER JOIN estados e ON f.id_uf = e.cod_estados
      INNER JOIN cidades c ON e.cod_estados = c.estados_cod_estados
      WHERE c.cod_cidades = f.id_cidade AND id_farmacia = '$cod_farmacia'";
      $res= $mysqli->query($sql) or die($mysqli->error);
      $linha = $res->fetch_assoc();

      $vrazao     = $linha['razao_farmacia'] ;
      $vcnpj      = $linha['cnpj'];
      $vie        = $linha['insc_estadual'];
      $vid_estado = $linha['cod_estados'];
      $vuf        = $linha['sigla'];
      $vid_cidade = $linha['cod_cidades'];
      $vcidade    = utf8_encode($linha['nome']);
      $vregiao    = $linha['regiao'];
      $vtipo      = $linha['tipo'];

   ?>

<html>
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <title>Alteração Farmácia</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">

  </header>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Alteração de Farmácia</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-5 mb-3">
              <label for="razaosocial">RAZAO SOCIAL*</label>
              <input type="text" class="form-control" id="razaosocial" placeholder="" name="txtrazao" value="<?php echo "$vrazao";?>" required>
            </div>
            <div class="col-md-4   mb-3">
              <label for="cnpj">CNPJ*</label>
              <input type="text" class="form-control" id="cnpj" placeholder="" name="txtcnpj" value="<?php echo "$vcnpj";?>" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="inscestadual">INSC. ESTADUAL</label>
              <input type="text" class="form-control" id="inscestadual" placeholder="" name="txtie" value="<?php echo "$vie";?>" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 mb-3">
              <label for="uf">UF*</label>
              <select class="form-control" id="uf" name="txtid_uf" required>
                <option value="<?php echo "$vid_estado";?>"><?php echo "$vuf";?></option>
                <?php
                  $sql = "SELECT cod_estados, sigla
                      FROM estados
                      ORDER BY sigla";
                  $res = $mysqli->query($sql);
                  while ($row = $res->fetch_array()){
                    echo '<option value="'.$row['cod_estados'].'">'.$row['sigla'].'</option>';
                  }
                ?>
                </option>
              </select>
            </div>            
            <div class="col-md-6 mb-3">
              <label for="cod_cidades">CIDADE*</label>
              <select class="form-control" id="cod_cidades" name="txtid_cidade" required>
                <option value="<?php echo "$vid_cidade";?>"><?php echo "$vcidade";?></option>
                <?php
                  $sqll = "SELECT cod_cidades, nome
                      FROM cidades
                      ORDER BY nome";
                  $ress = $mysqli->query($sqll);
                  while ($row = $ress->fetch_array()){
                    echo '<option value="'.$row['cod_cidades'].'">'.utf8_encode($row['nome']).'</option>';
                  }
                ?>
                </option>
              </select>
            </div>      
          </div>            
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="regiao">REGIAO*</label>
              <select class="form-control" id="regiao" name="txtregiao" required>
                <option value="<?php echo "$vregiao";?>"><?php echo "$vregiao";?></option>
                <option value="NOROESTE">NOROESTE</option>
                <option value="OESTE">OESTE</option>
                <option value="SUDOESTE">SUDOESTE</option>
              </select>
            </div>
            <div class="col-md-6 mb-3"><br/>
                  <table class="table" >
                    <tr>
                      <td><input type="radio" name="txttipo" value="convidado" id="tconvidado" <?php echo ($vtipo == "convidado") ? "checked" : null; ?>/></td>
                      <td><label for="tconvidado">CONVIDADO</label></td>
                      <td><input type="radio" name="txttipo" value="associado" id="tassociado" <?php echo ($vtipo == "associado") ? "checked" : null; ?> /></td>
                      <td><label for="tassociado">ASSOCIADO</label></td>
                    </tr>
                  </table>
            </div>
          </div><br/>
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="ALTERAR"> 
          <input type="hidden" name="salvar" value="cadastrar">
        </form>
      </div>
    </div>  
  </body>
</html>
<?php
  if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar"){
    $razao = $_POST["txtrazao"];
    $cnpj = $_POST["txtcnpj"];
    $insc_est = $_POST["txtie"];
    $uf = $_POST["txtid_uf"];
    $cidade = $_POST["txtid_cidade"];
    $regiao = $_POST["txtregiao"];
    $tipo = $_POST["txttipo"];
    if(empty($razao) || empty($cnpj) || empty($uf) || empty($regiao) || empty($cidade) || empty($tipo)){
      echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';  
    }else{
      $sql= "UPDATE farmacia SET 
      razao_farmacia        = '$razao',
      cnpj                  = '$cnpj',
      insc_estadual         = '$insc_est',
      id_uf                 = '$uf',
      id_cidade             = '$cidade',
      regiao                = '$regiao',
      tipo                  = '$tipo'
      WHERE id_farmacia     = '$cod_farmacia'";          
      $confirma= $mysqli->query($sql);          
      echo "<script> alert('Farmácia Alterada Com Sucesso!!!') ;</script>";
      echo "<script> location.href= 'visfarmacia.php'; </script> " ;                
    }
  }                   
  $mysqli->close();   
?>
