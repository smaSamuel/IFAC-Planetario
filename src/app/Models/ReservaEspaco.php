<?php
namespace App\Models;
class ReservaEspaco {
    protected ?int $id;
    protected int $idHorario;
    protected int $idReservador;

    public function __construct(?int $id, int $idHorario, int $idReservador)
    {    
        $this->id = $id;
        $this->idHorario = $idHorario;
    }

    public function getId() : ?int {
        return $this->id;
    }

    public function getIdHorario(): int {
        return $this->idHorario;
    }

    public function getIdReservador(): int {
        return $this->idReservador;
    }
}
