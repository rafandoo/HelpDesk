<?php
    class tramite {

        private $id;
        private $horaInicial;
        private $horaFinal;
        private $descricao;
        private $idTicket;
        private $usuario;

        public function __construct($id, $horaInicial, $horaFinal, $descricao, $idTicket, $usuario) {
            $this->id = $id;
            $this->horaInicial = $horaInicial;
            $this->horaFinal = $horaFinal;
            $this->descricao = $descricao;
            $this->idTicket = $idTicket;
            $this->usuario = $usuario;
        }

        public function getId() {
            return $this->id;
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

        public function setId($id) {
            $this->id = $id;
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
            return "[Tramite] Id: ".$this->id." | ".
            "Hora Inicial: ".$this->horaInicial." | ".
            "Hora Final: ".$this->horaFinal." | ".
            "Descrição: ".$this->descricao." | ".
            "Id Ticket: ".$this->idTicket." | ".
            "Usuario: ".$this->usuario;
        }
    }

?>