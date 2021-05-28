<?php 
	class Proveedores{
		private $config;
		private $view;

		public function __construct($config){
			$this->config = $config;

			$this->view->url = $config->get('baseUrl');

			$_SESSION['login_time'] = time(); //Reinicia el tiempo de inactividad
			require_once($this->config->get('baseDir').'Template.php');
			$this->view = new Template();
		}

		public function listaProveedores(){
			require($this->config->get('modelsDir').'UsuariosMdl.php');
			$UsuarioMdl = new UsuariosMdl($this->config);

			require($this->config->get('modelsDir').'ProveedoresMdl.php');
			$ProveedorMdl = new ProveedoresMdl($this->config);

			$this->view->modulos = $UsuarioMdl->obtenerModulos($_SESSION['id_usuario']);
			$this->view->proveedores = $ProveedorMdl->obtenerProveedores();
			//$this->view->grupos = $ProveedorMdl->obtenerGrupos();
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'menu.php');
			$this->view->contenido .= $this->view->render($this->config->get('viewsDir').'proveedor.php');
			echo $this->view->render($this->config->get('viewsDir').'header.php');
		}

		public function obtenerProveedor($id){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            if(isset($id)){
				require($this->config->get('modelsDir').'ProveedoresMdl.php');
				$ProveedorMdl = new ProveedoresMdl($this->config);
				$proveedor = $ProveedorMdl->obtenerProveedor($id);
				if(!is_null($proveedor) && !empty($proveedor)){
					$res['codigo'] = '200';
                	$res['mensaje'] = 'Proveedor cargado correctamente. ID USUARIO:'.$id;
					$res['objeto'] = array($proveedor);
				}else{
					$res['codigo'] = '404';
                	$res['mensaje'] = 'ERROR: No se encontro el proveedor. ID USUARIO:'.$id;
				}
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: El id del proveedor no se recibio. <br>Por favor contacte al administrador.';
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

		public function editarProveedor(){
			parse_str(file_get_contents("php://input"),$P_PUT);
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.'.$P_PUT['grupo'];
            
			if(isset($P_PUT['nomproveedor']) &&
				isset($P_PUT['nit']) &&
				isset($P_PUT['nombre1']) && 
				isset($P_PUT['nombre2']) && 
				isset($P_PUT['nombre3']) && 
				isset($P_PUT['apellido1']) && 
				isset($P_PUT['apellido2']) && 
				isset($P_PUT['fecha_nac'])
			){
				if(empty($P_PUT['nomproveedor'])){
					$res['mensaje'] = 'Campo de proveedor invalido.';
					return $res;
				}
				if(empty($P_PUT['nit'])){
					$res['mensaje'] = 'Campo de nit invalido.';
					return $res;
				}
				if(empty($P_PUT['nombre1'])) $P_PUT['nombre1'] = '0';
				if(empty($P_PUT['nombre2'])) $P_PUT['nombre2'] = '0';
				if(empty($P_PUT['nombre3'])) $P_PUT['nombre3'] = '0';
				if(empty($P_PUT['apellido1'])) $P_PUT['apellido1'] = '0';
				if(empty($P_PUT['apellido2'])) $P_PUT['apellido2'] = '0';
				if(empty($P_PUT['fecha_nac'])) $P_PUT['fecha_nac'] = '01-01-0001';
				
				require($this->config->get('modelsDir').'ProveedoresMdl.php');
				$ProveedoresMdl = new ProveedoresMdl($this->config);
				$proveedor = $ProveedoresMdl->guardarProveedor(
					$P_PUT['nomproveedor'], $P_PUT['nit'], $P_PUT['cui'], $P_PUT['nombre1'], $P_PUT['nombre2'], $P_PUT['nombre3'], $P_PUT['apellido1'], $P_PUT['apellido2'], $P_PUT['fecha_nac']
				);
				$res['mensaje'] = $proveedor;
				if((!is_null($proveedor[0]['RESULT']) && !empty($proveedor[0]['RESULT'])) && $proveedor[0]['RESULT'] > 0){
					$res['codigo'] = '200';
					$res['mensaje'] = 'Usuario guardado correctamente. ID USUARIO:'.$proveedor[0]['RESULT'];
					$res['objeto'] = $proveedor;
				}else{
					$res['codigo'] = '404';
					$res['mensaje'] = 'ERROR: No se guardo el usuario.'.$proveedor[0]['RESULT'];
					switch($proveedor[0]['RESULT']){
						case '-1':
							$res['mensaje'] = 'No se creo el usuario porque no existe.'.$proveedor[0]['RESULT'];
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

		public function crearProveedor(){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            
			if(isset($_POST['nomproveedor']) &&
				isset($_POST['nit']) && 
				isset($_POST['cui']) && 
				isset($_POST['nombre1']) && 
				isset($_POST['nombre2']) && 
				isset($_POST['nombre3']) && 
				isset($_POST['apellido1']) && 
				isset($_POST['apellido2']) && 
				isset($_POST['fecha_nac'])
			){
				if(
					!empty($_POST['nomproveedor']) &&
					!empty($_POST['nit']) &&
					!empty($_POST['cui']) &&
					!empty($_POST['nombre1']) &&
					!empty($_POST['nombre2']) && 
					!empty($_POST['nombre3']) &&
					!empty($_POST['nombre1']) && 
					!empty($_POST['apellido1']) &&
					!empty($_POST['apellido2']) &&
					!empty($_POST['fecha_nac'])
				){
					require($this->config->get('modelsDir').'ProveedoresMdl.php');
					$ProveedoresMdl = new ProveedoresMdl($this->config);
					$Proveedores = $ProveedoresMdl->crearProveedor(
						$_POST['nomproveedor'], $_POST['nit'], $_POST['cui'], $_POST['nombre1'], $_POST['nombre2'], $_POST['nombre3'], $_POST['apellido1'], $_POST['apellido2'], $_POST['fecha_nac']
					);

					//return json_encode($res);

					if((!is_null($Proveedores[0]['RESULT']) && !empty($Proveedores[0]['RESULT'])) && $Proveedores[0]['RESULT'] > 0){
						$res['codigo'] = '200';
						$res['mensaje'] = 'Proveedor cargado correctamente. ID Proveedor:'.$Proveedores[0]['RESULT'];
						$res['objeto'] = $Proveedores;
					}else{
						$res['codigo'] = '404';
						$res['mensaje'] = 'ERROR: No se creo el Proveedor.'.$Proveedores[0]['RESULT'];
						switch($Proveedores[0]['RESULT']){
							case '-1':
								$res['mensaje'] = 'No se creo el nombre de Proveedor ya existe.';
								break;
							case '-2':
								$res['mensaje'] = 'No se creo porque el cui ya esta registrado.';
								break;
							case '-3':
								$res['mensaje'] = 'No se creo el Proveedor porque no se encontro el grupo.';
								break;
							case '-4':
								$res['mensaje'] = 'No se creo el Proveedor porque el monto maximo sin autorizacion es igual o menor a cero..';
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
	}
 ?>