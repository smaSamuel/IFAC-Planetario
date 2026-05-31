<?php
namespace web\relacionamentos {

    use web\classes\usuario\clientes\ClientePessoaFisica;
    use web\classes\agendamento\Horario;
    use web\classes\agendamento\StatusHorario;
    use web\classes\Feedback;
    use web\classes\usuario\funcaoMonitor;
    use web\classes\usuario\Monitor;

    
    try {
        $usuario = new ClientePessoaFisica('andre', 'andre@gmail.com', '(75) 3131-6541', '13/01/2000', '753.202.429-64', 'forte');
        $monitor = new Monitor('andre', '753.202.429-64', '(75) 3131-6541', '13/01/2000', 'andre@gmail.com', 'forte', funcaoMonitor::assistente);
        $horario = new Horario('10/02/2026', StatusHorario::disponivel, $monitor, 20);
        
        $avaliacao = new Feedback($usuario, $horario, 10, 'legal');
    } catch (\InvalidArgumentException $e) {
        echo $e->getMessage();
        return;
    } catch (\InvalidArgumentException $e) {
        return;
    } 

    echo 'avaliação criado com sucesso!';
}