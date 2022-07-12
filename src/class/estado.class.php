<?php

    class estado
    {
        private $idEstado;
        private $nome;
        private $sigla;

        public function __construct($idEstado, $nome, $sigla)
        {
            $this->idEstado = $idEstado;
            $this->nome = $nome;
            $this->sigla = $sigla;
        }

        public function getIdEstado()
        {
            return $this->idEstado;
        }

        public function getNome()
        {
            return $this->nome;
        }

        public function getSigla()
        {
            return $this->sigla;
        }

        public function setIdEstado($idEstado)
        {
            $this->idEstado = $idEstado;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;
        }

        public function setSigla($sigla)
        {
            $this->sigla = $sigla;
        }

        public function __toString()
        {
            return "[Estado] Id Estado: ".$this->idEstado." | ".
            "Nome: ".$this->nome." | ".
            "Sigla: ".$this->sigla;
        }
    }
