<?php 
	class ProveedoresMdl{
		private $db;

		public function __construct($config){
			$this->db = new Database($config);
		}

		public function obtenerProveedores(){
			$this->db->query("SELECT a.id_proveedor, a.nombre, a.nit, b.primer_nombre FROM proveedores a
			INNER JOIN personas b ON b.id_persona = a.id_persona
			ORDER BY a.id_proveedor");
			return $this->db->resultSet();
		}

		public function obtenerProveedor($id){
			$this->db->query("SELECT a.id_proveedor, a.nombre, a.nit, b.cui, b.primer_nombre, b.segundo_nombre, b.otro_nombre, b.primer_apellido, b.segundo_apellido, TO_CHAR(TO_DATE(b.fecha_nac, 'DD-MM-RRRR'),'RRRR-MM-DD') AS fecha_nac FROM proveedores a
			INNER JOIN personas b ON b.id_persona = a.id_persona WHERE a.id_proveedor = $id");
			$this->db->bind(':id', $id);
			return $this->db->single();
		}

		public function crearUsuarios($nombre, $contra, $cui, $nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $fechanac, $grupo, $monto){
			$this->db->query("SELECT usuario_crear(:nombre, :contra, :cui, :nombre1, :nombre2, :nombre3, :apellido1, :apellido2, TO_CHAR(TO_DATE(:fechanac, 'RRRR-MM-DD'),'DD-MM-RRRR'), :grupo, :monto) AS result FROM dual");
			$this->db->bind(':nombre', $nombre);
			$this->db->bind(':contra', $contra);
			$this->db->bind(':cui', $cui);
			$this->db->bind(':nombre1', $nombre1);
			$this->db->bind(':nombre2', $nombre2);
			$this->db->bind(':nombre3', $nombre3);
			$this->db->bind(':apellido1', $apellido1);
			$this->db->bind(':apellido2', $apellido2);
			$this->db->bind(':fechanac', $fechanac);
			$this->db->bind(':grupo', $grupo);
			$this->db->bind(':monto', $monto);
			return $this->db->resultSet();
		}

		public function guardarProveedor($proveedor, $nit, $cui, $nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $fechanac){
			$this->db->query("SELECT proveedor_guardar(:proveedor, :nit, :cui, :nombre1, :nombre2, :nombre3, :apellido1, :apellido2, TO_CHAR(TO_DATE(:fechanac, 'RRRR-MM-DD'),'DD-MM-RRRR')) AS result FROM dual");
			$this->db->bind(':proveedor', $proveedor);
			$this->db->bind(':nit', $nit);
			$this->db->bind(':cui', $cui);
			$this->db->bind(':nombre1', $nombre1);
			$this->db->bind(':nombre2', $nombre2);
			$this->db->bind(':nombre3', $nombre3);
			$this->db->bind(':apellido1', $apellido1);
			$this->db->bind(':apellido2', $apellido2);
			$this->db->bind(':fechanac', $fechanac);
			return $this->db->resultSet();
		}

		public function crearProveedor($proveedor, $nit, $cui, $nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $fechanac){
			$this->db->query("SELECT proveedor_crear(:proveedor, :nit, :cui, :nombre1, :nombre2, :nombre3, :apellido1, :apellido2, TO_CHAR(TO_DATE(:fechanac, 'RRRR-MM-DD'),'DD-MM-RRRR')) AS result FROM dual");
			$this->db->bind(':proveedor', $proveedor);
			$this->db->bind(':nit', $nit);
			$this->db->bind(':cui', $cui);
			$this->db->bind(':nombre1', $nombre1);
			$this->db->bind(':nombre2', $nombre2);
			$this->db->bind(':nombre3', $nombre3);
			$this->db->bind(':apellido1', $apellido1);
			$this->db->bind(':apellido2', $apellido2);
			$this->db->bind(':fechanac', $fechanac);
			return $this->db->resultSet();
		}

		public function eliminarUsuario($id){
			$this->db->query("SELECT usuario_eliminar(:id) AS result FROM dual");
			$this->db->bind(':id', $id);
			return $this->db->resultSet();
		}

		public function obtenerGrupos(){
			$this->db->query("SELECT id_grupo, nombre, descripcion FROM grupos");
			return $this->db->resultSet();
		}

		public function validarLogin($nombre){
			$this->db->query("SELECT id_usuario, contra FROM usuarios WHERE nombre_usuario = :nombre");
			$this->db->bind(':nombre', $nombre);
			return $this->db->single();
		}


	}
 ?>
