<?php
   include_once("settings/setting.php");
   @session_start();
   
?>

<!doctype html>
<html lang="pt-br">
<header>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>Rodada de Negócios</title>
<!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/signin.css" rel="stylesheet">
</header>
<body>
   <div id="frmlogin" class="bradius">
    <div class="container">
      <div class="py-5 text-center">
       <img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
       <h2>RODADA DE NEGÓCIOS 2019</h2>
      </div>
      <form method="post">
        <label for="inputusuario" class="sr-only">Usuário</label>
        <input type="text" id="inputusuario" name = "txtusuario" class="form-control" placeholder="Usuário" required autofocus>
        <label for="inputsenha" class="sr-only">Senha</label>
        <input type="password" id="inputsenha" name="txtsenha" class="form-control" placeholder="Senha" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Lembrar
          </label>
        </div>
        <input class="btn btn-lg btn-primary btn-block" value="ENTRAR" type="submit">
        <input type="hidden" name="entrar" value="login"><br/>
        <button type="button" class="btn btn-success" onclick="javascript:window.location.href='esquecisenha.php'" >RECUPERAR SENHA</button>
      </form>

    </div> <!-- /container -->
</div>
       
</body>

</html>
<?php
	        if(isset($_POST['entrar']) && $_POST['entrar'] == "login"){
		       $usuario = $_POST['txtusuario'];
		       $senha = $_POST['txtsenha'];

		       if(empty($usuario) || empty($senha)){
				    echo"<script> alert('Preencha todos os campos!');</script>";
			   }else{
				    $query = "SELECT nome, usuario, senha, permissao FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
				    $result = $mysqli->query($query);
				    $busca = mysqli_num_rows($result);
				    $linha = mysqli_fetch_assoc($result);

				 
				    if($busca > 0){
					    $_SESSION['nome'] = $linha['nome'];
					    $_SESSION['usuario'] = $linha['usuario'];
						if ($linha['permissao'] == 2){
							header('location: lancamento.php');
						}elseif($linha['permissao'] == 1){
							header('location: gerarcompra.php');
						}else{
							header('location: gerente.php');
						}
					    exit;
				
				    }else{
					    echo "<script> alert('USUÁRIO OU SENHA INVÁLIDOS') ;</script>";
				    }
			    }		 
		  			 
			 
		    }
	        ?>