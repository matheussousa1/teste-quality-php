<?php
	include_once(MODEL.'clientes.php');
	
	class Inicio{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function inicio(){
			
			$this->view = "clientes/gerenciar";
			$this->nivel = 7;

			$nivelUser = $_SESSION['nivelSession'];

		}
		
	}
?>