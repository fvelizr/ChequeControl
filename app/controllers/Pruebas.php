<?php
	class Pruebas{
		private $config;
		private $view;

		public function __construct($config){
			$this->config = $config;
			require_once($this->config->get('baseDir').'Template.php'); //Cargar el template para utilizar variables
			$this->view = new Template();
			$this->view->url = $config->get('baseUrl');
		}

		/**
		 * 
		 */
		public function mostrarFormularioLogin(){ 
			echo $this->view->render($this->config->get('viewsDir').'pruebasBE.php');
		}

		public function verificarDatos(){
			$data = array();
			$data['token'] = hash('sha256', 'prueba');
			$_SESSION['login_token']=$data['token'];
			$_SESSION['login_time'] = time();
			echo 'permitido';
		}

		public function formularioLogin(){
			require_once($this->config->get('modelsDir').'Test.php');
			$Test = new Test($config);
		}
	}
?>