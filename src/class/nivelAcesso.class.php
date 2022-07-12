<?php
/* It's a class that represents a level of access. */
    class nivelAcesso {

        private $idNivelAcesso;
        private $nome;

        public function __construct($idNivelAcesso, $nome) {
            $this->idNivelAcesso = $idNivelAcesso;
            $this->nome = $nome;
        }

        public function getIdNivelAcesso() {
            return $this->idNivelAcesso;
        }

        public function getNome() {
            return $this->nome;
        }

        public function setIdNivelAcesso($idNivelAcesso) {
            $this->idNivelAcesso = $idNivelAcesso;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function __toString() {
            return "[Nivel de Acesso] IdNivelAcesso: ".$this->idNivelAcesso." | ".
            "Nome: ".$this->nome;
        }
    }
?>