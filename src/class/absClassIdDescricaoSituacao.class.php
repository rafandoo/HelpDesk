<?php
    /* An abstract class that has an id, description and status. */
    abstract class absClassIdDescricaoSituacao {
        
        protected $id;
        protected $descricao;
        protected $situacao;
        
        public function __construct($id, $descricao, $situacao) {
            $this->id = $id;
            $this->descricao = $descricao;
            $this->situacao = $situacao;
        }
        
        public function getId() {
            return $this->id;
        }
        
        public function getDescricao() {
            return $this->descricao;
        }
        
        public function getSituacao() {
            return $this->situacao;
        }
        
        public function setId($id) {
            $this->id = $id;
        }
        
        public function setDescricao($descricao) {
            if (strlen($descricao) > 0) {
                $this->descricao = $descricao;
            } else {
                throw new Exception("Descrição não pode ser vazia.");
            }
        }
        
        public function setSituacao($situacao) {
            $this->situacao = $situacao;
        }
        
        public function getStrSituacao() {
            if ($this->situacao == 1) {
                return "Ativo";
            } else {
                return "Inativo";
            }
        }

        public function __toString() {
            return "[Classe] Id: ".$this->id." | ".
            "Descrição: ".$this->descricao." | ".
            "Situação: ".$this->situacao;
        }
    }
?>