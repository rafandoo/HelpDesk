<?php
    class ticket {
        private $idTicket;
        private $titulo;
        private $descricao;
        private $dataAbertura;
        private $dataAtualizacao;
        private $dataFinalizacao;
        private $categoria;
        private $prioridade;
        private $status;
        private $setor;
        private $cliente;
        private $usuario;   

        public function __construct($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $usuario) {
            $this->idTicket = $idTicket;
            $this->titulo = $titulo;
            $this->descricao = $descricao;
            $this->dataAbertura = $dataAbertura;
            $this->dataAtualizacao = $dataAtualizacao;
            $this->dataFinalizacao = $dataFinalizacao;
            $this->categoria = $categoria;
            $this->prioridade = $prioridade;
            $this->status = $status;
            $this->setor = $setor;
            $this->cliente = $cliente;
            $this->usuario = $usuario;
        }

        public function getIdTicket() {
            return $this->idTicket;
        }

        public function getTitulo() {
            return $this->titulo;
        }

        public function getDescricao() {
            return $this->descricao;
        }

        public function getDataAbertura() {
            return $this->dataAbertura;
        }

        public function getDataAtualizacao() {
            return $this->dataAtualizacao;
        }

        public function getDataFinalizacao() {
            return $this->dataFinalizacao;
        }

        public function getCategoria() {
            return $this->categoria;
        }

        public function getPrioridade() {
            return $this->prioridade;
        }

        public function getStatus() {
            return $this->status;
        }

        public function getSetor() {
            return $this->setor;
        }

        public function getCliente() {
            return $this->cliente;
        }

        public function getUsuario() {
            return $this->usuario;
        }

        public function setIdTicket($idTicket) {
            $this->idTicket = $idTicket;
        }

        public function setTitulo($titulo) {
            if (strlen($titulo) > 0) {
                $this->titulo = $titulo;
            } else {
                throw new Exception("Título não pode ser vazio.");
            }
        }

        public function setDescricao($descricao) {
            if (strlen($descricao) > 0) {
                $this->descricao = $descricao;
            } else {
                throw new Exception("Descrição não pode ser vazia.");
            }
        }

        public function setDataAbertura($dataAbertura) {
            $this->dataAbertura = $dataAbertura;
        }

        public function setDataAtualizacao($dataAtualizacao) {
            $this->dataAtualizacao = $dataAtualizacao;
        }

        public function setDataFinalizacao($dataFinalizacao) {
            $this->dataFinalizacao = $dataFinalizacao;
        }

        public function setCategoria($categoria) {
            $this->categoria = $categoria;
        }

        public function setPrioridade($prioridade) {
            $this->prioridade = $prioridade;
        }

        public function setStatus($status) {
            $this->status = $status;
        }

        public function setSetor($setor) {
            $this->setor = $setor;
        }

        public function setCliente($cliente) {
            $this->cliente = $cliente;
        }

        public function setUsuario($usuario) {
            $this->usuario = $usuario;
        }

        public function __toString() {
            return "[Ticket] Id Ticket: ".$this->idTicket." | ".
            "Título: ".$this->titulo." | ".
            "Descrição: ".$this->descricao." | ".
            "Data de Abertura: ".$this->dataAbertura." | ".
            "Data de Atualização: ".$this->dataAtualizacao." | ".
            "Data de Finalização: ".$this->dataFinalizacao." | ".
            "Categoria: ".$this->categoria." | ".
            "Prioridade: ".$this->prioridade." | ".
            "Status: ".$this->status." | ".
            "Setor: ".$this->setor." | ".
            "Cliente: ".$this->cliente." | ".
            "Usuário: ".$this->usuario;
        }
    }
?>