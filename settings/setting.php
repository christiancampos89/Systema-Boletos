<?php



//Dados do servidor

//$host = "mysql.coperfinanceiro.kinghost.net";

//$login = "coperfinanceir02";

//$senha = "sede4085";

//$banco = "coperfinanceir02";

$host = "localhost";

$login = "root";

$senha = "";

$banco = "uniao";




//Efetuando conexao



$mysqli = new mysqli($host, $login, $senha, $banco);



//$conecta = mysql_connect($host, $login, $senha) or print (mysql_error());





//verificacao



if($mysqli->connect_errno){

   echo "erro ao conectar ao banco de dados: (".$mysqli->connect_errno.")".$mysqli->connect_errno;

}



?>