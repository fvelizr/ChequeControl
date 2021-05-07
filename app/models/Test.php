<?php 
	class Test{
		private $db;

        public function __construct($config){
			$this->db = new Database($config);
		}

        public function obtener(){

        }
    }
?>