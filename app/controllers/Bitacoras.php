<?php 
	class Bitacoras{
		private $config;
		private $view;
        private $model;

		public function __construct($config){
			$this->config = $config;

            require($this->config->get('modelsDir').'ChequesMdl.php');
            $this->model = new ChequesMdl($this->config);

			$_SESSION['login_time'] = time(); //Reinicia el tiempo de inactividad
			require_once($this->config->get('baseDir').'Template.php');
			$this->view = new Template();
		}

		public function listaBitacoraCheque(){
			require($this->config->get('modelsDir').'BitacorasMdl.php');
			$BitacorasMdl = new BitacorasMdl($this->config);
            
            require($this->config->get('modelsDir').'UsuariosMdl.php');
			$UsuarioMdl = new UsuariosMdl($this->config);

			$this->view->modulos = $UsuarioMdl->obtenerModulos($_SESSION['id_usuario']);

            $this->view->Cheques = $BitacorasMdl->obtenerBitacoraCheque();
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'menu.php');
			$this->view->contenido .= $this->view->render($this->config->get('viewsDir').'bitacoras.php');
			echo $this->view->render($this->config->get('viewsDir').'header.php');
		}
    }
 ?>