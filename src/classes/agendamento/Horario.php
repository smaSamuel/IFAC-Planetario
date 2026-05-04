<?php
namespace web\classes\agendamento {

    use DateTime;
    use web\classes\usuario\clientes\ClientePessoaFisica;
    use web\classes\usuario\monitores\MonitorAssistente;
    use web\classes\usuario\monitores\MonitorProfessor;
    
    class Horario {
        /* Guardar dados do horario */
        protected array $_dados = [];
        private array $_dadosPermitidos = [
        //  OBJ                 VALOR  
            'horario'                =>  DateTime::class,
            'professor'              =>  MonitorProfessor::class,
            'reservado'              =>  ReservaEspaco::class,
        ];

        private array $_assistentes = [];
        private array $_visitantes = [];

        //Método __construct()
        public function __construct(DateTime $data, MonitorProfessor $professor) {
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

        //Método Desagendar()
        public function Desagendar(ClientePessoaFisica $visitante = null) {

            if ($visitante != null) { //Verifica se e um cliente querendo desmarcar o horario
                array_diff($this->_visitantes, [$visitante]);
                } elseif (array_key_exists('reservado', $this->_dados)) { //Verifica se e uma reserva sendo desfeita
                    unset($this->_dados['reservado']);
                return true;    
            } else { //Se não for nem uma das duas
                return false; //Retornar false
            }

        }//Fim do método Desagendar()

        //Método GetAssistentes()
        public function GetAssistentes() {
            return $this->_assistentes;
        }//Fim do método GetAssistentes()

        //Método GetDado()
        public function GetDado($obj) {
            /* foreach ($this->_dados as $index => $dado) {
                //Encontrar obj
                if ($index === $obj) {
                    return $dado;    
                }
            } */

           // return $this->_dados;
        
            return $this->_dados[$obj] ?? null;    
       }//Fim do método GetDado()

        public function __destruct() {}
    }

}