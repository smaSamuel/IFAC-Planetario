<?php
namespace web\classes\agendamento {

    use DateTime;
    use web\classes\usuario\Monitor;

    enum StatusHorario {
        case cheia; // Horário lotado
        case disponivel; // Disponível para novos agendamentos  
        case reservada; // Reservado por um CNPJ
    }

    class Horario {

        private StatusHorario $statusHorario;

        private Monitor $responsavel;
        private DateTime $data;
        private array $assistentes;
        
        private $numMaximoVistante;

        public function __construct($data, StatusHorario $statusHorario, Monitor $responsavel, $numeroMaximoVisitantes) {

            $this->SetData($data);
            $this->SetStatusHorario($statusHorario);
            $this->SetResponsavel($responsavel);
            $this->SetNumeroMaximoVisitantes($numeroMaximoVisitantes);
        }

        //Método SetData
        public function SetData($data) {
            $dataFormatada = DateTime::createFromFormat('d/m/Y', $data);
            $this->data = $dataFormatada;
        }//Fim do método SetData

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

        //Método GetData
        public function GetData() {
            return $this->data;
        }//Fim do método GetData
        
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