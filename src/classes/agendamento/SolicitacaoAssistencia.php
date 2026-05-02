<?php
    enum statusSolicitacao {
        case pendente;
        case aceita;
        case recusada;
    }

    class SolicitarAssistente 
    {
        private statusSolicitacao $_status;
        private MonitorAssistente $_assistente;
        private MonitorProfessor $_professor;
        private date $_dataSolicitacao;
        
        public function __construct(MonitorAssistente $assistente /*, MonitorProfessor $professor*/, /*date $dataSolicitacao*/) {
            $this->_status = statusSolicitacao::pendente;
            $this->_assistente = $assistente;
            //$this->_professor = $professor;
            //$this->_dataSolicitacao = $dataSolicitacao;
        }

        public function __destruct() {  }

        //Método Aceitar()
        public function Aceitar()  {
            $this->_status = statusSolicitacao::aceita;
        }//Fim do método Aceitar()

        //Método Recusar()
        public function Recusar()  {
            $this->_status = statusSolicitacao::recusada;
        }//Fim do método Recusar()

        //Método GetStatus()
        public function GetStatus() {
            return $this->_status->name;
        }//Fim do método GetStatus()
    }
    