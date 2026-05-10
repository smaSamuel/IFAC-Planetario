<?php
require_once '../vendor/autoload.php'; //Carregando o autoload do composer

use web\classes\usuario\monitores\Monitor;
use web\repositories\MonitorAssistenteRepository;
use web\repositories\MonitorRepository;
use web\repositories\UsuarioRepository;

$dataAtual = new DateTime();

$monitor = new Monitor('eduardo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'rodrigo@gmail.com', 'forte');

$repoUsuaio = new UsuarioRepository();
$lista = $repoUsuaio->ProcurarUsuario(8);

var_dump($lista);
/*


$repoUsuaio->RemoverUsuario(7);

$idUsuario = $repoUsuaio->CriarUsuario($monitor);

$repoMonitor = new MonitorRepository();
$idMonitor = $repoMonitor->CriarUsuarioMonitor($monitor, $idUsuario);

$repoMonitorAssistente = new MonitorAssistenteRepository($monitor);
$repoMonitorAssistente->CriarMonitorAssistente($idMonitor);
*/