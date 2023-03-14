<?php
	class Sql extends PDO{
		private $conn;

		public function __construct(){
			$this->conn = new PDO("mysql:host=mysql.coperfarma.com.br;dbname=coperfarma02", "coperfarma02", "sede4085");

		}
		
		private function setParams($statment, $parameters = array()){
			foreach ($parameters as $key => $value){
				$this->setParam($statment, $key, $value);

			}
		}

		private function setParam($statment, $key, $value){
			$statment->bindParam($key, $value);
		
		}

		public function query($rawQuery, $params = array()){
			
			$stmt = $this->conn->prepare($rawQuery);

			$this->setParams($stmt, $params);

			$stmt->execute();

			return $stmt;
		
		}

		public function select($rawQuery, $params = array())
		{
			$stmt = $this->query($rawQuery, $params);

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		public function Login($usuario, $senha){

			$sql = new Sql();

			$result = $sql->select("SELECT * FROM usuarios WHERE usuario = :USUARIO AND senha = :SENHA", array(
				":USUARIO"=>$usuario,
				":SENHA"=>$senha
			));

			if(count($result) > 0){
				$row = $result[0];

				$_SESSION['usuario'] = $row['usuario'];
				$_SESSION['senha'] = $row['senha'];
				$_SESSION['nome'] = $row['nome'];
				header('location: Principal.php');

			}else{
				echo"<script> alert('Usuario ou senha Invalido!');</script>";
			}
		}



	}




?>