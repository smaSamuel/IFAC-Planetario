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
        private array $_diasLivres = [];
        private array $_visitacoes = [];
        private funcaoMonitor $_funcao;

        //Método __construct()
        public function __construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email, funcaoMonitor $funcaoMonitor) {
            parent::__construct             ($nome, $email, $telefone);
            $this->SetCPF                   ($cpf);
            $this->SetIdade                 ($dataNascimento);
            $this->SetMatricula             ($matricula);
            $this->SetDiasLivres            ($diasLivres);

            $this->_funcao = $funcaoMonitor;
        }//Fim do metodo __Construct()

        //Metodo SetCPF()
        protected function SetCPF($cpf) {
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
        } //Fim do metodo SetCPF()

        //Metodo SetIdade()
        protected function setIdade($dataNascimento) {
            $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);
            $dataAtual = new DateTime();
            $idade = $dataAtual->diff($dataNascimentoObj);
            $idade = $idade->y;
            
            if($idade > 17 && $idade < 120) {
                $this->_idade = $idade;
            } else {
                throw new \InvalidArgumentException('Voce nao tem a idade minima para se registrar nesse site!');
            }
        }//Fim metodo SetIdade()    

        //Metodo SetMatricula()
        protected function SetMatricula($matricula) {
            if (is_string($matricula)) {
                $this->_matricula = $matricula;
            } else {
                throw new \InvalidArgumentException('Matricula Invalida!');
            }
        }//Fim do metodo SetMatricula()

        //Metodo SetDiasLivres()
        protected function SetDiasLivres($diasLivres) { // ** INCOMPLETO **
            array_push($this->_diasLivres, $diasLivres);
        }//Fim do metodo SetDiasLivres()

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

        //Método GetDiasLivres()j
        public function GetDiasLivres() { 
            return $this->_diasLivres; 
        } //Fim do método GetDiasLivres() ** INCOMPLETO **

        //Método GetFuncaoMonitor()
        public function GetFuncaoMonitor() { 
            return $this->_funcao->name; 
        } //Fim do método GetTipo()

        
    }

    $p1 = new Monitor('rodrigo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com', funcaoMonitor::professor);
}