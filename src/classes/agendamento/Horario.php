<?php
namespace web\classes\agendamento {

    use DateTime;
    use web\classes\usuario\Administrador;
    use web\classes\usuario\clientes\ClientePessoaFisica;
    use web\classes\usuario\clientes\ClientePessoaJuridica;
    use web\classes\usuario\monitores\MonitorAssistente;
    use web\classes\usuario\monitores\MonitorProfessor;
    
    enum StatusHorario {
        case cheia; // Horário lotado
        case disponivel; // Disponível para novos agendamentos  
        case reservada; // Reservado por um CNPJ
    }

    class Horario {
        protected StatusHorario $_statusHorario;

        /* Guardar dados do horario */
        protected array $_dados = [];
        private array $_dadosPermitidos = [
        //  OBJ                         VALOR  
            'horario'                =>  DateTime::class,
            'professor'              =>  MonitorProfessor::class,
            'reservado'              =>  ReservaEspaco::class,
            'reservador'             =>  ClientePessoaJuridica::class,
        ];


        private array $_assistentes = [];
        private array $_visitantes = [];

        //Método __construct()
        public function __construct(DateTime $data, MonitorProfessor $professor, StatusHorario $statusHorario) {
            $this->_statusHorario = $statusHorario;
            $this->SetDado('horario', $data);
            $this->SetDado('professor', $professor);
        }//Fim do método __construct()
        
        //Método SetDado() 
        public function SetDado($obj, $valor) {
            //Verificar se o objeto e permitido
            if (!array_key_exists($obj, $this->_dadosPermitidos)) {
                //throw new \InvalidArgumentException("O objeto: '{$obj}' não e permitido");
                return false;    
            } 

            //Verificar se o valor e permitido
            $valoresPermitidos = $this->_dadosPermitidos[$obj];
            if (!($valor instanceof $valoresPermitidos)) {
                //throw new \InvalidArgumentException("O valor: '{$valor}' não e permitido");
                return false;    
            }

            $this->_dados[$obj] = $valor;
        }//Fim do método SetDado()

        //Método SetStatus()
        public function SetStatus($valor) {
            $this->_statusHorario = $valor;
        }//Fim método SetDado()

        //Método SetReserva()
        public function SetReserva(ReservaEspaco $reserva, ClientePessoaJuridica $reservador) {
            $this->SetDado('reservado', $reserva);
            $this->SetDado('reservador', $reservador);
            $this->SetStatus(StatusHorario::reservada);
        }//Fim do método SetReserva()

        //Método AddAssistente()
        public function AddAssistente(MonitorAssistente $assistente, MonitorProfessor $professor) {
            if ($this->GetDado('professor') === $professor) { //Verifica (na teoria) se esse professor e o reponsavel por esse dia 
                array_push($this->_assistentes, $assistente);
            }
        }//Fim do método AddAssistente()

        //Método RemoverAssistente()
        public function RemoverAssistente(MonitorAssistente $assistente, MonitorProfessor $professor) {
            if ($this->GetDado('professor') === $professor) { //Verifica (na teoria) se esse professor e o reponsavel por esse dia 
                foreach ($this->_assistentes as $index => $assistenteAtual) {
                    if ($assistenteAtual === $assistente) {
                        unset($this->_assistentes[$index]);
                        break;
                    }
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
                if($curret === $this->GetDado('reservador') || $curret instanceof Administrador) {
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

        //Método AlterarCadastroHorario
        public function AlterarCadastroHorario(ClientePessoaJuridica|Administrador $requerente, $obj, $valor) {
            //Verificar se quem solicitou a alteração e: o reponsavel desse agendamento ou um administrador
            if ($requerente === $this->GetDado('reservador') || $requerente instanceof Administrador) {
                //Autorizar alterações
                //Alterar dados
                $this->SetDado($obj, $valor);
            } else {
                //throw new \InvalidArgumentException('Você não tem autorização para alterar essa reserva!');  
                return false; 
            }
        }//Fim do método CadastrarHorario()

        //Método GetAssistentes()
        public function GetAssistentes() {
            return $this->_assistentes;
        }//Fim do método GetAssistentes()

        //Método GetDado()
        public function GetDado($obj) {
            if (array_key_exists($obj, $this->_dados)) {
                return $this->_dados[$obj];    
            } else {
                return null;
            }

           //return $this->_dados;
        
            //return $this->_dados[$obj] ?? null;    
       }//Fim do método GetDado()

       //Método GetStatusHorario
       public function GetStatusHorario() {
            return $this->_statusHorario;
       }//Fim do método GetStatusHorario()

       //Método GettVisitantes
       public function GetVisitantes() {
            return $this->_visitantes;
       }//Fim do método GettVisitantes()

       //Método GetReserva
       public function GetReserva() {
            if (array_key_exists('reservado', $this->_dados)) {
                return $this->_dados['reservado'];
            } else {
                return false;
            }

       }//Fim do método GetReserva()

       public function __destruct() {}
    }

}