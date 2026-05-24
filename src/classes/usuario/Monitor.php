<?php

namespace web\classes\usuario {

    use web\classes\agendamento\SolicitacaoAssistencia;
    use web\utils\SetCpf;
    use web\utils\SetIdade;

    enum funcaoMonitor {
        case professor;
        case assistente;
    }

    //Classe Monitor
    class Monitor extends Usuario {
        private $_cpf;
        private $_idade;
        private $_dataNascimento;
        private funcaoMonitor $_funcao;
        private array $_solicitacao;

        //Método __construct()
        public function __construct($nome, $cpf, $telefone, $dataNascimento, $email, $senha, funcaoMonitor $funcao) {
            parent::__construct             ($nome, $email, $telefone, $senha);
            $this->SetCPF                   ($cpf);
            $this->SetIdade                 ($dataNascimento); //Set tanto a Idade tanto a Data de nascimento
            $this->_funcao = $funcao; 
            //$this->_funcao = $funcaoMonitor;
        }//Fim do metodo __Construct()

//Sets
        //Metodo SetCPF()
        protected function SetCPF($cpf) {
            try {
                $this->_cpf = SetCpf::verificarValidade($cpf);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            } catch (\RuntimeException $e) {
                throw new \RuntimeException("Tivemos um pequeno problema, tente novamente.");
            }
        } //Fim do metodo SetCPF()

        //Metodo SetIdade()
        protected function SetIdade($dataNascimento) {
            try {
                $this->_idade = SetIdade::CalcularIdade($dataNascimento);
                $this->_dataNascimento = SetIdade::FormartarDataNascimento($dataNascimento);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            } catch (\RuntimeException $e) {
                throw new \RuntimeException("Tivemos um pequeno problema, tente novamente.");
            }
        }//Fim metodo SetIdade()    

//Sets

//Solicitação
        //Método SetSolicitacaoAssistencia()
        public function AddSolicitacaoAssistencia(SolicitacaoAssistencia $solicitacao) {
            array_push($this->_solicitacao, $solicitacao);
        }//Fim do método SetSolicitacaoAssistencia()

        public function AceitarSolicitacao(SolicitacaoAssistencia $solicitacao) {
            array_push($this->_solicitacao, $solicitacao);
        }//Fim do método SetSolicitacaoAssistencia()


        //Método AceitarSolicitacaoAssistencia()
        public function AceitarSolicitacaoAssistencia(SolicitacaoAssistencia $solicitacao) {
            $solicitacao->Aceitar($this);
        }//Fim do método AceitarSolicitacaoAssistencia()


        //Método RecusarSolicitacaoAssistencia()
        public function RecusarSolicitacaoAssistencia(SolicitacaoAssistencia $solicitacao) {
            $solicitacao->Recusar($this);
        }//Fim do método RecusarSolicitacaoAssistencia()
//Solicitação
    
//Gets
        //metodos gets()
        //Método GetCPF()
        public function GetCPF() { 
            return $this->_cpf; 
        } //Fim do método GetCPF()

        //Método GetIdade()
        public function GetIdade() { 
            return $this->_idade; 
        } //Fim do método GetIdade()

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

        //Método GetSolicitacaoAssistencia()
        public function GetSolicitacaoAssistencia() {
            return $this->_solicitacao;
        }//Fim do método GetSolicitacaoAssistencia()
    
//Gets    
    }
}