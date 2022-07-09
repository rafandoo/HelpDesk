<?php
    class cliente {

        private $idCliente;
        private $nome;
        private $nomeFantasia;
        private $cpfCnpj;
        private $endereco;
        private $numero;
        private $bairro;
        private $cidade;
        private $email;
        private $telefone;
        private $observacoes;
        private $usuario;
        private $situacao;

        public function __construct($idCliente, $nome, $nomeFantasia, $cpfCnpj, $endereco, $numero, $bairro, $cidade, $email, $telefone, $observacoes, $usuario, $situacao) {
            $this->idCliente = $idCliente;
            $this->nome = $nome;
            $this->nomeFantasia = $nomeFantasia;
            $this->cpfCnpj = $cpfCnpj;
            $this->endereco = $endereco;
            $this->numero = $numero;
            $this->bairro = $bairro;
            $this->cidade = $cidade;
            $this->email = $email;
            $this->telefone = $telefone;
            $this->observacoes = $observacoes;
            $this->usuario = $usuario;
            $this->situacao = $situacao;
        }

        public function getIdCliente() {
            return $this->idCliente;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getNomeFantasia() {
            return $this->nomeFantasia;
        }

        public function getCpfCnpj() {
            return $this->cpfCnpj;
        }

        public function getEndereco() {
            return $this->endereco;
        }

        public function getNumero() {
            return $this->numero;
        }

        public function getBairro() {
            return $this->bairro;
        }

        public function getCidade() {
            return $this->cidade;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getTelefone() {
            return $this->telefone;
        }

        public function getObservacoes() {
            return $this->observacoes;
        }

        public function getUsuario() {
            return $this->usuario;
        }

        public function getSituacao() {
            return $this->situacao;
        }

        public function setIdCliente($idCliente) {
            if ($idCliente >= 0) {
                $this->idCliente = $idCliente;
            }
        }

        public function setNome($nome) {
            if (strlen($nome) > 0) {
                $this->nome = $nome;
            }
        }

        public function setNomeFantasia($nomeFantasia) {
            $this->nomeFantasia = $nomeFantasia;
        }

        public function setCpfCnpj($cpfCnpj) {
            if (strlen($cpfCnpj) > 0) {
                $this->cpfCnpj = $cpfCnpj;
            }
        }

        public function setEndereco($endereco) {
            if (strlen($endereco) > 0) {
                $this->endereco = $endereco;
            }
        }

        public function setNumero($numero) {
            if (strlen($numero) > 0) {
                $this->numero = $numero;
            }
        }

        public function setBairro($bairro) {
            if (strlen($bairro) > 0) {
                $this->bairro = $bairro;
            }
        }

        public function setCidade($cidade) {
            if (strlen($cidade) > 0) {
                $this->cidade = $cidade;
            }
        }

        public function setEmail($email) {
            if (strlen($email) > 0) {
                $this->email = $email;
            }
        }

        public function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        public function setObservacoes($observacoes) {
            $this->observacoes = $observacoes;
            
        }

        public function setUsuario($usuario) {
            $this->usuario = $usuario;
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
            return "[Cliente] ID Cliente: ".$this->idCliente." | ".
            "Nome: ".$this->nome." | ".
            "Nome Fantasia: ".$this->nomeFantasia." | ".
            "CPF/CNPJ: ".$this->cpfCnpj." | ".
            "Endereço: ".$this->endereco." | ".
            "Número: ".$this->numero." | ".
            "Bairro: ".$this->bairro." | ".
            "Cidade: ".$this->cidade." | ".
            "Email: ".$this->email." | ".
            "Telefone: ".$this->telefone." | ".
            "Observações: ".$this->observacoes." | ".
            "Usuário: ".$this->usuario." | ".
            "Situacao: ".$this->situacao;
        }
    }
?>