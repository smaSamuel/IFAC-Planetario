<?php

namespace web\classes\usuario {

    use web\classes\agendamento\ReservaEspaco;

    //Classe Usuario
    class Usuario
    {
        private $nome;
        private $email;
        private $telefone;
        private $senha;
        private array $_espacosReservados = [];

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
            if (is_string($nome) && strlen($nome) > 0 && strlen($nome) < 255) {
                $this->nome = $nome;
            } else {
                //throw new \InvalidArgumentException("Nome inválido!"); // Devolver erro
                return false;
            }
        } //Fim do método SetNome()

        //Método SetEMail()
        protected function SetEmail($email)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->email = $email;
            } else {
                //throw new \InvalidArgumentException("Email inválido!"); // Devolver erro
                return false;
            }
        } //Fim do método

        //Método SetTelefone()
        protected function SetTelefone($telefone)
        {
            $telefone = str_replace(['(', ')', '-', ' ', '/'], '', $telefone);

            $valTel = '/^[1-9]{2}(9[0-9]{8}|[2-8][0-9]{7})$/';

            if (preg_match($valTel, $telefone)) {
                $this->telefone = $telefone;
            } else {
                //throw new \InvalidArgumentException("Número de telefone inválido"); // Devolver erro
                return false;
            }
        } //Fim do método SetTelefone()

        //Método AddEspacoReservado()
        public function AddEspacoReservado(ReservaEspaco $reserva)
        {
            array_push($this->_espacosReservados, $reserva);
        } //Fim do método AddEspacoReservado()

        //Método RemoverEspacoReservado()
        public function RemoverEspacoReservado(ReservaEspaco $reserva)
        {
            foreach ($this->GetReservaEspaco() as $index => $reservaAtual) {
                if ($reservaAtual === $reserva) {
                    unset($this->_espacosReservados[$index]);
                    break;
                }
            }
        } //Fim do método RemoverEspacoReservado()

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

        //Método GetReservaEspaco() 
        public function GetReservaEspaco()
        {
            return $this->_espacosReservados;
        } //Fim do método GetReservaEspaco()

        //Método GetSenha()
        public function GetSenha() {
            return $this->senha;
        }//Fim do método GetSenha()
    }
}
