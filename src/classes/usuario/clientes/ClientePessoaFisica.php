<?php 

namespace web\classes\usuario\clientes {
    use web\classes\usuario\Usuario;
    use DateTime;
    use web\classes\usuario\monitores\MonitorProfessor;
    use web\classes\agendamento\Horario;

    //Classe PessoaFísica
    class ClientePessoaFisica extends Usuario implements Cliente  {
        private $_idade;
        private $_cpf;

        //Método Construct
        public function __construct($nome , $email, $telefone, $dataNascimento, $cpf) {
            parent::__construct     ($nome, $email, $telefone);
            $this->setIdade         ($dataNascimento);
            $this->setCPF           ($cpf);
        }//Fim do Método Construct
    
        protected function setIdade($dataNascimento) {
            $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);
            $dataAtual = new DateTime();
            $idade = $dataAtual->diff($dataNascimentoObj);
            $idade = $idade->y;
            
            if($idade > 17 && $idade < 120) {
                $this->_idade = $idade;
            } else {
                //throw new \InvalidArgumentException('Voce nao tem a idade minima para se registrar nesse site!');
                return false;    
            }
        }

        //Metodo SetCPF()
        protected function SetCPF($cpf) {
            $cpf = preg_replace('/[^0-9]/', '', $cpf);

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
                    //throw new \InvalidArgumentException("CPF inválido"); 
                    return false;    
                }
            }
            
            $this->_cpf = $cpf;
        } //Fim do metodo SetCPF()
        
        //Metodo getIdade()
        public function getIdade() {
            return $this->_idade;
        }//Fim do metodo getIdade()

        //Método GetCPF()
        public function GetCPF() { 
            return $this->_cpf; 
        } //Fim do método GetCPF()

        //Ações
        //Agendar horário
        public function ocuparEspaco(Horario $horario, MonitorProfessor $professor = null) { return false; }
        //Cancelar horário
        public function desocuparEspaco(Horario $horario) { return false; }

    }//Fim da Classe Pessoa Física
}