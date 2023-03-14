<?php
include_once("settings/setting.php");
   	@session_start();
   	$nome = $_SESSION['nome'];
   	$usuario = $_SESSION['usuario'];
   	if(!isset($_SESSION['nome']) && !isset($_SESSION['usuario']))
   	{
    	header('location: index.php');
      	exit;
    }

$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);
$qtdhoras = filter_input(INPUT_POST, 'qtdhoras', FILTER_SANITIZE_STRING);

if(!empty($title) && !empty($color) && !empty($start)){
	//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
	$data = explode(" ", $start);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$start_sem_barra = $data_sem_barra . " " . $hora;
	
	$result_events = "INSERT INTO eventos (id_evento,titulo, inicio, obs, cor, qtdhoras) VALUES (Null, '$title', '$start_sem_barra', '$obs', '$color', '$qtdhoras')";
	$confirma = $mysqli->query($result_events) or die($mysqli->error);
	$linhas = $mysqli->affected_rows;
	//Verificar se salvou no banco de dados através "mysqli_insert_id" o qual verifica se existe o ID do último dado inserido
	if($linhas > 0){
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>O Evento Cadastrado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: horaextra.php");
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao cadastrar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: horaextra.php");
	}
	
}else{
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao cadastrar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: horaextra.php");
}