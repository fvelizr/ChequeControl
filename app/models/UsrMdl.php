<?php 
	class UsrMdl{
		private $db;

		public function __construct($config){
			$this->db = new Database($config);
		}

		public function crearUsuario(){
			$this->db->query('
			SELECT usr_crear(
				:nombre_usuario,
				:contra,
				:id_persona,
				:id_grupo,
				:max_monto_cheque).msg AS res FROM dual
				');
			$this->db->bind(':nombre_usuario', $_POST['nombre_usuario']);
			$this->db->bind(':contra', $_POST['contra']);
			$this->db->bind(':id_persona', $_POST['id_persona']);
			$this->db->bind(':id_grupo', $_POST['id_grupo']);
			$this->db->bind(':max_monto_cheque', $_POST['max_monto_cheque']);
			return $this->db->resultSet();
		}

		public function obtenerGrupos(){
			$this->db->query("SELECT * FROM grupos ORDER BY id_grupo");
			return $this->db->resultSet();
		}

		public function obtenerUsuarios(){
			$this->db->query("SELECT a.id_usuario, a.nombre_usuario, TO_CHAR(TO_DATE(a.fecha_creacion, 'DD-MM-RRRR'),'RRRR-MM-DD') AS fecha_creacion, b.primer_nombre, b.primer_apellido, a.id_grupo FROM usuarios a
			INNER JOIN personas b ON b.id_persona = a.id_persona
			ORDER BY a.id_usuario");
			return $this->db->resultSet();
		}

		public function obtenerUsuario($id){
			$datos = array();
			$this->db->query("SELECT a.id_usuario, a.nombre_usuario, TO_CHAR(TO_DATE(a.fecha_creacion, 'DD-MM-RRRR'),'RRRR-MM-DD') AS fecha_creacion, a.max_monto_cheque AS monto, b.cui, b.primer_nombre, b.segundo_nombre, b.otro_nombre, b.primer_apellido, b.segundo_apellido, TO_CHAR(TO_DATE(b.fecha_nac, 'DD-MM-RRRR'),'RRRR-MM-DD') AS fecha_nac, a.id_grupo FROM usuarios a
			INNER JOIN personas b ON b.id_persona = a.id_persona WHERE a.id_usuario = :id");
			$this->db->bind(':id', $id);
			$datos['informacion']  = $this->db->single();

			$this->db->query("SELECT a.id_modulo, a.nombre, a.descripcion, nvl(b.id_modulo,0) AS permiso FROM modulos a
			LEFT JOIN 
				((SELECT id_modulo FROM usuarios_modulos WHERE id_usuario = :id)
				UNION
				(SELECT id_modulo FROM grupos_modulos WHERE id_grupo = (SELECT id_grupo FROM usuarios WHERE id_usuario = :id))) b
			ON a.id_modulo = b.id_modulo
			WHERE a.asignable = 1 AND a.padre = 0");
			$this->db->bind(':id', $id);
			$datos['modulos']  = $this->db->resultSet();

			$this->db->query("SELECT a.id_privilegio, a.nombre, a.descripcion, nvl(b.id_privilegio,0) AS permiso FROM privilegios a
			LEFT JOIN 
				((SELECT id_privilegio FROM usuarios_privilegios WHERE id_usuario = 1)
				UNION
				(SELECT id_privilegio FROM grupos_privilegios WHERE id_grupo = (SELECT id_grupo FROM usuarios WHERE id_usuario = :id))) b
			ON a.id_privilegio = b.id_privilegio");
			$this->db->bind(':id', $id);
			$datos['privilegios']  = $this->db->resultSet();
			return $datos;
		}

		public function obtenerModulo($usuario, $modulo){
			$this->db->query("SELECT a.id_modulo, a.nombre, a.descripcion, nvl(b.id_modulo,0) AS permiso, a.ruta, a.padre, a.asignable FROM modulos a
			INNER JOIN 
				((SELECT id_modulo FROM usuarios_modulos WHERE id_usuario = :usuario)
				UNION
				(SELECT id_modulo FROM grupos_modulos WHERE id_grupo = (SELECT id_grupo FROM usuarios WHERE id_usuario = :usuario))) b
			ON a.id_modulo = b.id_modulo
			WHERE a.id_modulo = :modulo
            ORDER BY a.id_modulo");
			$this->db->bind(':usuario', $usuario);
			$this->db->bind(':modulo', $modulo);
			return $this->db->resultSet();
		}

		public function obtenerModulos($usuario){
			$this->db->query("SELECT a.id_modulo, a.nombre, a.descripcion, nvl(b.id_modulo,0) AS permiso, a.ruta, a.padre, a.asignable FROM modulos a
			INNER JOIN 
				((SELECT id_modulo FROM usuarios_modulos WHERE id_usuario = :usuario)
				UNION
				(SELECT id_modulo FROM grupos_modulos WHERE id_grupo = (SELECT id_grupo FROM usuarios WHERE id_usuario = :usuario))) b
			ON a.id_modulo = b.id_modulo
            ORDER BY a.id_modulo");
			$this->db->bind(':usuario', $usuario);
			return $this->db->resultSet();
		}
	}
 ?>
