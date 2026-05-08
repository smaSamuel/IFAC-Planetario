<?php

namespace web\classes\usuario {
    use DateTime;

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
            $this->SetIdade         ($dataNascimento);
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
            $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);
            $dataNascimentoDB = $dataNascimentoObj->format('Y-m-d');
            $dataAtual = new DateTime();
            $idade = $dataAtual->diff($dataNascimentoObj);
            $idade = $idade->y;
            
            if($idade > 17 && $idade < 120) {
                $this->_idade = $idade;
                $this->_dataNascimento = $dataNascimentoDB;
            } else {
                //throw new \InvalidArgumentException('Voce nao tem a idade minima para se registrar nesse site!');
                return false;    
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
            $cpf = str_replace(['-', '.'], '', $cpf);

            // verificar se foi informado o numero exato de digitos
            if (strlen($cpf) != 11) { return false; }
        
            // verificar se foi informado uma sequencia de digitos iguais, 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf))  { return false; }

            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    //throw new \InvalidArgumentException("CPF inválido: $cpf"); 
                    return false;    
                }
            }
            
            $this->_cpf = hash_hmac('sha256', $cpf, getenv('HASH_SECRET_KEY'));
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