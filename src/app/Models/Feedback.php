<?php
namespace App\Models;
class Feedback {
    private ?int $id;
    private int $idCliente;
    private int $idVisitacao;
    private string $avaliacao;
    private int $nota;

    public function __construct(?int $id, int $idCliente, int $idVisitacao, string $avalicao, int $nota)
    {
        $this->id = $id;
        $this->idCliente = $idCliente;
        $this->idVisitacao = $idVisitacao;
        $this->avaliacao = $avalicao;
        $this->nota = $nota;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getIdCliente(): int {
        return $this->idCliente;
    }

    public function getIdVisitacao() : int {
        return $this->idVisitacao;
    }

    public function getAvaliacao(): string {
        return $this->avaliacao;
    }

    public function getNota(): int {
        return $this->nota;
    }
}
