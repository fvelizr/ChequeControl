<?php 
	class ChequesMdl{
		private $db;

		public function __construct($config){
			$this->db = new Database($config);
		}

        public function obtenerCheques(){
            $this->db->query("SELECT a.numero AS numero, a.total AS monto, a.cuentas_bancarias AS cuenta, c.nombre AS banco, d.nombre as proveedor,
            e.cheque_inicial AS auditoria, e.cheque_final AS gerencia, a.estado AS estado
        from cheques a
                    LEFT JOIN bancos c ON c.id_banco = a.id_banco
                    LEFT JOIN proveedores d ON a.id_proveedor = d.id_proveedor
                    LEFT JOIN cuentas_bancarias e ON e.numero = a.cuentas_bancarias
                    WHERE
                    (estado = 'Creado' AND (obtenerPrivilegio(:idusuario,1040100).codigo > 0))
                    OR
                    (estado = 'Auditado' AND (obtenerPrivilegio(:idusuario,1050100).codigo > 0))
                    OR
                    (estado = 'Auditado' AND (obtenerPrivilegio(:idusuario,1060100).codigo > 0))
                    OR
                    (estado = 'Auditado' AND (obtenerPrivilegio(:idusuario,10402).codigo > 0))
                    OR
                    (estado = 'Gerenciado' AND (obtenerPrivilegio(:idusuario,1060100).codigo > 0 OR obtenerPrivilegio(:idusuario,1070100).codigo > 0))
                    OR
                    (estado = 'Impreso' AND (obtenerPrivilegio(:idusuario,1070100).codigo > 0))
                    OR
                    (estado = 'Entregado' AND (obtenerPrivilegio(:idusuario,1080100).codigo > 0))
                    ");
            $this->db->bind(':idusuario', $_SESSION['id_usuario']);
            return $this->db->resultSet();
        }

        public function obtenerCheque($num){
            $this->db->query("SELECT a.numero AS numero, a.total AS monto, a.cuentas_bancarias AS cuenta, a.id_banco AS banco, a.nombre as proveedor, d.id_proveedor AS id_proveedor, TO_CHAR(TO_DATE(a.fecha, 'DD-MM-RRRR'),'RRRR-MM-DD') as fecha from cheques a
            LEFT JOIN bancos c ON c.id_banco = a.id_banco
            LEFT JOIN proveedores d ON a.id_proveedor = d.id_proveedor
            WHERE numero = :num");
            $this->db->bind(':num', $num);
            return $this->db->single();
        }

        public function obtenerChequeImp($num){
            $this->db->query("SELECT a.numero AS numero, a.total AS monto, a.cuentas_bancarias AS cuenta, c.nombre AS banco, a.nombre as proveedor, d.nombre AS id_proveedor, TO_CHAR(TO_DATE(a.fecha, 'DD-MM-RRRR'),'RRRR-MM-DD') as fecha from cheques a
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


        public function crearCheque($numero, $fecha, $tot, $cuen, $id_banco, $id_proveedor, $id_usuario, $nombre, $lugar){
            $this->db->query("INSERT INTO cheques (numero, fecha, total, cuentas_bancarias, id_banco, id_proveedor, id_usuario, nombre, lugar)VALUES (:numero, TO_CHAR(TO_DATE(:fecha , 'RRRR-MM-DD'),'DD-MON-RRRR'), :tot, :cuen, :id_banco, :id_proveedor, :id_usuario, :nombre, :lug)");
            //$this->db->query('COMMIT');
            $this->db->bind(':numero', $numero);
            $this->db->bind(':lug', $lugar);
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
            
            $this->db->query("UPDATE cheques SET fecha = TO_CHAR(TO_DATE(:fec , 'RRRR-MM-DD'),'DD-MON-RRRR'), total = :tot, cuentas_bancarias = :cuen, id_banco = :banco, id_proveedor = :proveedor, nombre = :nom, estado = 'Creado' WHERE numero = :num");
            //$this->db->query('COMMIT');
            $this->db->bind(':num', $numero);
            $this->db->bind(':fec', $fecha);
            $this->db->bind(':tot', $tot);
            //$this->db->bind(':referencia', $referencia);
            $this->db->bind(':cuen', $cuen);
            $this->db->bind(':banco', $id_banco);
            $this->db->bind(':proveedor', $id_proveedor);
            $this->db->bind(':usuario', $id_usuario);
            $this->db->bind(':nom', $nombre);
            return $this->db->execute();
            //return 'hola';
        }

        public function liberarAuditoria($id){
            $this->db->query("INSERT INTO autorizaciones_auditoria 
            SELECT numero, cuentas_bancarias, id_banco, :usuario, TO_CHAR(TO_DATE(:fecha , 'RRRR-MM-DD HH:MI:SS'),'DD-MON-RRRR HH:MI:SS'),  (SELECT (nvl(max(id_autorizacion),0)+1) FROM autorizaciones_auditoria) FROM cheques WHERE numero = :id");
            $this->db->bind(':id', $id);
            $this->db->bind(':usuario', $_SESSION['id_usuario']);
            $this->db->bind(':fecha', date("Y").'-'.date("m").'-'.date("d").' '.date("h").':'.date("i").':'.date("s"));
            return $this->db->execute();
        }

        public function liberarGerencia($id){
            $this->db->query("INSERT INTO autorizaciones_gerencia
            SELECT numero, cuentas_bancarias, id_banco, :usuario, TO_CHAR(TO_DATE(:fecha , 'RRRR-MM-DD HH:MI:SS'),'DD-MON-RRRR HH:MI:SS'),  (SELECT (nvl(max(id_autorizacion),0)+1) FROM autorizaciones_gerencia) FROM cheques WHERE numero = :id");
            $this->db->bind(':id', $id);
            $this->db->bind(':usuario', $_SESSION['id_usuario']);
            $this->db->bind(':fecha', date("Y").'-'.date("m").'-'.date("d").' '.date("h").':'.date("i").':'.date("s"));
            return $this->db->execute();
        }

        public function chequeImpreso($id){
            $this->db->query("INSERT INTO impresiones
            SELECT numero, cuentas_bancarias, id_banco, TO_CHAR(TO_DATE(:fecha, 'RRRR-MM-DD HH:MI:SS'),'DD-MON-RRRR HH:MI:SS'), :usuario, (SELECT (nvl(max(id_impresion),0)+1) FROM impresiones) FROM cheques WHERE numero = :id");
            $this->db->bind(':id', $id);
            $this->db->bind(':usuario', $_SESSION['id_usuario']);
            $this->db->bind(':fecha', date("Y").'-'.date("m").'-'.date("d").' '.date("h").':'.date("i").':'.date("s"));
            return $this->db->execute();
        }

        public function correcciones($id, $cambios){
            $this->db->query("INSERT INTO correcciones
            SELECT (SELECT (nvl(max(id_correccion),0)+1) FROM correcciones), TO_CHAR(TO_DATE(:fecha , 'RRRR-MM-DD HH:MI:SS'),'DD-MON-RRRR HH:MI:SS'), :cambios, :id, cuentas_bancarias, id_banco, :usuario FROM cheques WHERE numero = :id");
            $this->db->bind(':id', $id);
            $this->db->bind(':usuario', $_SESSION['id_usuario']);
            $this->db->bind(':fecha', date("Y").'-'.date("m").'-'.date("d").' '.date("h").':'.date("i").':'.date("s"));
            $this->db->bind(':cambios', $cambios);
            return $this->db->execute();
        }

        public function actualizarEstado($id, $std){
            $this->db->query("UPDATE cheques SET estado = :std WHERE numero = :id");
            $this->db->bind(':id', $id);
            $this->db->bind(':std', $std);
            return $this->db->execute();
        }
	}
 ?>
