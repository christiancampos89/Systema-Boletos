<?php
    include_once("settings/setting.php");
    @session_start();

    $nome = $_SESSION['nome'];
    $usuario = $_SESSION['usuario'];

    if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
        header('location: index.php');
        exit;
    }
      
   $vrazao = isset($_POST["txtrazao"]) ? $_POST["txtrazao"] : '';
   $vcnpj = isset($_POST["txtcnpj"]) ? $_POST["txtcnpj"] : '';
   $vie = isset($_POST["txtie"]) ? $_POST["txtie"] : '';
   $vuf = isset($_POST["txtuf"]) ? $_POST["txtuf"] : '';
   $vcidade = isset($_POST["txtcidade"]) ? $_POST["txtcidade"] : '';
   $vendereco = isset($_POST["txtendereco"]) ? $_POST["txtendereco"] : '';
   $vnumero = isset($_POST["txtnumero"]) ? $_POST["txtnumero"] : '';
   $vbairro = isset($_POST["txtbairro"]) ? $_POST["txtbairro"] : '';
   $vcep = isset($_POST["txtcep"]) ? $_POST["txtcep"] : '';
   $vddd = isset($_POST["txtddd"]) ? $_POST["txtddd"] : '';
   $vtelefone = isset($_POST["txttelefone"]) ? $_POST["txttelefone"] : '';
   $vcontato = isset($_POST["txtcontato"]) ? $_POST["txtcontato"] : '';
   $vemail = isset($_POST["txtemail"]) ? $_POST["txtemail"] : '';
   $vregiao = isset($_POST["txtregiao"]) ? $_POST["txtregiao"] : '';

   

   ?>
<html>
  <header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Voltar</button>
    <title>Cadastro Farmácia</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="js/jquery.mask.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function(){
        $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
      }); 
      //$('.txtcompra').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    </script>
  </header>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
        <h2>Cadastro de Farmácia</h2>  
      </div>
      <div class="col-md-10   order-md-1">
        <form class="needs-validation" method="post" novalidate>
          <div class="row">
            <div class="col-md-5 mb-3">
              <label for="razaosocial">RAZAO SOCIAL*</label>
              <input type="text" class="form-control" id="razaosocial" placeholder="" name="txtrazao" value="" autofocus required>
            </div>
            <div class="col-md-4   mb-3">
              <label for="cnpj">CNPJ*</label>
              <input type="text" class="form-control" id="cnpj" placeholder="" name="txtcnpj" value="" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="inscestadual">INSC. ESTADUAL</label>
              <input type="text" class="form-control" id="inscestadual" placeholder="" name="txtie" value="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 mb-3">
              <label for="uf">UF*</label>
              <select class="form-control" id="uf" name="txtid_uf" required>
                <option value="">SELECIONE...</option>
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
                <option value="">SELECIONE...</option>
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
            <div class="col-md-5 mb-3">
              <label for="regiao">REGIAO*</label>
              <select class="form-control" id="regiao" name="txtregiao" required>
                <option value="">SELECIONE...</option>
                <option value="NOROESTE">NOROESTE</option>
                <option value="OESTE">OESTE</option>
                <option value="SUDOESTE">SUDOESTE</option>
              </select>
            </div>
            <div class="col-md-6 mb-3"><br/>
                  <table class="table" >
                    <tr>
                      <td><input type="radio" name="txttipo" value="convidado" id="tconvidado" /></td>
                      <td><label for="tconvidado">CONVIDADO</label></td>
                      <td><input type="radio" name="txttipo" value="associado" id="tassociado" /></td>
                      <td><label for="tassociado">ASSOCIADO</label></td>
                    </tr>
                  </table>
            </div>
          </div><br/>
          <input class="btn btn-primary btn-lg btn-block" type="submit" value="SALVAR"> 
          <input type="hidden" name="salvar" value="cadastrar">
        </form>
      </div>
    </div>  
  </body>
</html>
<?php

  if(isset($_POST['salvar']) && $_POST['salvar'] == "cadastrar")
  {
               $vrazao = $_POST["txtrazao"];
               $vcnpj = $_POST["txtcnpj"];
               $vinsc_est = $_POST["txtie"];
               $vuf = $_POST["txtid_uf"];
               $vcidade = $_POST["txtid_cidade"];
               //$vendereco = $_POST["txtendereco"];
               //$vnumero = $_POST["txtnumero"];
               //$vbairro = $_POST["txtbairro"];
               //$vcep = $_POST["txtcep"];
               //$vddd = $_POST["txtddd"];
               //$vtelefone = $_POST["txttelefone"];
               //$vcontato = $_POST["txtcontato"];
               //$vemail = $_POST["txtemail"];
               $vregiao = $_POST["txtregiao"];
               $vtipo = $_POST['txttipo'];
               

            if(empty($vrazao) || empty($vcnpj) || empty($vuf) || empty($vregiao) || empty($vcidade) || empty($vtipo)){
                echo '<script> alert("Preencha todos os campos!!!"); history.back();</script>';

            }else{
                $squery1 = ("SELECT * FROM farmacia WHERE cnpj = '$vcnpj'");
                $res = $mysqli->query($squery1);
                $total = mysqli_num_rows($res);
                if($total == 1){
                  echo '<script> alert("CNPJ já cadastrado!!!"); history.back();</script>';                  
                }else{
                  $sql= "INSERT INTO farmacia VALUES (NULL, '$vrazao', '$vcnpj', '$vinsc_est', '$vuf', '$vcidade', '$vregiao', '$vtipo' )";
                  $confirma= $mysqli->query($sql);
                  echo '<script> alert("Farmácia Gravada Com Sucesso!!!");</script>';
                  echo "<script> location.href= 'visfarmacia.php'; </script> " ;                
                }
            }     
  } 
             $mysqli->close();   
?>