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

/* GERAL */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Helvetica, sans-serif;
    color: #323232;
    border: none;
}

input, label{
    display: block;
    width: 100%;
}

input:focus, label:focus{
    outline: none;
}

body {
    padding-top: 5vh; /*view height = 5% da tela*/
    background-image: url('imagens/tecnologia.jpg');
    background-size: cover;
    /*background-position-y: -160px;*/ 
}

.menu-icon{
   position: fixed;
   font-size: 45px;
   font-weight: bold;
   width: 171px;
   height: 58px;
   text-align: center;
   background-color: #FFFF00;
   color: #000000;
   cursor: pointer;
   transition: all .4s;
   left: 41px;
   top: 48px;
   margin-top: 65px;
}

.menu-icon:hover{
   background-color: #000000;
   color: #ffffff;
}
#chk{
   display: none;
}
.menu{
   height: 70%;
   position: fixed;
   background-color: #222;
   overflow: hidden;
   transition: all.2s;
}

#principal{
   width: 300px;
   left: -300px;
}

#horaextra{
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

#categoria{
   width: 250px;
   left: -250px;
}

#subcategoria{
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

#horaextra:target,
#usuario:target,
#contatos:target,
#relatorio:target,
#boleto:target,
#categoria:target,
#subcategoria:target,
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

.sbsair:hover{
   background: #C03;
   color:#fff;
}

.btnsair{
   float: right;
   margin-right: 15px;

}

</style>

<!doctype html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="icon" href="">
    <title>Sistema Interno</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/bootstrap/css/form-validation.css" rel="stylesheet">  
</head>
<body>
   <div id="main-container">
      <div class="btnsair">
         <button type="button" style="width: 120px; height: 60px; font:600 32px Oswald" class="btn btn-danger" onclick="javascript:window.location.href='sair.php'" >Sair</button>
      </div>
      <input type="checkbox" id="chk">
      <label for="chk" class="menu-icon">&#9776;MENU</label>
      <nav class="menu" id="principal">
         <ul type="disc">
            <li><a href="" class="voltar">VOLTAR</a></li>
            <li><a href="#">HOME</a></li>
            <li><a href="#contatos">CONTATOS <span>+</span></a></li>
            <li><a href="#fornecedor">FORNECEDOR<span>+</span></a></li>
            <li><a href="#categoria">CATEGORIA<span>+</span></a></li>
            <li><a href="#subcategoria">SUB-CATEGORIA<span>+</span></a></li>
            <li><a href="#relatorio">RELATÓRIOS<span>+</span></a></li>
            <li><a href="#boleto">BOLETOS<span>+</span></a></li>
            <li><a href="#usuario">USUÁRIOS <span>+</span></a></li>
            <li><a href="#horaextra">BANCO DE HORAS<span>+</span></a></li>
            
            
         </ul>

      </nav>
      <nav class="menu" id="horaextra">
         <ul>
            <li><center><a href="" class="">BANCO DE HORAS</a></center></li> 
            <li><a href="#" class="voltar">VOLTAR</a></li>
            <li><a href="horaextra.php">REGISTRAR EVENTO</a></li>
            <li><a href="vishoraextra.php">ALTERAR / EXCLUIR</a></li>
         </ul>
      </nav>

      <nav class="menu" id="usuario">
         <ul>
            <li><center><a href="" class="">USUÁRIOS</a></center></li>
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

      <nav class="menu" id="categoria">
         <ul>
            <li><center><a href="" class="">CATEGORIAS</a></center></li>
            <li><a href="#" class="voltar">VOLTAR</a></li>
            <li><a href="cadcategoria.php">CADASTRAR</a></li>
            <li><a href="viscategoria.php">ALTERAR / EXCLUIR</a></li>
         </ul>
      </nav>

      <nav class="menu" id="subcategoria">
         <ul>
            <li><center><a href="" class="">SUB-CATEGORIAS</a></center></li>
            <li><a href="#" class="voltar">VOLTAR</a></li>
            <li><a href="cadsubcategoria.php">CADASTRAR</a></li>
            <li><a href="vissubcategoria.php">ALTERAR / EXCLUIR</a></li>
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
            <li><center><a href="" class="">RELATÓRIOS</a></center></li> 
            <li><a href="#" class="voltar">VOLTAR</a></li>
            <li><a href="relatorio_titulos2.php">RELATÓRIO DE LANÇAMENTOS</a></li>
            <li><a href="relatorio_titulos3.php">RELATÓRIO DE VENCIMENTOS</a></li>
         </ul>
      </nav>

      <nav class="menu" id="boleto">
         <ul>
            <li><center><a href="" class="">BOLETOS</a></center></li> 
            <li><a href="#" class="voltar">VOLTAR</a></li>
            <li><a href="lancamento.php">CADASTRAR</a></li>
            <li><a href="envpagamento.php">ENV. P/ PAGAMENTO</a></li>
            <li><a href="baixarboletos.php">BAIXAR BOLETO</a></li>
            <li><a href="relatorio_titulos.php">RELATÓRIO BOLETOS</a></li>
            <li><a href="vislancamento.php">ALTERAR / EXCLUIR</a></li>
         </ul>
      </nav>
   </div>
</body>
</html>