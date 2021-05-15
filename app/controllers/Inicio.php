<?php 
	class Inicio{
		private $config;
		private $view;

		public function __construct($config){
			$this->config = $config;

			$_SESSION['login_time'] = time(); //Reinicia el tiempo de inactividad
			require_once($this->config->get('baseDir').'Template.php');
			$this->view = new Template();
		}

		public function indexAction(){
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'menu.php');
			echo $this->view->render($this->config->get('viewsDir').'header.php');
		}
	}
 ?>