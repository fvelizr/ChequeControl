<?php
    class Validacion{
		private $config;
		private $view;

		public function __construct($config){
			$this->config = $config;

            $_SESSION['login_time'] = time(); //Reinicia el tiempo de inactividad
			require_once($this->config->get('baseDir').'Template.php');
			$this->view = new Template();
		}

		public function indexAction(){
			$this->view->contenido = $this->view->render($this->config->get('viewsDir').'login.php');
            echo $this->view->render($this->config->get('viewsDir').'header.php');
		}

        public function validarIngreso(){
            $res = array();
            $res['codigo'] = '404';
            $res['mensaje'] = 'ERROR: validación no defina, contacte al administrador.';
            if(isset($_POST['usuario']) && isset($_POST['contra'])){
                require($this->config->get('modelsDir').'UsuariosMdl.php');
                $UsuarioMdl = new UsuariosMdl($this->config);
                $usuario = $UsuarioMdl->validarLogin($_POST['usuario']);
                $res['mensaje'] = $usuario;
                if($usuario['CONTRA'] == hash('sha256', $_POST['contra'])){
                    $_SESSION['login_token'] = $usuario['CONTRA'].time();
                    $_SESSION['login_time'] = time();
                    $_SESSION['id_usuario'] = $usuario['ID_USUARIO'];
                    $_SESSION['nombre'] = $_POST['usuario'];
                    
                    $res['codigo'] = '200';
                    $res['mensaje'] = 'Se ha iniciado sesión correctamente';
                }else{
                    $res['codigo'] = '100';
                    $res['mensaje'] = 'ERROR: usuario o contraseña invalidos.';
                }
                /*if(($_POST['usuario'] == 'admin') && ($_POST['contra'] == '1234')){
                    

                    $_SESSION['login_token'] = hash('sha256', 'prueba');
                    $_SESSION['login_time'] = time();
                    
                    $res['codigo'] = '200';
                    $res['mensaje'] = 'Se ha iniciado sesión correctamente';
                }else{
                    $res['codigo'] = '100';
                    $res['mensaje'] = 'ERROR: usuario o contraseña invalidos.';
                    session_destroy();
                }*/
            }else{
                $res['codigo'] = '417';
                $res['mensaje'] = 'ERROR: El nombre de usuario y contraseña se recibio. <br>Por favor contacte al administrador.';
                session_destroy();
            }
            return json_encode($res);
		}
	}
?>