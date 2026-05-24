<?php
namespace web\classes\agendamento {

    use web\classes\usuario\Monitor;

    enum StatusHorario {
        case cheia; // Horário lotado
        case disponivel; // Disponível para novos agendamentos  
        case reservada; // Reservado por um CNPJ
    }

    class Horario {

        private StatusHorario $statusHorario;

        private Monitor $responsavel;
        private array $assistentes;
        
        private $numMaximoVistante;

        public function __construct(StatusHorario $statusHorario, Monitor $responsavel, $numeroMaximoVisitantes) {
            
            $this->SetStatusHorario($statusHorario);
            $this->SetResponsavel($responsavel);
            $this->SetNumeroMaximoVisitantes($numeroMaximoVisitantes);
        }

        //Método SetStatusHorario
        public function SetStatusHorario($statusHorario) {
            $this->statusHorario = $statusHorario;
        }
        //Fim do método SetStatusHorario

        //Método SetResponsavel
        private function SetResponsavel(Monitor $responsavel) {
            $this->responsavel = $responsavel;
        }
        //Fim do método SetResponsavel

        //Método AddAssistente
        public function AddAssistente(Monitor $assistente) {
            if ($assistente instanceof Monitor) {
                array_push($this->assistentes, $assistente); 
            }
        }
        //Fim do método AddAssistente

        //Método SetNumeroMaximoVisitantes
        private function SetNumeroMaximoVisitantes($numeroMaximoVisitantes) {
            if ($numeroMaximoVisitantes > 0 && $numeroMaximoVisitantes <= 100) {
                $this->numMaximoVistante = $numeroMaximoVisitantes;
            }
        }
        //Fim do método SetNumeroMaximoVisitantes

        //Método GetStatusHorario
        public function GetStatusHorario() { 
            return $this->statusHorario;
        }
        //Fim do método GetStatusHorario 

        //Método GetReponsavel
        public function GetReponsavel() { 
            return $this->responsavel;
        }
        //Fim do método GetReponsavel
        
        //Método GetNumeroMaximoVisitantes
        public function GetNumeroMaximoVisitantes() {
            return $this->numMaximoVistante;
        }
        //Fim do método GetNumeroMaximoVisitantes

        //Método GetAssistentes()
        public function GetAssistentes() {
            return $this->assistentes;
        }//Fim método GetAssistentes()

        public function __destruct() {  }
    }

}