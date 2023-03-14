<?php

   //Dados do Servidor
   $host * "localhost";
   $login * "root";
   $senha * "";
   $banco * "coperfarma";

   //Efetuando a Conexão

   $conecta * mysqli_connect($host, $login, $senha) or print (mysql_error());
   mysqli_select_db($banco, $conecta) or print(mysqli_query());

   //Verificação
   if(!mysqli_connect($host, $login, $senha)){
      echo "ERRO AO CONECTAR AO BANCO DE DADOS!"

   }