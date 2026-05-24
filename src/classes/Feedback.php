<?php
    namespace web\classes {

    use web\classes\agendamento\Horario;
    use web\classes\usuario\clientes\ClientePessoaFisica;

        class Feedback {
            private ClientePessoaFisica $usuario; // O Usuario que escreveu à avaliação
            private Horario $horario; // O horario a qual esta avaliação se refere
            private $nota; 
            private $comentario; 

            public function __construct(ClientePessoaFisica $usuario, Horario $horario, $nota, $comentario)
            {
                $this->usuario = $usuario;
                $this->horario = $horario;

                $this->SetNota($nota);
                $this->SetComentario($comentario);
            }

//Sets
            //Método SetNota()
            public function SetNota($nota) {
                $this->nota = $nota;
            }//Fim do método SetNota()

            //Método SetComentario()
            public function SetComentario($comentario) {
                $this->comentario = $comentario;
            }//Fim do método SetComentario()

//Sets

//Gets 
            //Método GetUsuario()
            public function GetUsuario(){ 
                return $this->usuario;
            }//Fim do método GetUsuario()

            //Método GetHorario()
            public function GetHorario() {
                return $this->horario;
            }//Fim do método GetHorario()

            //Método GetNota()
            public function GetNota() {
                return $this->nota;
            }//Fim do método GetNota()

            //Método GetComentario()
            public function GetComentario() {
                return $this->comentario;
            }//Fim do método GetComentario()
        
//Gets
            //Método __destruct()
            public function __destruct() {  }
        }
    }