<?php
namespace web\classes\agendamento {

    use web\classes\usuario\clientes\ClientePessoaJuridica;

    class ReservaEspaco {
        private $_numVisitantesEsperados; //Como e uma reserva feita por uma instituição os visitantes não precisam ter cadastro 
        private Horario $_horario;
        private ClientePessoaJuridica $_reponsavel;
        
        public function __construct(ClientePessoaJuridica $reponsavel, $numVisitantesEsperados, Horario $horario)
        {   
            $this->_reponsavel = $reponsavel;
            $this->_horario = $horario;

            $this->SetNumVisistantesEsperados($numVisitantesEsperados);
        }

        //Método SetNumVisistantesEsperados()
        public function SetNumVisistantesEsperados($numVisitantesEsperados) {
            if (is_string($numVisitantesEsperados)) { //Verificar se o valor recebido e string
                $numVisitantesEsperados = intval($numVisitantesEsperados); //Converter para número
            }

            if ($numVisitantesEsperados > 0 && $numVisitantesEsperados <= $this->_horario->GetNumeroMaximoVisitantes()) {
                $this->_numVisitantesEsperados = $numVisitantesEsperados;
            } else {
                throw new \InvalidArgumentException('Escolha um valor que esteja entre 0 e ' . $this->_horario->GetNumeroMaximoVisitantes());   
            }
        }//Fim do método SetNumVisistantesEsperados()

        //Método GetResponsavel()
        public function GetResponsavel() {
            return $this->_reponsavel;
        }//Fim do método GetResponsavel()

        //Método GetHorario()
        public function GetHorario() {
            return $this->_horario;
        }//Fim do método GetHorario()

        public function __destruct() {  }
    }

}