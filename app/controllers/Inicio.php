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
			require($this->config->get('modelsDir').'UsuariosMdl.php');
			$UsuarioMdl = new UsuariosMdl($this->config);
			$this->view->modulos = $UsuarioMdl->obtenerModulos($_SESSION['id_usuario']);
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'menu.php');
			$this->view->contenido .= $this->view->render($this->config->get('viewsDir').'inicio.php');
			echo $this->view->render($this->config->get('viewsDir').'header.php');
		}
	}
 ?>