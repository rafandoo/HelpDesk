<?php
    class nivelAcesso {

        private $id;
        private $nome;

        public function __construct($id, $nome) {
            $this->id = $id;
            $this->nome = $nome;
        }

        public function getId() {
            return $this->id;
        }

        public function getNome() {
            return $this->nome;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function __toString() {
            return "[Nivel de Acesso] Id: ".$this->id." | ".
            "Nome: ".$this->nome;
        }
    }
?>