<?php

namespace web\Interfaces {
    use web\classes\agendamento\Horario;
    use web\classes\agendamento\ReservaEspaco;
    use web\classes\usuario\monitores\MonitorProfessor;

    //Interface Cliente
    interface Cliente {
        //Ações de todos os clientes
        public function ocuparEspaco(Horario $horario, MonitorProfessor $professor = null); 
        public function desocuparEspaco(Horario $horario); 

    }

}