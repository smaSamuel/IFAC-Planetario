<?php

namespace web\classes\agendamento {
    use web\classes\usuario\monitores\MonitorAssistente;
    use web\classes\usuario\monitores\MonitorProfessor;

    enum statusSolicitacao {
        case pendente;
        case aceita;
        case recusada;
    }

    class SolicitacaoAssistencia
    {
        private statusSolicitacao $_status;
        private MonitorAssistente $_assistente; //Variavel que referencia o assistente que esta sendo solicitado
        private MonitorProfessor $_professor; //Variavel que referencia o professor que estar solicitando um assistente
        private Horario $_horario; //Variavel que referencia ao horario que o monitor terá que oferecer assistencia
        private $_dataSolicitacao; //Guarda a data em que a solicitação foi feita (que foi instanciada) 
        
        public function __construct(MonitorAssistente $assistente, MonitorProfessor $professor, Horario $horario) {
            $this->_status = statusSolicitacao::pendente;
            $this->_professor = $professor;
            $this->_assistente = $assistente;
            $this->_horario = $horario;
            $this->_dataSolicitacao = date('d, m, Y');
            $this->DefinirAssistente($assistente);
        }

        //Método DefinirAssistente()
        private function DefinirAssistente(MonitorAssistente $assistente) {
            //Definir que assistente recebeu essa solicitação
            $this->_assistente->SetSolicitacaoAssistencia($this); //Adicionar essa solitação em sua lista
        }//Fim do método DefinirAssistente()

        //Método Aceitar()
        public function Aceitar(MonitorAssistente $assistente)  {
            if ($assistente == $this->_assistente) { //Verifica se o usuário que aceitou a solicitação e o mesmo que foi solicitado
                $this->_status = statusSolicitacao::aceita;
                $this->GetHorario()->AddAssistente($assistente, $this->GetMonitorProfessor());
            } 
        }//Fim do método Aceitar()

        //Método Recusar()
        public function Recusar(MonitorAssistente $assistente)  {
            if ($assistente == $this->_assistente) { //Verifica se o usuário que recusou a solicitação e o mesmo que foi solicitado
                $this->_status = statusSolicitacao::recusada;
            } 
        }//Fim do método Recusar()

        //Método GetStatus()
        public function GetStatus() {
            return $this->_status->name;
        }//Fim do método GetStatus()

        //Método GetDataSolicitacao()
        public function GetDataSolicitacao() {
            return $this->_dataSolicitacao;
        }//Fim do método GetDataSolicitacao()

        //Método GetMonitorProfessor()
        public function GetMonitorProfessor() {
            return $this->_professor;
        }//Fim do método GetMonitorProfessor()

        //Método GetHorario()
        public function GetHorario() {
            return $this->_horario;
        }//Fim do método GetHorario()

        //Método __destruct()
        public function __destruct() { }
    }
    
}