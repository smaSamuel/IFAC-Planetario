<?php
namespace web\classes\agendamento {
    use web\classes\usuario\monitores\MonitorAssistente;
    use web\classes\usuario\monitores\MonitorProfessor;
    
    class Horario {
        private $_data;
        private MonitorProfessor $_professor;
        /** @var MonitorAssistente[] */
        private array $_assistentes = [];

        //Método __construct()
        public function __construct($data, MonitorProfessor $MonitorProfessor)
        {
            
        }//Fim do método __construct()
    }

}