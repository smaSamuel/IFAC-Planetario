<?php
namespace web\relacionamentos {

    use web\classes\agendamento\Horario;
    use web\classes\agendamento\SolicitacaoAssistencia;
    use web\classes\agendamento\StatusHorario;
    use web\classes\usuario\funcaoMonitor;
    use web\classes\usuario\Monitor;

    try {
        $monitorAssistente = new Monitor('andre', '753.202.429-64', '(75) 3131-6541', '13/01/2000', 'andre@gmail.com', 'forte', funcaoMonitor::assistente);
        $monitorProfessor = new Monitor('andre', '753.202.429-64', '(75) 3131-6541', '13/01/2000', 'andre@gmail.com', 'forte', funcaoMonitor::professor);
        $horario = new Horario('10/02/2025', StatusHorario::disponivel, $monitorProfessor, 20);
    
        $SolicitacaoAssistencia = new SolicitacaoAssistencia($monitorAssistente, $monitorProfessor, $horario);
    } catch (\InvalidArgumentException $e) {
        echo $e->getMessage();
        return;    
    } catch (\RuntimeException $e) {
        return;
    }

    echo 'Solicitação de assistencia enviada com sucesso!';
}