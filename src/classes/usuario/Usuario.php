<?php

namespace web\classes\usuario {

    use web\classes\agendamento\ReservaEspaco;

    //Classe Usuario
    class Usuario {
        private $_nome;
        private $_email;
        private $_telefone;
        private array $_espacosReservados = [];

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
                //throw new \InvalidArgumentException("Nome inválido!"); // Devolver erro
                return false;    
            }
        }//Fim do método SetNome()

        //Método SetEMail()
        protected function SetEmail($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->_email = $email;
            } else {
                //throw new \InvalidArgumentException("Email inválido!"); // Devolver erro
                return false;    
            }
        }//Fim do método

        //Método SetTelefone()
        protected function SetTelefone($telefone) {
            $telefone= str_replace(['(', ')', '-', ' ', '/'], '', $telefone);

            $valTel = '/^[1-9]{2}(9[0-9]{8}|[2-8][0-9]{7})$/';

            if (preg_match($valTel, $telefone)) {
                $this->_telefone = $telefone;
            } else {
                //throw new \InvalidArgumentException("Número de telefone inválido"); // Devolver erro
                return false;    
            }
        }//Fim do método SetTelefone()

        //Método AddEspacoReservado()
        public function AddEspacoReservado(ReservaEspaco $reserva) {
            array_push($this->_espacosReservados, $reserva);
        }//Fim do método AddEspacoReservado()

        //Método RemoverEspacoReservado()
        public function RemoverEspacoReservado(ReservaEspaco $reserva) {
            foreach ($this->GetReservaEspaco() as $index => $reservaAtual) {
                if ($reservaAtual === $reserva) {
                    unset($this->_espacosReservados[$index]);
                    break;
                }
            }
        }//Fim do método RemoverEspacoReservado()

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

        //Método GetReservaEspaco() 
        public function GetReservaEspaco() {
            return $this->_espacosReservados;
        }//Fim do método GetReservaEspaco()
    }
}