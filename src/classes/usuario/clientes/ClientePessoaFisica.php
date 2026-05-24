<?php 

namespace web\classes\usuario\clientes {
    use web\classes\usuario\Usuario;
    use web\utils\SetCpf;
    use web\utils\SetIdade;

    //Classe PessoaFísica
    class ClientePessoaFisica extends Usuario  {
        private $_idade;
        private $dataNascimento;
        private $_cpf;

        //Método Construct
        public function __construct($nome , $email, $telefone, $dataNascimento, $cpf, $senha) {
            parent::__construct     ($nome, $email, $telefone, $senha);
            $this->setIdade         ($dataNascimento); //Seta tanto Idade tanto DataNascimento
            $this->setCPF           ($cpf);
        }//Fim do Método Construct
    
        //Método setIdade()
        private function setIdade($dataNascimento) {
            try {
                $this->_idade = SetIdade::CalcularIdade($dataNascimento);
                $this->dataNascimento = SetIdade::FormartarDataNascimento($dataNascimento);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            } catch (\Exception $e) {
                throw new \RuntimeException("Tivemos um pequeno problema, tente novamente.");
            }
        }
        //Fim do método setIdade()

        //Metodo SetCPF()
        protected function SetCPF($cpf) {
            try {
                $this->_cpf = SetCpf::verificarValidade($cpf);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            } catch (\Exception $e) {
                throw new \RuntimeException("Tivemos um pequeno problema, tente novamente.");
            }
        } //Fim do metodo SetCPF()
        
        //Metodo getIdade()
        public function getIdade() {
            return $this->_idade;
        }//Fim do metodo getIdade()

        //Método GetCPF()
        public function GetCPF() { 
            return $this->_cpf; 
        } //Fim do método GetCPF()

        //Método GetDataNascimento()
        public function GetDataNascimento() { 
            return $this->dataNascimento; 
        } //Fim do método GetDataNascimento()

        //Método GetUsuario()
        public function GetUsuario() {
            return parent::class;
        }//Fim do método GetUsuario()

    }//Fim da Classe Pessoa Física
}