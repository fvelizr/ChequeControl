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
			$this->view->info = "hola";
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
            
			if(isset($_POST['cui']) &&
				isset($_POST['grupo']) && 
				isset($_POST['usuario']) && 
				isset($_POST['contra']) && 
				isset($_POST['monto']) && 
				isset($_POST['nombre1']) && 
				isset($_POST['nombre2']) && 
				isset($_POST['nombre3']) && 
				isset($_POST['apellido1']) && 
				isset($_POST['apellido2']) && 
				isset($_POST['fecha_nac'])
			){
				if(
					!empty($_POST['cui']) &&
					!empty($_POST['grupo']) &&
					!empty($_POST['usuario']) &&
					!empty($_POST['contra']) && 
					!empty($_POST['monto']) &&
					!empty($_POST['nombre1']) && 
					!empty($_POST['apellido1']) &&
					!empty($_POST['fecha_nac'])
				){
					require($this->config->get('modelsDir').'UsuariosMdl.php');
					$UsuarioMdl = new UsuariosMdl($this->config);
					$usuario = $UsuarioMdl->crearUsuarios(
						$_POST['usuario'], hash('sha256', $_POST['contra']), $_POST['cui'], $_POST['nombre1'], $_POST['nombre2'], $_POST['nombre3'], $_POST['apellido1'], $_POST['apellido2'], $_POST['fecha_nac'], $_POST['grupo'], $_POST['monto']
					);
					
					if((!is_null($usuario[0]['RESULT']) && !empty($usuario[0]['RESULT'])) && $usuario[0]['RESULT'] > 0){
						$res['codigo'] = '200';
						$res['mensaje'] = 'Usuario cargado correctamente. ID USUARIO:'.$usuario[0]['RESULT'];
						$res['objeto'] = $usuario;
					}else{
						$res['codigo'] = '404';
						$res['mensaje'] = 'ERROR: No se creo el usuario.'.$usuario[0]['RESULT'];
						switch($usuario[0]['RESULT']){
							case '-1':
								$res['mensaje'] = 'No se creo el nombre de usuario ya existe.';
								break;
							case '-2':
								$res['mensaje'] = 'No se creo porque el cui ya esta registrado.';
								break;
							case '-3':
								$res['mensaje'] = 'No se creo el usuario porque no se encontro el grupo.';
								break;
							case '-4':
								$res['mensaje'] = 'No se creo el usuario porque el monto maximo sin autorizacion es igual o menor a cero..';
								break;
						}
					}
				}else{
					$res['codigo'] = '417';
                	$res['mensaje'] = 'ERROR: Uno de los campos se encuentra vacio.';
				}
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: Los datos del formulario de registro, no se recibieron correctamente. <br>Por favor contacte al administrador.';
                //session_destroy();
            }
			
            return json_encode($res);
		}

		public function editarUsuario(){
			parse_str(file_get_contents("php://input"),$P_PUT);
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.'.$P_PUT['grupo'];
            
			if(isset($P_PUT['grupo']) &&
				isset($P_PUT['usuario']) &&
				isset($P_PUT['id_usuario']) &&
				isset($P_PUT['contra']) && 
				isset($P_PUT['monto']) && 
				isset($P_PUT['nombre1']) && 
				isset($P_PUT['nombre2']) && 
				isset($P_PUT['nombre3']) && 
				isset($P_PUT['apellido1']) && 
				isset($P_PUT['apellido2']) && 
				isset($P_PUT['fecha_nac'])
			){
				if(empty($P_PUT['usuario'])){
					$res['mensaje'] = 'Campo de nombre de usuario invalido.';
					return $res;
				}
				if(empty($P_PUT['id_usuario'])){
					$res['mensaje'] = 'Campo de id usuario invalido.';
					return $res;
				}
				if(empty($P_PUT['grupo'])) $P_PUT['grupo'] = 0;
				if(empty($P_PUT['contra'])) $P_PUT['contra'] = '0';
				else $P_PUT['contra'] = hash('sha256', $P_PUT['contra']);
				if(empty($P_PUT['monto'])) $P_PUT['monto'] = 0;
				if(empty($P_PUT['nombre1'])) $P_PUT['nombre1'] = '0';
				if(empty($P_PUT['nombre2'])) $P_PUT['nombre2'] = '0';
				if(empty($P_PUT['nombre3'])) $P_PUT['nombre3'] = '0';
				if(empty($P_PUT['apellido1'])) $P_PUT['apellido1'] = '0';
				if(empty($P_PUT['apellido2'])) $P_PUT['apellido2'] = '0';
				if(empty($P_PUT['fecha_nac'])) $P_PUT['fecha_nac'] = '01-01-0001';
				
				require($this->config->get('modelsDir').'UsuariosMdl.php');
				$UsuarioMdl = new UsuariosMdl($this->config);
				$usuario = $UsuarioMdl->guardarUsuario(
					$P_PUT['usuario'], $P_PUT['id_usuario'], $P_PUT['contra'], $P_PUT['nombre1'], $P_PUT['nombre2'], $P_PUT['nombre3'], $P_PUT['apellido1'], $P_PUT['apellido2'], $P_PUT['fecha_nac'], $P_PUT['grupo'], $P_PUT['monto']
				);
				
				if((!is_null($usuario[0]['RESULT']) && !empty($usuario[0]['RESULT'])) && $usuario[0]['RESULT'] > 0){
					$res['codigo'] = '200';
					$res['mensaje'] = 'Usuario guardado correctamente. ID USUARIO:'.$usuario[0]['RESULT'];
					$res['objeto'] = $usuario;
				}else{
					$res['codigo'] = '404';
					$res['mensaje'] = 'ERROR: No se guardo el usuario.'.$usuario[0]['RESULT'];
					switch($usuario[0]['RESULT']){
						case '-1':
							$res['mensaje'] = 'No se creo el usuario porque no existe.'.$usuario[0]['RESULT'];
							break;
					}
				}
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: Los datos del formulario de registro, no se recibieron correctamente. <br>Por favor contacte al administrador.';
                //session_destroy();
            }
            return json_encode($res);
		}

		public function eliminarUsuario(){
			parse_str(file_get_contents("php://input"),$D_DELETE);
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.'.$D_DELETE['grupo'];
            
			if(isset($D_DELETE['id_usuario'])){
				if(empty($D_DELETE['id_usuario'])){
					$res['mensaje'] = 'Campo de id usuario invalido.';
					return $res;
				}
				
				require($this->config->get('modelsDir').'UsuariosMdl.php');
				$UsuarioMdl = new UsuariosMdl($this->config);
				$usuario = $UsuarioMdl->eliminarUsuario(
					$D_DELETE['id_usuario']
				);
				
				if((!is_null($usuario[0]['RESULT']) && !empty($usuario[0]['RESULT'])) && $usuario[0]['RESULT'] > 0){
					$res['codigo'] = '200';
					$res['mensaje'] = 'Usuario eliminado correctamente. ID USUARIO:'.$usuario[0]['RESULT'];
					$res['objeto'] = $usuario;
				}else{
					$res['codigo'] = '404';
					$res['mensaje'] = 'ERROR: No se elimino el usuario.'.$usuario[0]['RESULT'];
					switch($usuario[0]['RESULT']){
						case '-1':
							$res['mensaje'] = 'El usuario que desea eliminar no existe..'.$usuario[0]['RESULT'];
							break;
						case '-2':
							$res['mensaje'] = 'La persona que desea eliminar no existe.'.$usuario[0]['RESULT'];
							break;
					}
				}
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: Los datos del formulario de registro, no se recibieron correctamente. <br>Por favor contacte al administrador.';
                //session_destroy();
            }
            return json_encode($res);
		}
	}
 ?>