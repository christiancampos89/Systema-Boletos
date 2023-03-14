<?php

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['despesamodel'])){
	$retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: É necessário selecionar um tipo de despesa!</div>"];
}elseif (empty($dados['obs'])){
	$retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: É necessário preencher o campo OBS!!!</div>"];
}elseif (empty($dados['valormodel'])){
	$retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: É necessário preencher o campo VALOR!!!</div>"];
}else{
	$retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Validar!</div>"];
}

echo json_encode($retorna);