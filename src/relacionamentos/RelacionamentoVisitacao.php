<?php

use web\classes\agendamento\Horario;
use web\classes\agendamento\StatusHorario;
use web\classes\agendamento\Visitacao;
use web\classes\usuario\clientes\ClientePessoaFisica;
use web\classes\usuario\funcaoMonitor;
use web\classes\usuario\Monitor;

//Criar classe Visitação
    try {
        $monitor = new Monitor('andre', '753.202.429-64', '(75) 3131-6541', '13/01/2000', 'andre@gmail.com', 'forte', funcaoMonitor::assistente);
        $horario = new Horario('10/02/2026', StatusHorario::disponivel, $monitor, 20);

        $visitacao = new Visitacao($horario);
        
        echo 'Horario definido como visitação publica' . "\n";
    } catch (\InvalidArgumentException $e) {
        echo $e->getMessage();
        return;    
    } catch (\RuntimeException $e) {
        return;
    }

//Adicionando\Removendo um usuario da lista de visitantes
    $usuario1 = new ClientePessoaFisica('andre', 'andre@gmail.com', '(75) 3131-6541', '13/01/2000', '753.202.429-64', 'forte');
    $usuario2 = new ClientePessoaFisica('andre', 'andre@gmail.com', '(75) 3131-6541', '13/01/2000', '753.202.429-64', 'forte');
    
    $visitacao->AddVisitantes($usuario1);
    $visitacao->AddVisitantes($usuario2);

    echo $visitacao->GetNumVisitantes() . "\n";

    $visitacao->RemoverVisitantes($usuario2);
    
    echo $visitacao->GetNumVisitantes() . "\n";