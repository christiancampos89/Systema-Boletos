<?php
	include_once("settings/setting.php");
   	@session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Controle ADM - Login</title>
		<link href="csss/bootstrap.css" rel="stylesheet">
		<link href="csss/signin.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="form-signin" style="background: #189FDA;">
				<div class="py-5 text-center">
       				<img class="d-block mx-auto mb-4" src="imagens/logoteste.png" alt="" width="70" height="48">
      			</div>
				<h2 class="text-center" style="color: white;">CONTROLE ADM</h2>
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
				<form method="POST" action="">
					<!--<label>Usuário</label>-->
					<input type="text" name="txtusuario" placeholder="Digite o seu usuário" class="form-control" autofocus><br>
					
					<!--<label>Senha</label>-->
					<input type="password" name="txtsenha" placeholder="Digite a sua senha" class="form-control"><br>
					
					<input type="submit" name="btnLogin" value="ENTRAR" class="btn btn-lg btn-primary btn-block">
					<input type="hidden" name="entrar" value="login"><br/>

					<button type="button" class="btn btn-success" onclick="javascript:window.location.href='esquecisenha.php'" >RECUPERAR SENHA</button>
					
				</form>
			</div>
		</div>			
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
<?php
	if(isset($_POST['entrar']) && $_POST['entrar'] == "login"){
		$usuario = $_POST['txtusuario'];
		$senha = $_POST['txtsenha'];
		$usuario_correto = preg_replace('/[^[:alpha:]_]/', '',$usuario);
		$senha_correta = preg_replace('/[^[:alnum:]_]/', '',$senha);
		if(empty($usuario) || empty($senha)){
			echo"<script> alert('Preencha todos os campos!');</script>";
		}else{
			$query = "SELECT nome, usuario, senha, permissao FROM usuarios WHERE usuario = '$usuario_correto' AND senha = '$senha_correta'";
			$result = $mysqli->query($query);
			$busca = mysqli_num_rows($result);
			$linha = mysqli_fetch_assoc($result);			 
			if($busca > 0){
				$_SESSION['nome'] = $linha['nome'];
				$_SESSION['usuario'] = $linha['usuario'];
				$_SESSION['filial'] = 'UNIÃO FARMA';
				if ($linha['permissao'] == 2){
					header('location: lancamento.php');
				}elseif($linha['permissao'] == 1){
					header('location: gerarcompra.php');
				}else{
					header('location: gerente.php');
				}
			}else{
				echo "<script> alert('USUÁRIO OU SENHA INVÁLIDOS'); history.back();</script>";
			}
		}		 	  			 
	}
?>