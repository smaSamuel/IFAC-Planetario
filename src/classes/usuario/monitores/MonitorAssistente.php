<?php
namespace web\classes\usuario\monitores {
    use web\classes\agendamento\SolicitacaoAssistencia;

    class MonitorAssistente extends Monitor 
    {

        /** @var SolicitarAssistente[] */
        private array $_solicitacao = [];

        public function __construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email) {
            parent::__construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email, funcaoMonitor::assistente);
        }

        //Método SetSolicitacaoAssistencia()
        public function SetSolicitacaoAssistencia(SolicitacaoAssistencia $solicitacao) {
            array_push($this->_solicitacao, $solicitacao);
            var_dump($this->_solicitacao); 
        }//Fim do método SetSolicitacaoAssistencia()

        //Método GetSolicitacaoAssistencia()
        public function GetSolicitacaoAssistencia() {
            return $this->_solicitacao;
        }//Fim do método GetSolicitacaoAssistencia()

        //Método AceitarSolicitacaoAssistencia()
        public function AceitarSolicitacaoAssistencia(SolicitacaoAssistencia $solicitacao) {
            $solicitacao->Aceitar($this);
        }//Fim do método AceitarSolicitacaoAssistencia()
        //Método RecusarSolicitacaoAssistencia()
        public function RecusarSolicitacaoAssistencia(SolicitacaoAssistencia $solicitacao) {
            $solicitacao->Recusar($this);
        }//Fim do método RecusarSolicitacaoAssistencia()

    }

    //$Assistente = new MonitorAssistente('rodrigo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com', funcaoMonitor::professor);
}