<?php
    class ordemServico {
        private $id;
        private $valor;
        private $idTicket;

        public function __construct($id, $valor, $idTicket) {
            $this->id = $id;
            $this->valor = $valor;
            $this->idTicket = $idTicket;
        }

        public function getId() {
            return $this->id;
        }

        public function getValor() {
            return $this->valor;
        }

        public function getIdChamado() {
            return $this->idTicket;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setValor($valor) {
            $this->valor = $valor;
        }

        public function setIdChamado($idTicket) {
            $this->idTicket = $idTicket;
        }

        public function __toString() {
            return "[Ordem de Serviço] Id: ".$this->id." | ".
            "Valor: ".$this->valor." | ".
            "Id Ticket: ".$this->idTicket;
        }
    }
?>