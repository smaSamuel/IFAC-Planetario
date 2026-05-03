<?php

namespace web\classes\usuario {

    class Administrador {
        private $_nome;
        private $_telefone;
        private $_email;
        private $_cpf;

        //Metodo __construct()
        function __construct($nome, $telefone, $email, $cpf) {
            $this->setNome          ($nome);
            $this->setTelefone      ($telefone);
            $this->setEmail         ($email);
            $this->setCPF           ($cpf);
        }
        //Fim metodo __construct()

        //Metodo setNome()
        public function setNome($nome) {
            if (is_string($nome) && strlen($nome) > 0) {
                $this->_nome = $nome;
            }
        }
        //Fim metodo setNome()
        //Metodo setTelefone()
        public function setTelefone($telefone) {
            $telefone= str_replace(['(', ')', '-', ' ', '/'], '', $telefone);

            $valTel = '/^[1-9]{2}(9[0-9]{8}|[2-8][0-9]{7})$/';

            if (preg_match($valTel, $telefone)) {
                $this->_telefone = $telefone;
            } else {
                throw new \InvalidArgumentException("Número de telefone inválido: $telefone");
            }
        }
        //Fim metodo setTelefone()
        //Metodo setEmail()
        public function setEmail($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->_email = $email;
            }
        }
        //Fim metodo setEmail()
        //Metodo setCPF()
        public function setCPF($cpf) {
            $cpf = str_replace(['-', '.'], '', $cpf);

            // verificar se foi informado o numero exato de digitos
            if (strlen($cpf) != 11) { throw new \InvalidArgumentException("CPF inválido: $cpf"); }
        
            // verificar se foi informado uma sequencia de digitos iguais, 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) { throw new \InvalidArgumentException("CPF inválido: $cpf"); }

            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    throw new \InvalidArgumentException("CPF inválido: $cpf"); 
                }
            }
            
            $this->_cpf = $cpf;
        }
        //Fim metodo setCPF()
    
        //Metodo getNome()
        public function getNome(){
            return $this->_nome;
        }
        //Fim metodo getNome()
        //Metodo getTelefone()
        public function getTelefone(){
            return $this->_telefone;
        }
        //Fim metodo getTelefone()
        //Metodo getEmail()
        public function getEmail(){
            return $this->_email;
        }
        //Fim metodo getEmail()
        //Metodo getCPF()
        public function getCPF(){
            return $this->_cpf;
        }
        //Fim metodo getCPF()
    
        //Metodo __destruct()
        function __destruct() { }    
    }

    $ad = new Administrador("Rodrigo", '(32) 2463-2512', "eimi2506@uorak.com", '204.887.487-80');

}