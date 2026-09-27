<?php
namespace App\Models;
class Avaliacao {
    private ?int $id;
    private int $idCliente;
    private string $avaliacao;
    private int $nota;

    public function __construct(?int $id, int $idCliente, string $avalicao, int $nota)
    {
        $this->id = $id;
        $this->idCliente = $idCliente;
        $this->avaliacao = $avalicao;
        $this->nota = $nota;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getIdCliente(): int {
        return $this->idCliente;
    }

    public function getAvaliacao(): string {
        return $this->avaliacao;
    }

    public function getNota(): int {
        return $this->nota;
    }
}
