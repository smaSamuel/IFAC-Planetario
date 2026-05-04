<?php
require_once '../vendor/autoload.php'; //Carregando o autoload do composer

use web\classes\agendamento\Horario;
use web\classes\usuario\Administrador;
use web\classes\usuario\clientes\ClientePessoaJuridica;
use web\classes\usuario\monitores\MonitorAssistente;
use web\classes\usuario\monitores\MonitorProfessor;


    $prof1 = new MonitorProfessor('rodrigo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com');
    $prof2 = new MonitorProfessor('rafael', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com');

    $adm = new Administrador('Kayo', '(86) 3338-8592', 'rodrigo@gmail.com', '204.887.487-80');

    $monitor1 = new MonitorAssistente('eduardo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com');
    $monitor2 = new MonitorAssistente('kaio', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'seg', 'rodrigo@gmail.com');

    $dataAtual = new DateTime();
    $horario1 = new Horario($dataAtual, $prof1);
    $horario2 = new Horario($dataAtual, $prof1);

    $cnpj1 = new ClientePessoaJuridica('Meta', '00.142.179/0001-11', 'Meta@gmail.com', '(66) 2575-8921', 'Rua B');
    $cnpj2 = new ClientePessoaJuridica('Meta2', '00.142.179/0001-11', 'Meta@gmail.com', '(66) 2575-8921', 'Rua B');

    $reserva = $cnpj1->ocuparEspaco($horario1);
    //var_dump($reserva->GetMonitorProfessor());
    $horarioReserva = $reserva->GetHorario();
    $professor = $horarioReserva->GetDado('professor');
    $cnpj1->desocuparEspaco($horario1);
    var_dump($horarioReserva->GetDado('Reservado'));
