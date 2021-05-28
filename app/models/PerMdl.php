<?php 
	class PerMdl{
		private $db;

		public function __construct($config){
			$this->db = new Database($config);
		}

        public function obtenerPersonas(){
            $this->db->query('SELECT * FROM personas ORDER BY cui');
            return $this->db->resultSet();
        }

        public function crearPersona(){
            $this->db->query('
            SELECT per_crear(
                :cui,
                :primer_nombre,
                :segundo_nombre,
                :otro_nombre,
                :primer_apellido,
                :segundo_apellido,
                :fecha_nac).msg AS res FROM dual
            ');
            $this->db->bind(':cui', $_POST['cui']);
            $this->db->bind(':primer_nombre', $_POST['primer_nombre']);
            $this->db->bind(':segundo_nombre', $_POST['segundo_nombre']);
            $this->db->bind(':otro_nombre', $_POST['otro_nombre']);
            $this->db->bind(':primer_apellido', $_POST['primer_apellido']);
            $this->db->bind(':segundo_apellido', $_POST['segundo_apellido']);
            $this->db->bind(':fecha_nac', $_POST['fecha_nac']);
            return $this->db->resultSet();
        }
	}
 ?>
