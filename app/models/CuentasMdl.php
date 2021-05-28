<?php 
	class CuentasMdl{
		private $db;

		public function __construct($config){
			$this->db = new Database($config);
		}

        public function obtenerCuentas(){
            $this->db->query('SELECT a.numero, a.cheque_inicial, a.cheque_final, b.id_banco, b.nombre FROM cuentas_bancarias a
            LEFT JOIN bancos b ON a.id_banco = b.id_banco');
            return $this->db->resultSet();
        }

        public function obtenerCuenta($num){
            $this->db->query('SELECT a.numero, a.cheque_inicial, a.cheque_final, b.id_banco, b.nombre FROM cuentas_bancarias a
            LEFT JOIN bancos b ON a.id_banco = b.id_banco
            WHERE numero = :num');
            $this->db->bind(':num', $num);
            return $this->db->single();
        }

        public function obtenerBancos(){
            $this->db->query('SELECT id_banco, nombre FROM bancos');
            return $this->db->resultSet();
        }

        public function existeBanco($id){
            $this->db->query('SELECT count(id_banco) AS id_banco FROM bancos WHERE id_banco = :id');
            $this->db->bind(':id', $id);
            return $this->db->single();
        }

        public function existeCuenta($numero){
            $this->db->query('SELECT count(numero) AS numero FROM cuentas_bancarias WHERE numero = :numero');
            $this->db->bind(':numero', $numero);
            return $this->db->single();
        }

        public function crearCuenta($num, $banco, $inicial, $final){
            $this->db->query('INSERT INTO cuentas_bancarias (numero, id_banco, cheque_inicial, cheque_final)VALUES(:num, :banco, :inicial, :final)');
            //$this->db->query('COMMIT');
            $this->db->bind(':num', $num);
            $this->db->bind(':banco', $banco);
            $this->db->bind(':inicial', $inicial);
            $this->db->bind(':final', $final);
            return $this->db->execute();
        }
        public function guardarCuenta($num, $banco, $inicial, $final){
            $this->db->query('UPDATE cuentas_bancarias SET id_banco=:banco, cheque_inicial=:inicial, cheque_final=:final WHERE numero = :num');
            //$this->db->query('COMMIT');
            $this->db->bind(':num', $num);
            $this->db->bind(':banco', $banco);
            $this->db->bind(':inicial', $inicial);
            $this->db->bind(':final', $final);
            return $this->db->execute();
        }
	}
 ?>
