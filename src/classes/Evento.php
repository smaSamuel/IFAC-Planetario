<?php
    namespace web\classes {

    use web\classes\agendamento\Horario;

        class Evento  {
            private $titulo;
            private Horario $horario;
            private $descricao;

            //Método __construct()
            public function __construct($titulo, Horario $horario, $descricao) {
                $this->horario = $horario;
            
                $this->SetTitulo($titulo);
                $this->SetDescricao($descricao);
            }//Fim do método __construct()

//Sets
            //Método SetTitulo()
            private function SetTitulo($titulo) {
                $this->titulo = $titulo;
            }//Fim do método SetTitulo()

            //Método SetDescricao()
            private function SetDescricao($descricao) {
                $this->descricao = $descricao;
            }//Fim do método SetDescricao()
            
//Sets

//Gets
            //Método GetTitulo()
            public function GetTitulo() {
                return $this->titulo;
            }//Fim do método GetTitulo()

            //Método GetDescricao()
            public function GetDescricao() {
                return $this->descricao;
            }//Fim do método GetDescricao()

            //Método GetHorario()
            public function GetHorario() {
                return $this->horario;
            }//Fim do método GetHorario()

//Gets

            //Método __destruct()
            public function __destruct() {  }
        
        }
    }