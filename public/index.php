<?php

use web\classes\agendamento\Horario;
use web\classes\agendamento\StatusHorario;
use web\repositories\HorarioRepository;

require_once '../vendor/autoload.php'; //Carregando o autoload do composer

$horario = new Horario('16/05/2026', 1, StatusHorario::disponivel);
$repoHorario = new HorarioRepository();
$repoHorario->CriarNovaLinhaTabela($horario);