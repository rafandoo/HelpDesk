<?php
    /* It's a class that represents a tramite. */
    class tramite {

        private $idTramite;
        private $data;
        private $horaInicial;
        private $horaFinal;
        private $descricao;
        private $idTicket;
        private $usuario;

        public function __construct($idTramite, $data, $horaInicial, $horaFinal, $descricao, $idTicket, $usuario) {
            $this->idTramite = $idTramite;
            $this->data = $data;
            $this->horaInicial = $horaInicial;
            $this->horaFinal = $horaFinal;
            $this->descricao = $descricao;
            $this->idTicket = $idTicket;
            $this->usuario = $usuario;
        }

        public function getIdTramite() {
            return $this->idTramite;
        }

        public function getData() {
            return $this->data;
        }

        public function getHoraInicial() {
            return $this->horaInicial;
        }

        public function getHoraFinal() {
            return $this->horaFinal;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getIdTicket() {
            return $this->idTicket;
        }

        public function getUsuario() {
            return $this->usuario;
        }

        public function setIdTramite($idTramite) {
            $this->idTramite = $idTramite;
        }

        public function setData($data) {
            $this->data = $data;
        }

        public function setHoraInicial($horaInicial) {
            $this->horaInicial = $horaInicial;
        }

        public function setHoraFinal($horaFinal) {
            $this->horaFinal = $horaFinal;
        }

        public function setDescricao($descricao) {
            if (strlen($descricao) > 0) {
                $this->descricao = $descricao;
            } else {
                throw new Exception("Descrição não pode ser vazia.");
            }
        }

        public function setIdTicket($idTicket) {
            $this->idTicket = $idTicket;
        }

        public function setUsuario($usuario) {
            $this->usuario = $usuario;
        }

        public function __toString() {
            return "[Tramite] Id Tramite: ".$this->idTramite." | ".
            "Data: ".$this->data." | ".
            "Hora Inicial: ".$this->horaInicial." | ".
            "Hora Final: ".$this->horaFinal." | ".
            "Descrição: ".$this->descricao." | ".
            "Id Ticket: ".$this->idTicket." | ".
            "Usuario: ".$this->usuario;
        }
    }
?>