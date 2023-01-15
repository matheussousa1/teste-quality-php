<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class ClientesModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($nome, $cpf, $cep, $logradouro, $numero, $bairro, $cidade, $estado, $codigo, $complemento, $contato, $limiteCredito, $validade){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `clientes`(`DataHoraCadastro`, `Codigo`, `Nome`, `CPF_CNPJ`, `CEP`, `Logradouro`, `Numero`, `Bairro`, `Cidade`, `UF`, `Complemento`, `Fone`, `LimiteCredito`, `Validade`) VALUES (NOW(), '$codigo', '$nome', '$cpf','$cep','$logradouro','$numero','$bairro','$cidade','$estado','$complemento','$contato','$limiteCredito','$validade')") or die(mysqli_error($this->con));

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM clientes ");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM clientes WHERE idUsuario = $id");

			return $this->retorno;

		}	

		public function editar($id, $nome, $cpf, $cep, $logradouro, $numero, $bairro, $cidade, $estado, $codigo, $complemento, $contato, $limiteCredito, $validade){

			$this->retorno = mysqli_query($this->con, "UPDATE `clientes` SET `Codigo`= '$codigo',`Nome`= '$nome',`CPF_CNPJ`= '$cpf',`CEP`= '$cep',`Logradouro`= '$logradouro',`Numero`= '$numero',`Bairro`= '$bairro',`Cidade`= '$cidade',`UF`= '$estado',`Complemento`= '$complemento',`Fone`= '$contato',`LimiteCredito`= '$limiteCredito',`Validade`= '$validade' WHERE idUsuario = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "DELETE FROM `clientes` WHERE idUsuario = $id");

			return $this->retorno;

		}


		
	}

?>