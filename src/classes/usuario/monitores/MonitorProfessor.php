<?php
namespace web\classes\usuario\monitores {

    use web\classes\agendamento\Horario;
    use web\classes\agendamento\SolicitacaoAssistencia;
    
    class MonitorProfessor extends Monitor 
    {
        public function __construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email) {
            parent::__construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email, funcaoMonitor::professor);
        }

        //Ações
        //Método SolicitarAssistente()
        public function SolicitarAssistente(MonitorAssistente $Assistente, Horario $horario) {
            $solicitacao = new SolicitacaoAssistencia($Assistente, $this, $horario);
            return $solicitacao;
        }//Fim do método SolicitarAssistente()

    }
}