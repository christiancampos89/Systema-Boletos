<?php
    include("settings/setting.php");

 ?>

<html>
  <header>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Senha</title>
    <link href="csss/bootstrap.css" rel="stylesheet">
    <link href="csss/signin.css" rel="stylesheet">
  </header>
  <body>
    <div class="container">
      <div class="form-signin" style="background: #189FDA;">
        <div class="py-5 text-center">
          <img class="d-block mx-auto mb-4" src="imagens/logoteste.png" alt="" width="70" height="48">
        </div>
        <h2 class="text-center" style="color: white;">Recuper Senha</h2>
        <form method="POST" action="">
          <!--<label>Usuário</label>-->
          <input type="text" name="txtusuario" placeholder="Digite o seu usuário" class="form-control" autofocus><br> 
          <!--<label>Senha</label>-->
          <input type="e-mail" name="txtemail" placeholder="Digite seu E-mail!!!" class="form-control"><br>
          <input type="submit" name="btnLogin" value="ENTRAR" class="btn btn-lg btn-primary btn-block">
          <input type="hidden" name="Enviar" value="cadastrar">
        </form>
<?php
		if(isset($_POST['Enviar']) && $_POST['Enviar'] == "cadastrar"){
    		$novasenha = substr((time()), 0, 6);
    		$usuario = $_POST['txtusuario'];
    		$email = $_POST['txtemail'];

			$message = "Sua nova senha é: $novasenha";

			$headers = 'From: exemplo@padaria.com';// <- O e-mail que está configurado no .htaccess

			$headers = 'Date:'.date('r');

				if (mail($email, 'Nova Senha', $message, $headers)) {
					$sql_code = "UPDATE usuarios SET senha = '$novasenha' WHERE usuario = '$usuario'";
    				$res = $mysqli->query($sql_code);

					echo '<script> alert("Senha Enviada para o E-MAIL!!!"); </script>';

				}else{

					echo "<script> alert('E-MAIL OU USUÁRIO INVÁLIDO!!';)</script>";	

				};
				
		}
?>