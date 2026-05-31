<?php
namespace web\relacionamentos {
    use web\classes\agendamento\Horario;
    use web\classes\agendamento\StatusHorario;
    use web\classes\Evento;
    use web\classes\usuario\funcaoMonitor;
    use web\classes\usuario\Monitor;

    try {        
        $monitor = new Monitor('andre', '753.202.429-64', '(75) 3131-6541', '13/01/2000', 'andre@gmail.com', 'forte', funcaoMonitor::professor);
        $horario = new Horario('10/05/2025', StatusHorario::disponivel, $monitor, 20);

        $evento = new Evento('Hello world!', $horario, 'Legal');
    } catch (\InvalidArgumentException $e) {
        echo $e->getMessage();
        return;
    } catch (\RuntimeException $e) {
        return;
    }

    echo 'Evento criado com sucesso!';
}