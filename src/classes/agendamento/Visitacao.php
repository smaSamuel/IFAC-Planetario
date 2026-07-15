<?php
    namespace web\classes\agendamento {

    use web\classes\usuario\clientes\ClientePessoaFisica;

        class Visitacao {
            private $id;
            private Horario $horario;
            private ClientePessoaFisica $visitante;

            public function __construct(Horario $horario, ClientePessoaFisica $visitante)
            {
                $this->horario = $horario;                      
                $this->visitante = $visitante;
            }
/*
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
*/
//Gets
            //Método SetId()
            public function SetId($id) {
                $this->id = $id;
            }//Fim do método SetId()

            //Método GetHorario()
            public function GetHorario() {
                return $this->horario;
            }//Fim do método GetHorario()

            //Método GetId()
            public function GetId(){
                return $this->id;
            }//Fim do método GetId()
            
            //Método GetVisitante()
            public function GetVisitante() {
                return $this->visitante;
            }//Fim do método GetVisitante()   
//Gets

            //Método __destruct()
            public function __destruct() {  }

        }
    }