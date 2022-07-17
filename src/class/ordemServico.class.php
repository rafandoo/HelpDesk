<?php
    /* A class that represents an order of service. */
    class ordemServico {
        
        private $idOrdemServico;
        private $valor;
        private $descricao;
        private $idTicket;

        public function __construct($idOrdemServico, $valor, $descricao,$idTicket) {
            $this->idOrdemServico = $idOrdemServico;
            $this->valor = $valor;
            $this->descricao = $descricao;
            $this->idTicket = $idTicket;
        }

        public function getIdOrdemServico() {
            return $this->idOrdemServico;
        }

        public function getValor() {
            return $this->valor;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getIdTicket() {
            return $this->idTicket;
        }

        public function setIdOrdemServico($idOrdemServico) {
            $this->idOrdemServico = $idOrdemServico;
        }

        public function setValor($valor) {
            $this->valor = $valor;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        public function setIdTicket($idTicket) {
            $this->idTicket = $idTicket;
        }

        public function __toString() {
            return "[Ordem de Serviço] Id Ordem Servico: ".$this->idOrdemServico." | ".
            "Valor: ".$this->valor." | ".
            "Descricao: ".$this->descricao." | ".
            "Id Ticket: ".$this->idTicket;
        }
    }
?>