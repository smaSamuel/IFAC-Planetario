<?php
namespace web\relacionamentos {
    use web\classes\agendamento\Horario;
    use web\classes\agendamento\ReservaEspaco;
    use web\classes\agendamento\StatusHorario;
    use web\classes\usuario\clientes\ClientePessoaJuridica;
    use web\classes\usuario\funcaoMonitor;
    use web\classes\usuario\Monitor;

    
    try {
        $usuario = new ClientePessoaJuridica('meta', '89451014000135', 'meta@gmail.com', '(75) 3131-6541', 'rua 701', 'forte');
        $monitor = new Monitor('andre', '753.202.429-64', '(75) 3131-6541', '13/01/2000', 'andre@gmail.com', 'forte', funcaoMonitor::assistente);
        $horario = new Horario('10/02/2026', StatusHorario::disponivel, $monitor, 20);
        
        $ReservaEspaco = new ReservaEspaco($usuario, 10, $horario);
    } catch (\InvalidArgumentException $e) {
        echo $e->getMessage();
        return;
    } catch (\RuntimeException $e) {
        return;
    }

    echo 'Espaço reservado com sucesso!';
}