<?php

namespace web\classes\usuario\monitores {

    use  web\classes\usuario\Usuario;
    use DateTime;

    enum funcaoMonitor {
        case professor;
        case assistente;
    }
    
    //require_once '../usuario.php'; //TEMPORARIO

    //Classe Monitor
    class Monitor extends Usuario {
        private $_cpf;
        private $_idade;
        private $_matricula;
        private $_dataNascimento;
        private funcaoMonitor $_funcao;

        //Método __construct()
        public function __construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $email, $senha) {
            parent::__construct             ($nome, $email, $telefone, $senha);
            $this->SetCPF                   ($cpf);
            $this->SetIdade                 ($dataNascimento); //Set tanto a Idade tanto a Data de nascimento
            $this->SetMatricula             ($matricula);

            //$this->_funcao = $funcaoMonitor;
        }//Fim do metodo __Construct()

        //Metodo SetCPF()
        protected function SetCPF($cpf) {
            $cpf = str_replace(['-', '.'], '', $cpf);

            // verificar se foi informado o numero exato de digitos
            if (strlen($cpf) != 11) { return false; }
        
            // verificar se foi informado uma sequencia de digitos iguais, 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) { return false; }

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
        } //Fim do metodo SetCPF()

        //Metodo SetIdade()
        protected function setIdade($dataNascimento) {
            $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);
            $dataNascimentoDB = $dataNascimentoObj->format('Y-m-d'); //Formartar a data para o padrão do banco de dados

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

        //Metodo SetMatricula()
        protected function SetMatricula($matricula) {
            if (is_string($matricula)) {
                $this->_matricula = $matricula;
            } else {
                //throw new \InvalidArgumentException('Matricula Invalida!');
                return false;    
            }
        }//Fim do metodo SetMatricula()

        //Método AddVisitacao()
        public function AddVisitacao() {
            /*
                IMPLEMENTAR LÓGICA DO MÉTODO
            */
        }//Fim do método AddVisitacao()

        //metodos gets()
        //Método GetCPF()
        public function GetCPF() { 
            return $this->_cpf; 
        } //Fim do método GetCPF()

        //Método GetIdade()
        public function GetIdade() { 
            return $this->_idade; 
        } //Fim do método GetIdade()

        //Método GetMatricula()
        public function GetMatricula() { 
            return $this->_matricula; 
        } //Fim do método GetMatricula()

        //Método GetFuncaoMonitor()
        public function GetFuncaoMonitor() { 
            return $this->_funcao->name; 
        } //Fim do método GetTipo()

        //Métdo DataNascimento()
        public function GetDataNascimento() {
            return $this->_dataNascimento;
        }//Fim método DataNascimento()

        //Método GetUsuario()
        public function GetUsuario() {
            return parent::class;
        }//Fim do método GetUsuario()
    }
}