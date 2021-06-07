<?php 
	class Cuentas{
		private $config;
		private $view;
        private $model;

		public function __construct($config){
			$this->config = $config;

            require($this->config->get('modelsDir').'CuentasMdl.php');
            $this->model = new CuentasMdl($this->config);

			$_SESSION['login_time'] = time(); //Reinicia el tiempo de inactividad
			require_once($this->config->get('baseDir').'Template.php');
			$this->view = new Template();
		}

		public function listaCuentas(){
			require($this->config->get('modelsDir').'UsuariosMdl.php');
			$UsuarioMdl = new UsuariosMdl($this->config);

            $this->view->usr = $UsuarioMdl;
			$this->view->modulos = $UsuarioMdl->obtenerModulos($_SESSION['id_usuario']);
			$this->view->cuentas = $this->model->obtenerCuentas();
			$this->view->bancos = $this->model->obtenerBancos();
			//$this->view->grupos = $ProveedorMdl->obtenerGrupos();
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'menu.php');
			$this->view->contenido .= $this->view->render($this->config->get('viewsDir').'cuentas.php');
			echo $this->view->render($this->config->get('viewsDir').'header.php');
		}

		public function obtenerCuenta($id){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            if(isset($id)){
                $cuentas = $this->model->obtenerCuenta($id);
                if($cuentas){
                    $res['codigo'] = '200';
                    $res['mensaje'] = 'Se obtuvo con exito la cuenta.';
                    $res['objeto'] = $cuentas;
                }else{
                    $res['codigo'] = '404';
                    $res['mensaje'] = 'No se pudo obtener correctamente la cuenta.';
                    
                }
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: El id del proveedor no se recibio. <br>Por favor contacte al administrador.';
                //session_destroy();
            }
            return json_encode($res);
		}

		public function crearCuenta(){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            
			if(isset($_POST['id_banco']) &&
				isset($_POST['numero']) && 
				isset($_POST['cheque_inicial']) && 
				isset($_POST['cheque_final'])
			){
				if(
					!empty($_POST['id_banco']) &&
					!empty($_POST['numero']) &&
					!empty($_POST['cheque_inicial']) &&
					!empty($_POST['cheque_final'])
					
				){
                    if($this->model->existeBanco($_POST['id_banco'])['ID_BANCO'] >= 1){
                        if($this->model->existeCuenta($_POST['numero'])['NUMERO'] <= 0){
                            $this->model->crearCuenta($_POST['numero'], $_POST['id_banco'], $_POST['cheque_inicial'], $_POST['cheque_final']);

                            $res['codigo'] = '200';
                            $res['mensaje'] = 'ERROR: Cuenta creada exitosamente.';
                        }else{
                            $res['codigo'] = '404';
                            $res['mensaje'] = 'ERROR: Ya existe la cuenta bancaria.';
                            
                        }
                    }else{
                        $res['codigo'] = '404';
                        $res['mensaje'] = 'ERROR: No existe el banco seleccionado.';
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

		public function editarCuenta(){
			parse_str(file_get_contents("php://input"),$P_PUT);
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            
			if(isset($P_PUT['numero']) &&
				isset($P_PUT['id_banco']) &&
				isset($P_PUT['cheque_inicial']) && 
				isset($P_PUT['cheque_final'])
			){
				if(empty($P_PUT['numero'])) $P_PUT['numero'] = '0';
				if(empty($P_PUT['id_banco'])) $P_PUT['id_banco'] = 0;
				if(empty($P_PUT['cheque_inicial'])) $P_PUT['cheque_inicial'] = 0;
				if(empty($P_PUT['cheque_final'])) $P_PUT['cheque_final'] = 0;
				
                

				if($this->model->existeBanco($P_PUT['id_banco'])['ID_BANCO'] >= 1){
                    if($this->model->existeCuenta($P_PUT['numero'])['NUMERO'] <= 1){
                        $this->model->guardarCuenta($P_PUT['numero'], $P_PUT['id_banco'], $P_PUT['cheque_inicial'], $P_PUT['cheque_final']);

                        $res['codigo'] = '200';
                        $res['mensaje'] = 'ERROR: Cuenta guardada exitosamente.';
                    }else{
                        $res['codigo'] = '404';
                        $res['mensaje'] = 'ERROR: Ya existe la cuenta bancaria.';
                        
                    }
                }else{
                    $res['codigo'] = '404';
                    $res['mensaje'] = 'ERROR: No existe el banco seleccionado x.';
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