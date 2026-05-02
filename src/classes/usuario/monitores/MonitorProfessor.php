<?php
    require_once 'Monitor.php';
    require_once (__DIR__ . '../../../agendamento/SolicitacaoAssistencia.php'); //TEMPORARIO PELA AMOR DE DEUS!!!!!!!!

    class MonitorProfessor extends Monitor
    {
        public function __construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email, funcaoMonitor $funcaoMonitor) {
            parent::__construct($nome, $cpf, $telefone, $dataNascimento, $matricula, $diasLivres, $email, $funcaoMonitor);
        }

        public function __destruct() {  }

        //Ações
        //Método solicitar assistente
        public function SolicitarAssistente(MonitorAssistente $Assistente) {
            $solicitacao = new SolicitarAssistente();
        }

    }
    