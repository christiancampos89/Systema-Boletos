<?php

$message = "Sua nova senha �:";

$headers = 'From: exemplo@padaria.com';// <- O e-mail que est� configurado no .htaccess

$headers = 'Date:'.date('r');

if (mail('christian@coperfarma.com.br', 'Teste', $message, $headers)) {

print('Funcionou');

}else{

print('Nao Funcionou�');

};

?>