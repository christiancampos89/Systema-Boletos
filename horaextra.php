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
    $sql = "SELECT * FROM eventos";
	$res = $mysqli->query($sql);
	$data = [];
	$i = 0;
	while($linha = $res->fetch_assoc())
	{
    	$data[$i]['id_evento']	= $linha['id_evento'];
    	$data[$i]['titulo']    	= $linha['titulo'];
    	$data[$i]['inicio']  	= $linha['inicio'];
    	$data[$i]['obs']       	= $linha['obs'];
    	$data[$i]['cor']        = $linha['cor'];
    	$data[$i]['qtdhoras']        = $linha['qtdhoras'];
    	$i++;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
	<style type="text/css">
		#menu ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			background-color: #333;
		}

		li {
			float: right;
		}

		li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		.titulo{
			margin-right: 190px;
			font: 600 25px Oswald;
		}

		/* Change the link color to #111 (black) on hover */
		li a:hover {
			background-color: #111;
		}
		#apresentacao{
			padding: 6px 10px;
			display: inline-block;	
		}

	</style>
	<head>
		<meta charset='utf-8' />
			<title>Eventos</title>
			<link href='css/fullcalendar.min.css' rel='stylesheet' />
			<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
			<link href='css/personalizado.css' rel='stylesheet' />
			<link href='css/bootstrap.min.css' rel='stylesheet'>
			<script src='js/moment.min.js'></script>
			<script src='js/jquery.min.js'></script>
			<script src='js/bootstrap.min.js'></script>
			<script src='js/fullcalendar.min.js'></script>
			<script src='locale/pt-br.js'></script>
		<script>
			$(document).ready(function() {
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					defaultDate: Date(),
					navLinks: true, // can click day/week names to navigate views
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					eventClick: function(event) {
						
						$('#visualizar #id').text(event.id);
						$('#visualizar #id').val(event.id);
						$('#visualizar #title').text(event.title);
						$('#visualizar #title').val(event.title);
						$('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #obs').text(event.obs);
						$('#visualizar #obs').val(event.obs);
						$('#visualizar #qtdhoras').text(event.qtdhoras);
						$('#visualizar #qtdhoras').val(event.qtdhoras);
						$('#visualizar #color').val(event.color);
						$('#visualizar').modal('show');
						return false;

					},
					
					selectable: true,
					selectHelper: true,
					select: function(start){
						$('#cadastrar #start').val(moment(start).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar').modal('show');						
					},
					events: [
						<?php foreach($data as $linha): ?>
								{
								id: '<?php echo $linha['id_evento'];  ?>',
								title: '<?php echo $linha['titulo'];  ?>',
								start: '<?php echo $linha['inicio'];  ?>',
								obs: '<?php echo $linha['obs'];  ?>',
								color: '<?php echo $linha['cor'];  ?>',
								qtdhoras: '<?php echo $linha['qtdhoras'];  ?>',
								},<?php endforeach; ?>
						
					]
				});
			});
			//Mascara para o campo data e hora
			function DataHora(evento, objeto){
				var keypress=(window.event)?event.keyCode:evento.which;
				campo = eval (objeto);
				if (campo.value == '00/00/0000 00:00:00'){
					campo.value=""
				}
			 
				caracteres = '0123456789';
				separacao1 = '/';
				separacao2 = ' ';
				separacao3 = ':';
				conjunto1 = 2;
				conjunto2 = 5;
				conjunto3 = 10;
				conjunto4 = 13;
				conjunto5 = 16;
				if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (19)){
					if (campo.value.length == conjunto1 )
					campo.value = campo.value + separacao1;
					else if (campo.value.length == conjunto2)
					campo.value = campo.value + separacao1;
					else if (campo.value.length == conjunto3)
					campo.value = campo.value + separacao2;
					else if (campo.value.length == conjunto4)
					campo.value = campo.value + separacao3;
					else if (campo.value.length == conjunto5)
					campo.value = campo.value + separacao3;
				}else{
					event.returnValue = false;
				}
			}
		</script>
		
	</head>
	<body>
		<div class="container">
			<button type="button" class="btn btn-danger" onclick="javascript:window.location.href='gerente.php'" >Sair</button>
			<div class="py-1 text-center">
				<img class="d-block mx-auto mb-4" src="imagens/logo.png" alt="" width="70" height="48">
			    <h3>BANCO DE HORAS</h3>  
			</div>
			<div id="apresentacao">
			</div>
			
			<?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			?>
		
			<div id='calendar'></div>
		</div>

		<div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">Dados do Evento</h4>
					</div>
					<div class="modal-body">
						<div class="visualizar">
							<dl class="dl-horizontal">
								<dt>ID do Evento</dt>
								<dd id="id"></dd>
								<dt>Titulo do Evento</dt>
								<dd id="title"></dd>
								<dt>Data do Evento</dt>
								<dd id="start"></dd>
								<dt>OBSERVAÇÃO</dt>
								<dd id="obs"></dd>
								<dt>QTD HORAS</dt>
								<dd id="qtdhoras"></dd>
							</dl>
							<button class="btn btn-canc-vis btn-warning">Editar</button>
						</div>
						<div class="form">
							<form class="form-horizontal" method="POST" action="proc_edit_evento.php">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Titulo</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="title" id="title" placeholder="Titulo do Evento">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Cor</label>
									<div class="col-sm-10">
										<select name="color" class="form-control" id="color">
											<option value="">Selecione</option>			
											<option style="color:#FFD700;" value="#FFD700">Amarelo</option>
											<option style="color:#0071c5;" value="#0071c5">Azul Turquesa</option>
											<option style="color:#FF4500;" value="#FF4500">Laranja</option>
											<option style="color:#8B4513;" value="#8B4513">Marrom</option>	
											<option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
											<option style="color:#436EEE;" value="#436EEE">Royal Blue</option>
											<option style="color:#A020F0;" value="#A020F0">Roxo</option>
											<option style="color:#40E0D0;" value="#40E0D0">Turquesa</option>										
											<option style="color:#228B22;" value="#228B22">Verde</option>
											<option style="color:#8B0000;" value="#8B0000">Vermelho</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Data</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">OBS</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="obs" id="obs">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">QUANTIDADE DE HORAS</label>
									<div class="col-sm-10">
										<input type="number" class="form-control" name="qtdhoras" id="qtdhoras">
									</div>
								</div>
								<input type="hidden" class="form-control" name="id" id="id">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="button" class="btn btn-canc-edit btn-primary">Cancelar</button>
										<button type="submit" class="btn btn-warning">Salvar Alterações</button>
									</div>
								</div>
							</form>
							
						
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">Cadastrar Evento</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" method="POST" action="proc_cad_evento.php">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Titulo</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="title" placeholder="Titulo do Evento">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Cor</label>
								<div class="col-sm-10">
									<select name="color" class="form-control" id="color">
										<option value="">Selecione</option>			
										<option style="color:#FFD700;" value="#FFD700">Amarelo</option>
										<option style="color:#0071c5;" value="#0071c5">Azul Turquesa</option>
										<option style="color:#FF4500;" value="#FF4500">Laranja</option>
										<option style="color:#8B4513;" value="#8B4513">Marrom</option>	
										<option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
										<option style="color:#436EEE;" value="#436EEE">Royal Blue</option>
										<option style="color:#A020F0;" value="#A020F0">Roxo</option>
										<option style="color:#40E0D0;" value="#40E0D0">Turquesa</option>										
										<option style="color:#228B22;" value="#228B22">Verde</option>
										<option style="color:#8B0000;" value="#8B0000">Vermelho</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Data</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">OBS</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="obs" id="obs">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">QUANTIDADE DE HORAS</label>
								<div class="col-sm-10">
									<input type="number" class="form-control" name="qtdhoras" id="qtdhoras">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-success">Cadastrar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			$('.btn-canc-vis').on("click", function() {
				$('.form').slideToggle();
				$('.visualizar').slideToggle();
			});
			$('.btn-canc-edit').on("click", function() {
				$('.visualizar').slideToggle();
				$('.form').slideToggle();
			});
		</script>
	</body>
</html>
