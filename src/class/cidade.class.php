<?php
    class cidade {
        
        private $idCidade;
        private $nome;
        private $idEstado;

        public function __construct($idCidade, $nome, $idEstado) {
            $this->idCidade = $idCidade;
            $this->nome = $nome;
            $this->idEstado = $idEstado;
        }

        public function getIdCidade() {
            return $this->idCidade;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getIdEstado() {
            return $this->idEstado;
        }

        public function setIdCidade($idCidade) {
            $this->idCidade = $idCidade;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setIdEstado($idEstado) {
            $this->idEstado = $idEstado;
        }

        public function __toString() {
            return "[Cidade] Id Cidade: ".$this->idCidade." | ".
            "Nome: ".$this->nome." | ".
            "Id Estado: ".$this->idEstado;
        }
    }
?>