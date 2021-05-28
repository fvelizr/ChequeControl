<?php 
	class Cheques{
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

		public function listaCheques(){
			require($this->config->get('modelsDir').'UsuariosMdl.php');
			$UsuarioMdl = new UsuariosMdl($this->config);

            require($this->config->get('modelsDir').'CuentasMdl.php');
			$CuentasMdl = new CuentasMdl($this->config);

			$this->view->modulos = $UsuarioMdl->obtenerModulos($_SESSION['id_usuario']);
			$this->view->Cheques = $this->model->obtenerCheques();
			$this->view->bancos = $CuentasMdl->obtenerBancos();
            require($this->config->get('modelsDir').'ProveedoresMdl.php');
			$ProveedorMdl = new ProveedoresMdl($this->config);
            $this->view->proveedores = $ProveedorMdl->obtenerProveedores();
			//$this->view->grupos = $ProveedorMdl->obtenerGrupos();
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'menu.php');
			$this->view->contenido .= $this->view->render($this->config->get('viewsDir').'Cheques.php');
			echo $this->view->render($this->config->get('viewsDir').'header.php');
		}

        public function obtenerCuentas($id_banco){
            $res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            if(isset($id_banco)){
                require($this->config->get('modelsDir').'CuentasMdl.php');
                $Cuentas = new CuentasMdl($this->config);

                if($Cuentas->existeBanco($id_banco)['ID_BANCO'] >= 1){
                    $res['codigo'] = '200';
                    $res['mensaje'] = 'Se obtuvo con exito los cheques.';
                    $res['objeto'] = $this->model->obtenerCuentas($id_banco);
                }else{
                    $res['codigo'] = '404';
                    $res['mensaje'] = 'ERROR: No existe el banco seleccionado.';
                }
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: El id del proveedor no se recibio. <br>Por favor contacte al administrador.';
                //session_destroy();
            }
            return json_encode($res);
        }

		public function obtenerCheque($id){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            if(isset($id)){
                $Cheques = $this->model->obtenerCheque($id);
                if($Cheques){
                    $res['codigo'] = '200';
                    $res['mensaje'] = 'Se obtuvo con exito la Cheque.';
                    $res['objeto'] = $Cheques;
                }else{
                    $res['codigo'] = '404';
                    $res['mensaje'] = 'No se pudo obtener correctamente la Cheque.';
                    $res['objeto'] = $Cheques;
                    
                }
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: El id del proveedor no se recibio. <br>Por favor contacte al administrador.';
                //session_destroy();
            }
            return json_encode($res);
		}

		public function crearCheque(){
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
			if(isset($_POST['id_banco']) &&
				isset($_POST['cuentas_bancarias']) && 
				isset($_POST['numero']) && 
				isset($_POST['lugar']) && 
				isset($_POST['fecha']) && 
				isset($_POST['total']) && 
				isset($_POST['id_proveedor']) && 
				isset($_POST['nombre'])
				//isset($_POST['letras'])
			){
				if(
					!empty($_POST['id_banco']) &&
					!empty($_POST['cuentas_bancarias']) &&
					!empty($_POST['numero']) &&
					!empty($_POST['lugar']) &&
					!empty($_POST['fecha']) &&
					!empty($_POST['total']) &&
					!empty($_POST['id_proveedor']) &&
					!empty($_POST['nombre'])
					//!empty($_POST['letras'])
					
				){
                    require($this->config->get('modelsDir').'CuentasMdl.php');
                    $Cuentas = new CuentasMdl($this->config);

                    if($Cuentas->existeBanco($_POST['id_banco'])['ID_BANCO'] >= 1){
                        if($Cuentas->existeCuenta($_POST['cuentas_bancarias'])['NUMERO'] >= 1){
                            if($this->model->existeCheque($_POST['id_banco'], $_POST['cuentas_bancarias'], $_POST['numero'])['NUMERO'] <= 0){
                                $this->model->crearCheque($_POST['numero'], $_POST['fecha'], $_POST['total'], $_POST['cuentas_bancarias'], $_POST['id_banco'], $_POST['id_proveedor'], $_SESSION['id_usuario'], $_POST['nombre']);

                                $res['codigo'] = '200';
                                $res['mensaje'] = 'ERROR: Cheque creada exitosamente.';
                            }else{
                                $res['codigo'] = '4040';
                                $res['mensaje'] = 'ERROR: Ya existe este numero de cheque.';
                            }
                        }else{
                            $res['codigo'] = '404';
                            $res['mensaje'] = 'ERROR: Ya existe la Cheque bancaria.';
                            
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

		public function editarCheque(){
			parse_str(file_get_contents("php://input"),$P_PUT);
			$res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
			if(isset($P_PUT['id_banco']) &&
				isset($P_PUT['cuentas_bancarias']) && 
				isset($P_PUT['numero']) && 
				isset($P_PUT['lugar']) && 
				isset($P_PUT['fecha']) && 
				isset($P_PUT['total']) && 
				isset($P_PUT['id_proveedor']) && 
				isset($P_PUT['nombre'])
				//isset($_POST['letras'])
			){
				if(
					!empty($P_PUT['id_banco']) &&
					!empty($P_PUT['cuentas_bancarias']) &&
					!empty($P_PUT['numero']) &&
					!empty($P_PUT['lugar']) &&
					!empty($P_PUT['fecha']) &&
					!empty($P_PUT['total']) &&
					!empty($P_PUT['id_proveedor']) &&
					!empty($P_PUT['nombre'])
					//!empty($_POST['letras'])
					
				){
                    require($this->config->get('modelsDir').'CuentasMdl.php');
                    $Cuentas = new CuentasMdl($this->config);

                    if($Cuentas->existeBanco($P_PUT['id_banco'])['ID_BANCO'] >= 1){
                        if($Cuentas->existeCuenta($P_PUT['cuentas_bancarias'])['NUMERO'] >= 1){
                            if($this->model->existeCheque($P_PUT['id_banco'], $P_PUT['cuentas_bancarias'], $P_PUT['numero'])['NUMERO'] >= 1){
                                //die(json_encode($this->model->guardarCheque($P_PUT['numero'], $P_PUT['fecha'], $P_PUT['total'], $P_PUT['cuentas_bancarias'], $P_PUT['id_banco'], $P_PUT['id_proveedor'], $P_PUT['nombre'])));

                                $res['codigo'] = '200';
                                $res['mensaje'] = 'ERROR: Se guardo correctamente el cheque.';
                                $res['objeto'] = json_encode($P_PUT['nombre']);
                            }else{
                                $res['codigo'] = '4040';
                                $res['mensaje'] = 'ERROR: No existe .';
                            }
                        }else{
                            $res['codigo'] = '404';
                            $res['mensaje'] = 'ERROR: No existe esta cuenta bancaria.';
                            
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
    }
 ?>