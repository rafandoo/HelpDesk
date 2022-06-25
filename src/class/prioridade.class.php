<?php
    class prioridade {
        private $id;
        private $descricao;
        
        public function __construct($id, $descricao) {
            $this->id = $id;
            $this->descricao = $descricao;
        }
        
        public function getId() {
            return $this->id;
        }
        
        public function getDescricao() {
            return $this->descricao;
        }
        
        public function setId($id) {
            $this->id = $id;
        }
        
        public function setDescricao($descricao) {
            if (strlen($descricao) > 0) {
                $this->descricao = $descricao;
            } else {
                throw new Exception("Descrição não pode ser vazia.");
            }
        }
        
        public function __toString() {
            return "[Prioridade] Id: ".$this->id." | ".
            "Descrição: ".$this->descricao;
        }   
    }
?>