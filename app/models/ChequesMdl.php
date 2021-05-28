<?php 
	class ChequesMdl{
		private $db;

		public function __construct($config){
			$this->db = new Database($config);
		}

        public function obtenerCheques(){
            $this->db->query("SELECT a.numero AS numero, a.total AS monto, a.cuentas_bancarias AS cuenta, c.nombre AS banco, d.nombre as proveedor from cheques a
            LEFT JOIN bancos c ON c.id_banco = a.id_banco
            LEFT JOIN proveedores d ON a.id_proveedor = d.id_proveedor");
            return $this->db->resultSet();
        }

        public function obtenerCheque($num){
            $this->db->query("SELECT a.numero AS numero, a.total AS monto, a.cuentas_bancarias AS cuenta, a.id_banco AS banco, d.nombre as proveedor, d.id_proveedor AS id_proveedor, TO_CHAR(TO_DATE(a.fecha, 'DD-MM-RRRR'),'RRRR-MM-DD') as fecha from cheques a
            LEFT JOIN bancos c ON c.id_banco = a.id_banco
            LEFT JOIN proveedores d ON a.id_proveedor = d.id_proveedor
            WHERE numero = :num");
            $this->db->bind(':num', $num);
            return $this->db->single();
        }

        public function obtenerCuentas($id_banco){
            $this->db->query('SELECT numero, cheque_inicial, cheque_final FROM cuentas_bancarias WHERE id_banco=:id_banco');
            $this->db->bind(':id_banco', $id_banco);
            return $this->db->resultSet();
        }

        public function existeCheque($banco, $cuenta, $num){
            $this->db->query('SELECT count(numero) AS numero FROM cheques WHERE id_banco=:banco AND cuentas_bancarias=:cuenta AND numero = :num');
            $this->db->bind(':banco', $banco);
            $this->db->bind(':cuenta', $cuenta);
            $this->db->bind(':num', $num);
            return $this->db->single();
        }


        public function crearCheque($numero, $fecha, $tot, $cuen, $id_banco, $id_proveedor, $id_usuario, $nombre){
            $this->db->query("INSERT INTO cheques (numero, fecha, total, cuentas_bancarias, id_banco, id_proveedor, id_usuario, nombre)VALUES (:numero, TO_CHAR(TO_DATE(:fecha , 'RRRR-MM-DD'),'DD-MM-RRRR'), :tot, :cuen, :id_banco, :id_proveedor, :id_usuario, :nombre)");
            //$this->db->query('COMMIT');
            $this->db->bind(':numero', $numero);
            $this->db->bind(':fecha', $fecha);
            $this->db->bind(':tot', $tot);
            //$this->db->bind(':referencia', $referencia);
            $this->db->bind(':cuen', $cuen);
            $this->db->bind(':id_banco', $id_banco);
            $this->db->bind(':id_proveedor', $id_proveedor);
            $this->db->bind(':id_usuario', $id_usuario);
            $this->db->bind(':nombre', $nombre);
            return $this->db->execute();
        }
        
        public function guardarCheque($numero, $fecha, $tot, $cuen, $id_banco, $id_proveedor, $nombre){
            $this->db->query("UPDATE cheques SET
            total = :tot
            ");


            //$this->db->bind(':numero', $numero);
            //$this->db->bind(':fecha', $fecha);
           //$this->db->bind(':tot', $tot);
            //$this->db->bind(':referencia', $referencia);
            //$this->db->bind(':cuen', $cuen);
            //$this->db->bind(':id_banco', $id_banco);
            //$this->db->bind(':id_proveedor', $id_proveedor);
            //$this->db->bind(':id_usuario', $id_usuario);
            //$this->db->bind(':nombre', $nombre);
            return $this->db->execute();
        }
	}
 ?>
