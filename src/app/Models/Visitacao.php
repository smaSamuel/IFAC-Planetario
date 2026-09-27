<?php
declare(strict_types=1);
namespace App\Models;

class Visitacao {
    private ?int $id;
    private int $idHorario;
    private int $idCliente;    
    private VisitacaoStatus $visitacaoStatus; 

    public function __construct(?int $id, int $idHorario, int $idCliente, VisitacaoStatus $visitacaoStatus = VisitacaoStatus::Ativa)
    {
        $this->id = $id;
        $this->idCliente = $idCliente;
        $this->idHorario = $idHorario;
        $this->visitacaoStatus = $visitacaoStatus;
    }

    public function cancelarVisitacao() : void {
        // Esse método ira marcar essa visitação como cancelada.
        
        $this->visitacaoStatus = VisitacaoStatus::Cancelada;
    }

    public function concluir() : void {
        // Esse método ira marcar essa visitação como concluida (Que o horario da visitação já passou)
        
        $this->visitacaoStatus = VisitacaoStatus::Concluido;
    }

    public function getIdCliente() : int {
        return $this->idCliente;
    }

    public function getIdHorario() : int {
        return $this->idHorario;
    }

    public function getId() : ?int {
        return $this->id;
    }

    public function getStatus() : VisitacaoStatus {
        return $this->visitacaoStatus;
    }
}
