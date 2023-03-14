<?php

class Farmacia {
	private $idfarmacia;
	private $razaosocial;
	private $cnpj;
	private $insc_estadual;
	private $uf;
	private $cidade;
	private $endereco;
	private $bairro;
	private $cep;
	private $ddd;
	private $telefone;
	private $contato;
	private $email;
	private $regiao;

	public function getIdfarmacia(){
		return $this->idfarmacia;
	}

	public function getRazaosocial(){
		return $this->razaosocial;
	}

	public function getCnpj(){
		return $this->cnpj;
	}

	public function getInsc_estadual(){
		return $this->insc_estadual;
	}

	public function getUf(){
		return $this->uf;
	}

	public function getCidade(){
		return $this->cidade;
	}

	public function getEndereco(){
		return $this->endereco;

	public function getBairro(){
		return $this->bairro;
	}

	public function getCep(){
		return $this->cep;
	}

	public function getDdd(){
		return $this->ddd;
	}

	public function getTelefone(){
		return $this->telefone;
	}

	public function getContato(){
		return $this->contato;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getRegiao(){
		return $this->regiao;
	}

	
}


?>