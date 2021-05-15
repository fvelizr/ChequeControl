<?php 
	class Usuarios{
		private $config;
		private $view;

		public function __construct($config){
			$this->config = $config;

			$this->view->url = $config->get('baseUrl');

			$_SESSION['login_time'] = time(); //Reinicia el tiempo de inactividad
			require_once($this->config->get('baseDir').'Template.php');
			$this->view = new Template();
		}

		public function listaUsuarios(){
			require($this->config->get('modelsDir').'UsuariosMdl.php');
			$UsuarioMdl = new UsuariosMdl($this->config);
			//$this->view->usuarios =
			$this->view->usuarios = $UsuarioMdl->obtenerUsuarios();
			$this->view->grupos = $UsuarioMdl->obtenerGrupos();
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'menu.php');
			$this->view->contenido .= $this->view->render($this->config->get('viewsDir').'usuario.php');
			echo $this->view->render($this->config->get('viewsDir').'header.php');
		}

		public function obtenerUsuario($id){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            if(isset($id)){
				require($this->config->get('modelsDir').'UsuariosMdl.php');
				$UsuarioMdl = new UsuariosMdl($this->config);
				$usuario = $UsuarioMdl->obtenerUsuario($id);
				if(!is_null($usuario) && !empty($usuario)){
					$res['codigo'] = '200';
                	$res['mensaje'] = 'Usuario cargado correctamente. ID USUARIO:'.$id;
					$res['objeto'] = array($usuario);
				}else{
					$res['codigo'] = '404';
                	$res['mensaje'] = 'ERROR: No se encontro el usuario. ID USUARIO:'.$id;
				}
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: El id del usuario usuario no se recibio. <br>Por favor contacte al administrador.';
                //session_destroy();
            }
            return json_encode($res);
		}

		public function obtenerGrupos(){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            if(isset($id)){
				require($this->config->get('modelsDir').'UsuariosMdl.php');
				$UsuarioMdl = new UsuariosMdl($this->config);
				$usuario = $UsuarioMdl->obtenerUsuario($id);
				if(!is_null($usuario) && !empty($usuario)){
					$res['codigo'] = '200';
                	$res['mensaje'] = 'Usuario cargado correctamente. ID USUARIO:'.$id;
					$res['objeto'] = array($usuario);
				}else{
					$res['codigo'] = '404';
                	$res['mensaje'] = 'ERROR: No se encontro el usuario. ID USUARIO:'.$id;
				}
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: El id del usuario usuario no se recibio. <br>Por favor contacte al administrador.';
                //session_destroy();
            }
            return json_encode($res);
		}

		public function crearUsuario(){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            /*if(
				(!isset($_POST['$cui']) && !empty($_POST['$cui'])) &&
				(!isset($_POST['$grupo']) && !empty($_POST['$grupo'])) &&
				(!isset($_POST['$usuario']) && !empty($_POST['$usuario'])) &&
				(!isset($_POST['$contra']) && !empty($_POST['$contra'])) &&
				(!isset($_POST['$monto']) && !empty($_POST['$monto'])) &&
				(!isset($_POST['$nombre1']) && !empty($_POST['$nombre1'])) &&
				(!isset($_POST['$nombre2']) && !empty($_POST['$nombre2'])) &&
				(!!isset($_POST['$nombre3']) && !empty($_POST['$nombre3'])) &&
				(!isset($_POST['$apellido1']) && !empty($_POST['$apellido1'])) &&
				(!isset($_POST['$apellido2']) && !empty($_POST['$apellido2'])) &&
				(!isset($_POST['$fecha_nac']) && !empty($_POST['$fecha_nac']))
			){*/
				//($nombre, $contra, $cui, $nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $fechanac, $grupo, $monto){
				require($this->config->get('modelsDir').'UsuariosMdl.php');
				$UsuarioMdl = new UsuariosMdl($this->config);
				$usuario = $UsuarioMdl->crearUsuarios(
					$_POST['usuario'], $_POST['contra'], $_POST['cui'], $_POST['nombre1'], $_POST['nombre2'], $_POST['nombre3'], $_POST['apellido1'], $_POST['apellido2'], $_POST['fecha_nac'], $_POST['grupo'], $_POST['monto']
				);
				if(!is_null($usuario) && !empty($usuario)){
					//$res['codigo'] = '200';
                	//$res['mensaje'] = 'Usuario cargado correctamente. ID USUARIO:'.$usuario;
				}else{
					//$res['codigo'] = '404';
                	//$res['mensaje'] = 'ERROR: No se creo el usuario. DATOS:';
				}
            //}else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: Los datos del formulario de registro, no se recibieron correctamente. <br>Por favor contacte al administrador.';
                //session_destroy();
            //}
            return json_encode($usuario);
		}
	}
 ?>