<?php 

namespace web\classes\usuario\clientes {
    use DateTime;

    //Classe PessoaFísica
    class ClientePessoaFisica extends Cliente  {
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
                throw new \InvalidArgumentException('Voce nao tem a idade minima para se registrar nesse site!');
            }
        }

        //Metodo SetCPF()
        protected function SetCPF($cpf) {
            $cpf = preg_replace('/[^0-9]/', '', $cpf);

            // verificar se foi informado o numero exato de digitos
            if (strlen($cpf) != 11) { throw new \InvalidArgumentException("CPF inválido"); }
        
            // verificar se foi informado uma sequencia de digitos iguais, 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) { throw new \InvalidArgumentException("CPF inválido"); }

            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    throw new \InvalidArgumentException("CPF inválido"); 
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
        public function ocuparEspaco() { return false; }
        //Cancelar horário
        public function desocuparEspaco() { return false; }

    }//Fim da Classe Pessoa Física

    $p = new ClientePessoaFisica('rodrigo', 'rodrigo@gmail.com', '(86) 3338-8592', '10/03/2000', '204.887.487-80');
}