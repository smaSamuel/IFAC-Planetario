<?php

namespace web\classes\usuario {
    //Classe Usuario
    class Usuario
    {
        private $nome;
        private $email;
        private $telefone;
        private $senha;

        //Método __construct()
        public function __construct($nome, $email, $telefone, $senha)
        {
            $this->SetNome($nome);
            $this->SetEmail($email);
            $this->SetTelefone($telefone);
            $this->SetSenha($senha);
        } //Fim do método

        //Método __destruct()
        public function __destruct() {}
        //Fim método __destruct()

        //Método SetNome()
        protected function SetNome($nome)
        {
            $this->nome = $nome;
        } //Fim do método SetNome()

        //Método SetEMail()
        protected function SetEmail($email)
        {
            $this->email = $email;
        } //Fim do método

        //Método SetTelefone()
        protected function SetTelefone($telefone)
        {
            $telefone = str_replace(['(', ')', '-', ' ', '/'], '', $telefone);

            $valTel = '/^[1-9]{2}(9[0-9]{8}|[2-8][0-9]{7})$/';

            if (preg_match($valTel, $telefone)) {
                $this->telefone = $telefone;
            } else {
                throw new \InvalidArgumentException("Número de telefone inválido"); // Devolver erro
            }
        } //Fim do método SetTelefone()

        //Método SetSenha()
        public function SetSenha($senha) {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $this->senha = $senhaHash;
        }//Fim do método SetSenha()

        //Método GetNome()
        public function GetNome()
        {
            return $this->nome;
        } //Fim do método GetNome()

        //Método GetEmail()
        public function GetEmail()
        {
            return $this->email;
        } //Fim do método GetEmail

        //Método GetTelefone()
        public function GetTelefone()
        {
            return $this->telefone;
        } //Fim do método GetTelefone()

        //Método GetSenha()
        public function GetSenha() {
            return $this->senha;
        }//Fim do método GetSenha()

    }
}
