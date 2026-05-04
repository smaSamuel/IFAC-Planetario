<?php
namespace web\classes\agendamento {

    use web\classes\usuario\clientes\ClientePessoaJuridica;
    use web\classes\usuario\Administrador;
    use web\classes\usuario\monitores\MonitorProfessor;
    use web\classes\agendamento\Horario;

    class ReservaEspaco extends Agendamento {
        protected Horario $_horario;
        private $_numVisitantesEsperados; //Como e uma reserva feita por uma instituição os visitantes não precisam ter cadastro 
        private ClientePessoaJuridica $_reponsavel;
        public function __construct(ClientePessoaJuridica $reponsavel, $numVisitantesEsperados, Horario $horario, MonitorProfessor $professor = null)
        {   
            $this->_reponsavel = $reponsavel;
            $this->SetNumVisistantesEsperados($numVisitantesEsperados);
            $this->CadastrarHorario($horario, $professor);
        }

        //Método SetNumVisistantesEsperados()
        public function SetNumVisistantesEsperados($numVisitantesEsperados) {
            if (is_string($numVisitantesEsperados)) { //Verificar se o valor recebido e string
                intval($numVisitantesEsperados); //Converter para número
            }

            if ($numVisitantesEsperados > 0 && $numVisitantesEsperados <= 30) {
                $this->_numVisitantesEsperados = $numVisitantesEsperados;
            } else {
                //throw new \InvalidArgumentException('Escolha um valor que esteja entre 0 e 30');   
                return false;    
            }
        }//Fim do método SetNumVisistantesEsperados()

        //Método CadastrarHorario()
        public function CadastrarHorario(Horario $horario, MonitorProfessor $professor = null) {
            $this->_horario = $horario;
            $this->_horario->SetDado('Reservado', $this);

            if ($professor !== null) { 
                //Caso a instituição tenha escolhido um professor, alterar na classe horario.
                $horario->SetDado('Professor', $professor);
            } 
        }//Fim do método CadastrarHorario()

        //Método AlterarCadastroHorario
        public function AlterarCadastroHorario(ClientePessoaJuridica|Administrador $requerente, $obj, $valor) {
            //Verificar se quem solicitou a alteração e: o reponsavel desse agendamento ou um administrador
            if ($requerente === $this->GetResponsavel() || $requerente instanceof Administrador) {
                //Autorizar alterações
                //Alterar dados
                $this->_horario->SetDado($obj, $valor);
            } else {
                //throw new \InvalidArgumentException('Você não tem autorização para alterar essa reserva!');  
                return false; 
            }
        }//Fim do método CadastrarHorario()

        //Método RemoverCadastroHorario()
        public function RemoverCadastroHorario(ClientePessoaJuridica|Administrador $requerente) {
            //Verificar se quem solicitou a alteração e: o reponsavel desse agendamento ou um administrador
            if ($requerente === $this->GetResponsavel() || $requerente instanceof Administrador) {
                unset($_horario);
            } else {
                //throw new \InvalidArgumentException('Você não tem autorização para remover essa reserva!');  
                return false; 
            }
        }//Fim do método CadastrarHorario()

        //Método GetMonitorProfessor() 
        public function GetMonitorProfessor() {
            $dado = $this->_horario->GetDado('professor', MonitorProfessor::class); 
            return $dado->GetNome();
        }//Fim do método GetMonitorProfessor()

        //Método GetHorario()
        public function GetHorario() {
            return $this->_horario;
        }//Fim do método GetHorario()

        //Método GetResponsavel()
        public function GetResponsavel() {
            return $this->_reponsavel;
        }//Fim do método GetResponsavel()

        public function __destruct() {  }
    }

}