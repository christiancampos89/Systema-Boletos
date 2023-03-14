<?php
   include_once("settings/setting.php");
   @session_start();
   


   $nome = $_SESSION['nome'];
   $usuario = $_SESSION['usuario'];

   if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario'])){
      header('location: index.php');
      exit;

   }

?>

<style type="text/css">

#gerall{
   background-image: url("imagens/fundosistema.jpg");
   width: 100%;
   height: 100%;
   margin: 0;
}

.menu-icon{
   position: fixed;
   font-size: 25px;
   font-weight: bold;
   width: 95px;
   height: 30px;
   text-align: center;
   background-color: #189FDA;
   color: #fff;
   cursor: pointer;
   transition: all .4s;
   left: 18px;
   top: 35px;
   margin-top: 10px;
}

.menu-icon:hover{
   background-color: #201E1E;
   color: #FF0000;
}
#chk{
   display: none;
}
.menu{
   height: 100%;
   position: fixed;
   background-color: #222;
   overflow: hidden;
   transition: all.2s;
}

#principal{
   width: 300px;
   left: -300px;
}

#farmacia{
   width: 250px;
   left: -250px;


}
#usuario{
   width: 250px;
   left: -250px;


}
#contatos{
   width: 250px;
   left: -250px;


}
#fornecedor{
   width: 250px;
   left: -250px;


}
#relatorio{
   width: 250px;
   left: -250px;
}

#boleto{
   width: 250px;
   left: -250px;
}

#msglogin1{
   margin-top: 105px;

}

.msg{
   padding-top: 20px;
}

ul{
   list-style: none;
}
ul li a{
   display: block;
   font-size: 18px;
   font-family: 'arial';
   padding: 10px;
   border-bottom: solid 1px #000;
   color: #ccc;
   text-decoration: none;
   transition: all .2s;
}
ul li span{
   float: right;
   padding-right: 10px;
   color: #fff;
}
ul li a:hover{
   background-color: #5b859a;
}
.voltar{
   margin-top: 60px;
   background-color: #111;
   border-left: solid 5px #444;
}

.bg{
   width: 100%;
   height: 100%;
   left: 0;
   top: 0;
   position: fixed;
   background-color: rgba(0,0,0,.6);
   display: none;
}

#chk:checked ~.bg{
   display: block;
}

#chk:checked ~ #principal{
   transform: translateX(300px);
}

#cad.farmacia,
#cad.usuario,
#cad.contatos,
#relatorio,
#cad.boleto,
#cad.fornecedor{
   width: 250px;
   left: -250px;
}

#farmacia:target,
#usuario:target,
#contatos:target,
#relatorio:target,
#boleto:target,
#fornecedor:target{
   transform: translateX(250px);
   box-shadow: 2px 2px 5px 2px rgba(0,0,0,.5);
}
#conteudo{
}

.lblmesg{
   font: 600 18px Oswald;
   color: #201E1E;

}

.sbsair{
   border: none;
   width: 90px;
   height: 30px;
   margin-top: 5px;
   cursor: pointer;
   font: 600 30px Oswald;
   color:#fff;
   float: right;
   background-color: #189FDA;
}

.sbsair:hover{
   background: #C03;
   color:#fff;
}

</style>

<!doctype html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="icon" href="">
    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='sair.php'" >Sair</button>
    <title>Sistema Interno</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">  
</head>
<body>
<div id="gerall">
   <input type="checkbox" id="chk">
   <label for="chk" class="menu-icon">&#9776;MENU</label>
   <div class="bg"></div>

   <nav class="menu" id="principal">
      <ul type="disc">
         <li><a href="" class="voltar">VOLTAR</a></li>
         <li><a href="#">HOME</a></li>
         <li><a href="#contatos">CONTATOS <span>+</span></a></li>
         <li><a href="#fornecedor">FORNECEDOR<span>+</span></a></li>
         <li><a href="#relatorio">RELAT&Oacute;RIO GERAL<span>+</span></a></li>
         <li><a href="#boleto">BOLETOS<span>+</span></a></li>
         <li><a href="#usuario">USU&Aacute;RIO <span>+</span></a></li>
         <li><a href="horaextra.php">BANCO DE HORAS FUNC<span>+</span></a></li>
         
         
      </ul>

   </nav>
   <nav class="menu" id="farmacia">
      <ul>
         <li><center><a href="" class="">FARM&Aacute;CIAS</a></center></li> 
         <li><a href="#" class="voltar">VOLTAR</a></li>
         <li><a href="cadfarmacia.php">CADASTRAR</a></li>
         <li><a href="visfarmacia.php">ALTERAR / EXCLUIR</a></li>
      </ul>
   </nav>

   <nav class="menu" id="usuario">
      <ul>
         <li><center><a href="" class="">USU&Aacute;RIOS</a></center></li>
         <li><a href="#" class="voltar">VOLTAR</a></li>
         <li><a href="cadusuario.php">CADASTRAR</a></li>
         <li><a href="visusuario.php">ALTERAR / EXCLUIR</a></li>
      </ul>
   </nav>

   <nav class="menu" id="contatos">
      <ul>
         <li><center><a href="" class="">CONTATOSS</a></center></li>
         <li><a href="#" class="voltar">VOLTAR</a></li>
         <li><a href="cadcontato.php">CADASTRAR</a></li>
         <li><a href="viscontato.php">ALTERAR / EXCLUIR</a></li>
      </ul>
   </nav> 

   <nav class="menu" id="fornecedor">
      <ul>
         <li><center><a href="" class="">FORNECEDORES</a></center></li>
         <li><a href="#" class="voltar">VOLTAR</a></li>
         <li><a href="cadfornecedor.php">CADASTRAR</a></li>
         <li><a href="visfornecedor.php">ALTERAR / EXCLUIR</a></li>
      </ul>
   </nav>
   
   <nav class="menu" id="relatorio">
      <ul>
         <li><center><a href="" class="">RELAT&Oacute;RIOS</a></center></li> 
         <li><a href="#" class="voltar">VOLTAR</a></li>
         <li><a href="relatorio.php">REL. ASSOC/CONV</a></li>
         <li><a href="relatoriofornecedor.php">REL. GERAL</a></li>
      </ul>
   </nav>

   <nav class="menu" id="boleto">
      <ul>
         <li><center><a href="" class="">BOLETOS</a></center></li> 
         <li><a href="#" class="voltar">VOLTAR</a></li>
         <li><a href="lancamento.php">CADASTRAR</a></li>
         <li><a href="envpagamento.php">ENV. P/ PAGAMENTO</a></li>
         <li><a href="baixarboletos.php">BAIXAR BOLETO</a></li>
         <li><a href="relatorio_titulos.php">RELAT&Oacute;RIO BOLETOS</a></li>
         <li><a href="vislancamento.php">ALTERAR / EXCLUIR</a></li>
      </ul>
   </nav>
</div>
</body>
</html>