<?php

    /* A class that represents an order of service. */
    class ordemServico
    {
        private $idOrdemServico;
        private $valor;
        private $idTicket;

        public function __construct($idOrdemServico, $valor, $idTicket)
        {
            $this->idOrdemServico = $idOrdemServico;
            $this->valor = $valor;
            $this->idTicket = $idTicket;
        }

        public function getIdOrdemServico()
        {
            return $this->idOrdemServico;
        }

        public function getValor()
        {
            return $this->valor;
        }

        public function getIdChamado()
        {
            return $this->idTicket;
        }

        public function setIdOrdemServico($idOrdemServico)
        {
            $this->idOrdemServico = $idOrdemServico;
        }

        public function setValor($valor)
        {
            $this->valor = $valor;
        }

        public function setIdChamado($idTicket)
        {
            $this->idTicket = $idTicket;
        }

        public function __toString()
        {
            return "[Ordem de Serviço] Id Ordem Servico: ".$this->idOrdemServico." | ".
            "Valor: ".$this->valor." | ".
            "Id Ticket: ".$this->idTicket;
        }
    }
