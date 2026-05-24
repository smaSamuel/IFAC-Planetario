<?php
    namespace web\classes\agendamento {

    use web\classes\usuario\clientes\ClientePessoaFisica;

        class Visitacao {
            private Horario $horario;
            private Array $visitantes = [];

            public function __construct(Horario $horario)
            {
                $this->horario = $horario;                      
            }

//Visitantes
            //Método AddVisitantes()
            public function AddVisitantes(ClientePessoaFisica $visitante) {
                array_push($this->visitantes, $visitante);
            }//Fim do método AddVisitantes()

            //Método RemoverVisitantes()
            public function RemoverVisitantes(ClientePessoaFisica $visitante) {
                foreach ($this->visitantes as $key => $value) {
                    if ($value === $visitante) {
                        unset($this->visitantes[$key]);
                    }
                }
            }//Fim do método RemoverVisitantes()

//Visitantes

//Gets
            //Método GetHorario()
            public function GetHorario() {
                return $this->horario;
            }//Fim do método GetHorario()
        
            //Método GetNumVisitantes()
            public function GetNumVisitantes() {
                return count($this->visitantes);
            }//Fim do método GetNumVisitantes()   
            
            //Método GetVisitantes()
            public function GetVisitantes() {
                return $this->visitantes;
            }//Fim do método GetVisitantes()   
//Gets

            //Método __destruct()
            public function __destruct() {  }

        }
    }