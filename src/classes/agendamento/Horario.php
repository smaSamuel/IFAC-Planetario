<?php
namespace web\classes\agendamento {

    use DateTime;
    use web\classes\usuario\Administrador;
    use web\classes\usuario\clientes\ClientePessoaFisica;
    use web\classes\usuario\clientes\ClientePessoaJuridica;
    use web\classes\usuario\Monitor;
    use web\classes\usuario\monitores\MonitorAssistente;
    use web\classes\usuario\monitores\MonitorProfessor;
    
    enum StatusHorario {
        case cheia; // Horário lotado
        case disponivel; // Disponível para novos agendamentos  
        case reservada; // Reservado por um CNPJ
    }

    class Horario {
        protected StatusHorario $_statusHorario;

        private array $_assistentes = [];
        private array $_visitantes = [];
        private $_horario;
        private $_IDprofessor;
        private $_reservado;
        private $_reservador;

        //Método __construct()
        public function __construct($data, $professor, StatusHorario $statusHorario) {
            $this->_statusHorario = $statusHorario;
            $this->SetData($data);
            $this->SetProfessor($professor);
        }//Fim do método __construct()
        
        //Método SetProfessor()
        private function SetProfessor($professor) {
            $this->_IDprofessor = $professor;
        }//Fim do método SetProfessor()

        //Método SetData()
        private function SetData($data) {
            $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $data);
            $dataNascimentoDB = $dataNascimentoObj->format('Y-m-d'); //Formatando a data para o padrão do banco de dados

            $this->_horario = $dataNascimentoDB;
        }//Fim do método SetData()

        //Método SetStatus()
        public function SetStatus($valor) {
            $this->_statusHorario = $valor;
        }//Fim método SetDado()

        //Método SetReserva()
        public function SetReserva(ReservaEspaco $reserva, ClientePessoaJuridica $reservador) {
            $this->_reservado = $reserva;
            $this->_reservador = $reservador;
            $this->SetStatus(StatusHorario::reservada);
        }//Fim do método SetReserva()

        //Método AddAssistente()
        public function AddAssistente(Monitor $assistente) { 
            array_push($this->_assistentes, $assistente);
        }//Fim do método AddAssistente()

        //Método RemoverAssistente()
        public function RemoverAssistente(Monitor $assistente) {
            foreach ($this->_assistentes as $index => $assistenteAtual) {
                if ($assistenteAtual === $assistente) {
                    unset($this->_assistentes[$index]);
                    break;
                }
            }
        }//Fim do método RemoverAssistente()

        //Método CadastrarNovoVisitante()
        public function CadastrarNovoVisitante(ClientePessoaFisica $visitante) {
            if ($this->GetStatusHorario() == StatusHorario::disponivel) {  //Verifica se esse horario já estar disponível
                array_push($this->_visitantes, $visitante);
            } else {
                return false;
            }
        }//Fim do método CadastrarNovoVisitante()

        //Método Desagendar()
        public function Desagendar(ClientePessoaFisica|ClientePessoaJuridica|Administrador $curret) {
            //Verifica se e um cliente querendo desmarcar o horario
            if ($this->GetStatusHorario() != StatusHorario::reservada) { 
                // se for um cliente:
                $this->_visitantes = array_diff($this->_visitantes, [$curret]);                
            } 
            //Verifica se e uma reserva sendo desfeita
            elseif ($this->GetStatusHorario()::reservada) { 
                // se este horário estiver reservado:

                //Verifica se quem estar tentando desmarcar esse reserva e o dono ou administrador
                if($curret === $this->GetReservador() || $curret instanceof Administrador) {
                    unset($this->_dados['reservado']);
                    $this->SetStatus(StatusHorario::reservada);
                }
            return true;    
            } 
            else { //Se não for nem uma das duas
                return false; //Retornar false
            }

            /*
             *   Que código feio
            */
        }//Fim do método Desagendar()

        //Método GetAssistentes()
        public function GetAssistentes() {
            return $this->_assistentes;
        }//Fim do método GetAssistentes()

       //Método GetStatusHorario
       public function GetStatusHorario() {
            return $this->_statusHorario;
       }//Fim do método GetStatusHorario()

       //Método GettVisitantes
       public function GetVisitantes() {
            return $this->_visitantes;
       }//Fim do método GettVisitantes()

        //Método GetProfessor()
        public function GetProfessor() { return $this->_IDprofessor; }
        //Método GetReservador()
        public function GetReservador() { return $this->_reservador; }
        //Método GetHorario()
        public function GetHorario() { return $this->_horario; }

       public function __destruct() {}
    }

}