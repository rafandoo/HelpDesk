<?php
    class tramite {

        private $idTramite;
        private $horaInicial;
        private $horaFinal;
        private $descricao;
        private $idTicket;
        private $usuario;

        public function __construct($idTramite, $horaInicial, $horaFinal, $descricao, $idTicket, $usuario) {
            $this->idTramite = $idTramite;
            $this->horaInicial = $horaInicial;
            $this->horaFinal = $horaFinal;
            $this->descricao = $descricao;
            $this->idTicket = $idTicket;
            $this->usuario = $usuario;
        }

        public function getIdTramite() {
            return $this->idTramite;
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
            "Hora Inicial: ".$this->horaInicial." | ".
            "Hora Final: ".$this->horaFinal." | ".
            "Descrição: ".$this->descricao." | ".
            "Id Ticket: ".$this->idTicket." | ".
            "Usuario: ".$this->usuario;
        }
    }

?>