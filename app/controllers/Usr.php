<?php 
	class Usr{
		private $config;
		private $view;
		private $model;
		private $PerMdl;

		public function __construct($config){
			$this->config = $config;
			require($this->config->get('modelsDir').'UsrMdl.php');
			$this->model = new UsrMdl($this->config);

			require($this->config->get('modelsDir').'PerMdl.php');
			$this->PerMdl = new PerMdl($this->config);

			//$_SESSION['login_time'] = time(); //Reinicia el tiempo de inactividad
			require_once($this->config->get('baseDir').'Template.php');
			$this->view = new Template();
		}

		public function mostrarLista(){
			/*echo json_encode($this->model->obtenerUsuarios());
			echo json_encode($this->model->obtenerModulos(intval(2)));*/
			$this->view->modulos = $this->model->obtenerModulos(intval(2));
			$this->view->usuarios = $this->model->obtenerUsuarios();
			$this->view->personas = $this->PerMdl->obtenerPersonas();
			$this->view->enc = 'usr.js';
			$this->view->grupos = $this->model->obtenerGrupos();
			$this->view->usr_frm = $this->view->render($this->config->get('viewsDir').'usr/frm.php');
			$this->view->per_frm = $this->view->render($this->config->get('viewsDir').'per/frm.php');
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'menu.php');
			$this->view->contenido .= $this->view->render($this->config->get('viewsDir').'usr/lista.php');
			echo $this->view->render($this->config->get('viewsDir').'header.php');
		}

		public function obtenerUsuarios(){
			return $this->model->obtenerUsuarios();
		}

		public function obtenerModulo($usuario, $modulo){
			if(intval($usuario) > 0 && intval($modulo) > 0) return $this->model->obtenerModulo(intval($usuario), intval($modulo));
			else if(intval($modulo) <= 0) return $this->model->obtenerModulos(intval($usuario));
			else return 'ERROR: /usr/{usr_id}/modulo/{0 - modulo_id}';
		}

		public function crearUsuario(){
			foreach($this->model->obtenerGrupos() as $datos) { 
				echo '<option value="'.$datos['ID_GRUPO'].'">'.$datos['NOMBRE'].'</option>';
			} 
			//return json_encode($this->model->obtenerGrupos());
			/*if($_POST['id_persona'] == '0'){
				$query = $this->PerMdl->crearPersona();
				$msg = explode(':', $query[0]['RES']);
				if($msg[0] <= 0) return json_encode($query[0]['RES']);
				else $_POST['id_persona'] = $msg[0];
			}
			return json_encode($this->model->crearUsuario());*/
		}
	}
 ?>