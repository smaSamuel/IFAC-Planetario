<?php
namespace web\classes\usuario\monitores {
    use web\classes\agendamento\SolicitacaoAssistencia;
    
    class MonitorProfessor extends Monitor 
    {
        public function __construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email) {
            parent::__construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email, funcaoMonitor::professor);
        }

        //Ações
        //Método SolicitarAssistente()
        public function SolicitarAssistente(MonitorAssistente $Assistente) {
            $solicitacao = new SolicitacaoAssistencia($Assistente, $this);
            return $solicitacao;
        }//Fim do método SolicitarAssistente()

    }
    
/*
    $prof = new MonitorProfessor('rodrigo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com');
    $assistente = new MonitorAssistente('rodrigo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com');
    $assistente2 = new MonitorAssistente('rodrigo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com');

    $soli = $prof->SolicitarAssistente($assistente);
    $status = $soli->GetStatus();
    print("\n\n $status");
    $assistente->AceitarSolicitacaoAssistencia($soli);
    $status = $soli->GetStatus();
    print("\n\n $status");
*/

}