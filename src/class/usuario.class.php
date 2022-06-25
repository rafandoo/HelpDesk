<?php
    class usuario {
        
        private $id;
        private $nome;
        private $sobrenome;
        private $email;
        private $login;
        private $senha;
        private $nivelAcesso;
        private $setor;
        private $situacao;

        public function __construct($id, $nome, $sobrenome, $email, $login, $senha, $nivelAcesso, $setor, $situacao) {
            $this->id = $id;
            $this->nome = $nome;
            $this->sobrenome = $sobrenome;
            $this->email = $email;
            $this->login = $login;
            $this->senha = $senha;
            $this->nivelAcesso = $nivelAcesso;
            $this->setor = $setor;
            $this->situacao = $situacao;
        }

        public function getId() {
            return $this->id;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getSobrenome() {
            return $this->sobrenome;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getLogin() {
            return $this->login;
        }

        public function getSenha() {
            return $this->senha;
        }

        public function getNivelAcesso() {
            return $this->nivelAcesso;
        }

        public function getSetor() {
            return $this->setor;
        }

        public function getSituacao() {
            return $this->situacao;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setNome($nome) {
            if (strlen($nome) > 0) {
                $this->nome = $nome;
            }
        }

        public function setSobrenome($sobrenome) {
            $this->sobrenome = $sobrenome;
        }

        public function setEmail($email) {
            if (strlen($email) > 0) {
                $this->email = $email;
            }
        }

        public function setLogin($login) {
            if (strlen($login) > 0) {
                $this->login = $login;
            }
        }

        public function setSenha($senha) {
            if (strlen($senha) > 0) {
                $this->senha = $senha;
            }
        }

        public function setNivelAcesso($nivelAcesso) {
            $this->nivelAcesso = $nivelAcesso;
        }

        public function setSetor($setor) {
            $this->setor = $setor;
        }

        public function setSituacao($situacao) {
            $this->situacao = $situacao;
        }

        public function __toString() {
            return "[Usuário] Id: ".$this->id." | ".
            "Nome: ".$this->nome." | ".
            "Sobrenome: ".$this->sobrenome." | ".
            "Email: ".$this->email." | ".
            "Login: ".$this->login." | ".
            "Senha: ".$this->senha." | ".
            "NivelAcesso: ".$this->nivelAcesso." | ".
            "Setor: ".$this->setor." | ".
            "Situacao: ".$this->situacao;
        }
    }
?>