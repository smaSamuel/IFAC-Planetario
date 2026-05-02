<?php

    //Classe Usuario
    class Usuario {
        private $_nome;
        private $_email;
        private $_telefone;

        //Método __construct()
        public function __construct($nome, $email, $telefone) {
            $this->SetNome              ($nome);
            $this->SetEmail             ($email);
            $this->SetTelefone          ($telefone);
        }//Fim do método

        //Método __destruct()
        public function __destruct() {  }
        //Fim método __destruct()

        //Método SetNome()
        protected function SetNome($nome) {
            if (is_string($nome) && strlen($nome) > 0 && strlen($nome) < 255) {
                $this->_nome = $nome;
            } else {
                throw new \InvalidArgumentException("Nome inválido!"); // Devolver erro
            }
        }//Fim do método SetNome()

        //Método SetEMail()
        protected function SetEmail($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->_email = $email;
            } else {
                throw new \InvalidArgumentException("Email inválido!"); // Devolver erro
            }
        }//Fim do método

        //Método SetTelefone()
        protected function SetTelefone($telefone) {
            $telefone= str_replace(['(', ')', '-', ' ', '/'], '', $telefone);

            $valTel = '/^[1-9]{2}(9[0-9]{8}|[2-8][0-9]{7})$/';

            if (preg_match($valTel, $telefone)) {
                $this->_telefone = $telefone;
            } else {
                throw new \InvalidArgumentException("Número de telefone inválido"); // Devolver erro
            }
        }//Fim do método SetTelefone()

        //Método GetNome()
        public function GetNome() { 
            return $this->_nome;
        }//Fim do método GetNome()

        //Método GetEmail()
        public function GetEmail() {
            return $this->_email;
        }//Fim do método GetEmail
    
        //Método GetTelefone()
        public function GetTelefone() {
            return $this->_telefone;
        }//Fim do método GetTelefone()

        
    }