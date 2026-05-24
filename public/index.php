<?php

use web\classes\agendamento\Horario;
use web\classes\agendamento\StatusHorario;
use web\classes\agendamento\Visitacao;
use web\classes\usuario\clientes\ClientePessoaFisica;
use web\classes\usuario\funcaoMonitor;
use web\classes\usuario\Monitor;

require_once '../vendor/autoload.php'; //Carregando o autoload do composer
ini_set('display_errors', 1); //Habilita e desabilida a visualização dos erros (1- ativo e 0- desativo)


/*
// EXEMPLO CRIANDO NOVO USUARIO CLIENTE CPF
use web\classes\usuario\clientes\ClientePessoaFisica;

try {
    $clientecpf = new ClientePessoaFisica('andre', 'andre@gmail.com', '(35) 2726-0992' ,'13/01/2000', '753.202.429-64', 'forte');
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage();
} catch (\RuntimeException $e) {
    echo $e->getMessage();
}
*/

//====================

/*
// EXEMPLO CRIANDO NOVO USUARIO CLIENTE CNPJ
use web\classes\usuario\clientes\ClientePessoaJuridica;

try {
    $clientecnpj = new ClientePessoaJuridica('bah', '03.699.902/0001-56', 'bah@gmail.com', '(96) 3778-6229', 'Rua lol, 1233', 'forte');
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage();
} catch (\RuntimeException $e) {
    echo $e->getMessage();
}
*/