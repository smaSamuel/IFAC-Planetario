<?php

namespace web\classes\usuario\clientes {
    use web\classes\agendamento\Horario;
    use web\classes\usuario\Monitor;

    //Interface Cliente
    interface Cliente {
        //Ações de todos os clientes
        public function ocuparEspaco(Horario $horario, Monitor $professor = null); 
        public function desocuparEspaco(Horario $horario); 

    }

}