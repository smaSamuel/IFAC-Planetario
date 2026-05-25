<?php

namespace web\classes\usuario {
    //Classe Usuario
    class Usuario
    {
        private $nome;
        private $email;
        private $senha;

        //Método __construct()
        public function __construct($nome, $email, $senha)
        {
            $this->SetNome($nome);
            $this->SetEmail($email);
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

        //Método GetSenha()
        public function GetSenha() {
            return $this->senha;
        }//Fim do método GetSenha()

    }
}
