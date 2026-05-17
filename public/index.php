<?php

use web\classes\agendamento\Horario;
use web\classes\agendamento\StatusHorario;
use web\classes\usuario\funcaoMonitor;
use web\classes\usuario\Monitor;
use web\repositories\HorarioRepository;
use web\repositories\MonitorRepository;

require_once '../vendor/autoload.php'; //Carregando o autoload do composer





//$monitor = new Monitor('andre', '146.529.050-84', '(35) 2726-0992', '13/01/1957', 'andre@gmail.com', 'forte', funcaoMonitor::professor);