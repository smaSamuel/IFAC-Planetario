<?php
namespace App\Models;
class SolicitacaoAssistente {
    private ?int $id;
    private int $idHorario;
    private int $idAssistente; // Esse e o ID de quem recebeu a solicitação
    private int $idEmissor; // Esse e o ID de quem enviou a solicitação

    public function __construct(?int $id, int $idHorario, int $idAssistente, int $idEmissor)
    {
        $this->id = $id;
        $this->idHorario = $idHorario;
        $this->idAssistente = $idAssistente;
        $this->idEmissor = $idEmissor;
    }

    public function getId() : ?int {
        return $this->id;
    }

    public function getIdHorario() : int {
        return $this->idHorario;
    }

    public function getIdEmissor() : int {
        return $this->idEmissor;
    }

    public function getIdAssistente() : int {
        return $this->idAssistente;
    }
}
