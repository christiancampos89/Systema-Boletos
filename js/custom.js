const loginForm = document.getElementById("caddespesa-form");
const msgAlertError = document.getElementById("msgAlertError");

loginForm.addEventListener("submit", async (e) => {
	e.preventDefault();

	/*if (document.getElementById("txttpdespesamodel").value === "nada"){
		msgAlertError.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: É necessário selecionar um tipo de despesa!</div>";
		
	}else if (document.getElementById("txtobsmodel").value == ""){
		msgAlertError.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: É necessário preencher o campo OBS!!!</div>";
		
	}else if (document.getElementById("valormodel").value == ""){

		msgAlertError.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: É necessário preencher o campo VALOR!!!</div>";
	}else{
		msgAlertError.innerHTML = "<div class='alert alert-success' role='alert'>VALIDOU!!!</div>";
		//const dadosForm = new FormData(loginForm);

		//const dados = await fetch("validar.php", {
		//	method: "POST",
		//	body: dadosForm
		//});
	}*/
	validar(loginForm);
});

function validar() {
  // pegando o valor do nome pelos names
  var despesa = document.getElementById("txttpdespesamodel");
  var obs = document.getElementById("txtobsmodel");
  var valor = document.getElementById("valormodel");

  // verificar se a Despesa está vazio
  if (despesa.value == "nada") {
    alert("Despesa Vazia ");

    // Deixa o input com o focus
    despesa.focus();
    // retorna a função e não olha as outras linhas
    return;
  }
