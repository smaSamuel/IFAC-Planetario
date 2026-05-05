<?php
namespace web\classes\agendamento {

    use web\classes\usuario\clientes\ClientePessoaJuridica;
    use web\classes\usuario\Administrador;
    use web\classes\usuario\monitores\MonitorProfessor;
    use web\classes\agendamento\Horario;

    class ReservaEspaco {
        private $_numVisitantesEsperados; //Como e uma reserva feita por uma instituição os visitantes não precisam ter cadastro 
        private ClientePessoaJuridica $_reponsavel;
        public function __construct(ClientePessoaJuridica $reponsavel, $numVisitantesEsperados, MonitorProfessor $professor = null)
        {   
            $this->_reponsavel = $reponsavel;
            $this->SetNumVisistantesEsperados($numVisitantesEsperados);
        }

        //Método SetNumVisistantesEsperados()
        public function SetNumVisistantesEsperados($numVisitantesEsperados) {
            if (is_string($numVisitantesEsperados)) { //Verificar se o valor recebido e string
                $numVisitantesEsperados = intval($numVisitantesEsperados); //Converter para número
            }

            if ($numVisitantesEsperados > 0 && $numVisitantesEsperados <= 30) {
                $this->_numVisitantesEsperados = $numVisitantesEsperados;
            } else {
                //throw new \InvalidArgumentException('Escolha um valor que esteja entre 0 e 30');   
                return false;    
            }
        }//Fim do método SetNumVisistantesEsperados()

        //Método GetResponsavel()
        public function GetResponsavel() {
            return $this->_reponsavel;
        }//Fim do método GetResponsavel()

        public function __destruct() {  }
    }

}