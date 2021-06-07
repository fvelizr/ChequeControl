<?php 
	class BitacorasMdl{
		private $db;

		public function __construct($config){
			$this->db = new Database($config);
		}

        public function obtenerBitacoraCheque(){
            $this->db->query("SELECT * FROM ((SELECT a.cheques_numero AS cheque, a.cuentas_bancarias AS cuenta, c.nombre AS banco, d.nombre_usuario AS usuario, a.fecha_hora AS fecha, 'AUDITORIA' AS descripcion FROM autorizaciones_auditoria a
            LEFT JOIN cheques b ON b.numero = a.cheques_numero
            LEFT JOIN bancos c ON c.id_banco = a.id_banco
            LEFT JOIN usuarios d ON d.id_usuario = a.id_usuario)
            UNION ALL
            (SELECT a.cheques_numero AS cheque, a.cuentas_bancarias AS cuenta, c.nombre AS banco, d.nombre_usuario AS usuario, a.fecha_hora AS fecha, 'GERENCIA' AS descripcion FROM autorizaciones_gerencia a
            LEFT JOIN cheques b ON b.numero = a.cheques_numero
            LEFT JOIN bancos c ON c.id_banco = a.id_banco
            LEFT JOIN usuarios d ON d.id_usuario = a.id_usuario)
            UNION ALL
            (SELECT a.cheques_numero AS cheque, a.cuentas_bancarias AS cuenta, c.nombre AS banco, d.nombre_usuario AS usuario, a.fecha_hora AS fecha, 'IMPRESION' AS descripcion FROM impresiones a
            LEFT JOIN cheques b ON b.numero = a.cheques_numero
            LEFT JOIN bancos c ON c.id_banco = a.id_banco
            LEFT JOIN usuarios d ON d.id_usuario = a.id_usuario)
            UNION ALL
            (SELECT a.cheques_numero AS cheque, a.cuentas_bancarias AS cuenta, c.nombre AS banco, d.nombre_usuario AS usuario, a.fecha_hora AS fecha, 'ENTREGA' AS descripcion FROM entregas a
            LEFT JOIN cheques b ON b.numero = a.cheques_numero
            LEFT JOIN bancos c ON c.id_banco = a.id_banco
            LEFT JOIN usuarios d ON d.id_usuario = a.id_usuario)
            UNION ALL
            (SELECT a.cheques_numero AS cheque, a.cuentas_bancarias AS cuenta, c.nombre AS banco, d.nombre_usuario AS usuario, a.fecha_hora AS fecha, a.descripcion AS descripcion FROM correcciones a
            LEFT JOIN cheques b ON b.numero = a.cheques_numero
            LEFT JOIN bancos c ON c.id_banco = a.id_banco
            LEFT JOIN usuarios d ON d.id_usuario = a.id_usuario))
            ORDER BY cheque, fecha");
            return $this->db->resultSet();
        }
	}
 ?>
