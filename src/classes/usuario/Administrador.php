<?php

namespace web\classes\usuario {
    use web\utils\SetCpf;
    use web\utils\SetIdade;

    class Administrador {
        private $_nome;
        private $_telefone;
        private $_idade;
        private $_dataNascimento;
        private $_email;
        private $_cpf;
        private $_senha;

        //Metodo __construct()
        function __construct($nome, $telefone, $email, $cpf, $dataNascimento, $senha) {
            $this->setNome          ($nome);
            $this->setTelefone      ($telefone);
            $this->SetIdade         ($dataNascimento); //Seta tanto a idade tanto a data de nascimento
            $this->setEmail         ($email);
            $this->setCPF           ($cpf);
            $this->setSenha         ($senha);
        }
        //Fim metodo __construct()

        //Metodo setNome()
        public function setNome($nome) {
            if (is_string($nome) && strlen($nome) > 0) {
                $this->_nome = $nome;
            }
        }
        //Fim metodo setNome()

        //Metodo SetIdade()
        protected function setIdade($dataNascimento) {
            try {
                $this->_idade = SetIdade::CalcularIdade($dataNascimento);
                $this->_dataNascimento = SetIdade::FormartarDataNascimento($dataNascimento);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            } catch (\Exception $e) {
                throw new \RuntimeException("Tivemos um pequeno problema, tente novamente.");
            }
        }//Fim metodo SetIdade()  

        //Método SetSenha() 
        public function setSenha($senha) {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $this->_senha = $senhaHash;
        }//Fim do método setSenha()

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
            try {
                $this->_cpf = SetCpf::verificarValidade($cpf);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            } catch (\RuntimeException $e) {
                throw new \RuntimeException("Tivemos um pequeno problema, tente novamente.");
            }
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
        //Metodo getDataNascimento()
        public function getDataNascimento(){
            return $this->_dataNascimento;
        }
        //Fim metodo getDataNascimento()
        //Metodo getIdade()
        public function getIdade(){
            return $this->_idade;
        }
        //Fim metodo getIdade()
        //Metodo getSenha()
        public function getSenha(){
            return $this->_senha;
        }
        //Fim metodo getSenha()

        //Metodo __destruct()
        function __destruct() { }    
    }
}