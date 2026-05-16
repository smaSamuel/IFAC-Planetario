<?php
require_once '../vendor/autoload.php'; //Carregando o autoload do composer

use web\classes\usuario\Administrador;
use web\classes\usuario\monitores\Monitor;
use web\repositories\AdministradorRepository;
use web\repositories\MonitorAssistenteRepository;
use web\repositories\MonitorRepository;
use web\repositories\UsuarioRepository;
use web\services\AuthService;

/*
$dataAtual = new DateTime();
$admUSer = new Administrador('edurado', '(86) 3338-8592', 'edrua@gmail.com', '923.912.455-13', '02/08/1998', 'forte');

$adm = new AdministradorRepository();
$adm->CriarNovaLinhaTabela($admUSer);
*/


$auth = new AuthService();
$d = $auth->autorizar_acesso('923.912.455-13', 'forte');
var_dump($d);

/*
$repoUsuaio = new UsuarioRepository();
$lista = $repoUsuaio->ProcurarLinhaNaTabela(8);
var_dump($lista);

$monitor = new Monitor('eduardo', '204.887.487-80', '(86) 3338-8592', '02/08/1998', '20251CRB7203', 'rodrigo@gmail.com', 'forte');




$repoUsuaio->RemoverUsuario(7);

$idUsuario = $repoUsuaio->CriarUsuario($monitor);

$repoMonitor = new MonitorRepository();
$idMonitor = $repoMonitor->CriarUsuarioMonitor($monitor, $idUsuario);

$repoMonitorAssistente = new MonitorAssistenteRepository($monitor);
$repoMonitorAssistente->CriarMonitorAssistente($idMonitor);
*/