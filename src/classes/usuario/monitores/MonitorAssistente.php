<?php
    require_once 'Monitor.php';
    require_once (__DIR__ . '../../../agendamento/SolicitacaoAssistencia.php'); //TEMPORARIO PELA AMOR DE DEUS!!!!!!!!

    class MonitorAssistente extends Monitor
    {
        /** @var SolicitarAssistente[] */
        private array $_solicitacao = [];

        public function __construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email, funcaoMonitor $funcaoMonitor) {
            parent::__construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email, $funcaoMonitor);
        }

        //Método SetSolicitacaoAssistencia()
        public function SetSolicitacaoAssistencia(SolicitarAssistente $solicitacao) {
            array_push($this->_solicitacao, $solicitacao);
        }//Fim do método SetSolicitacaoAssistencia()

        //Método AceitarSolicitacaoAssistencia()
        public function AceitarSolicitacaoAssistencia(SolicitarAssistente $solicitacao) {
            $solicitacao->Aceitar();
        }//Fim do método AceitarSolicitacaoAssistencia()
        //Método RecusarSolicitacaoAssistencia()
        public function RecusarSolicitacaoAssistencia(SolicitarAssistente $solicitacao) {
            $solicitacao->Recusar();
        }//Fim do método RecusarSolicitacaoAssistencia()
    }

    $Assistente = new MonitorAssistente('rodrigo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com', funcaoMonitor::professor);
    $soli = new SolicitarAssistente($Assistente);
    