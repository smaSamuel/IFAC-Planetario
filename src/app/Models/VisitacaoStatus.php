<?php
declare(strict_types=1);
namespace App\Models;

enum VisitacaoStatus : string {
    case Ativa = "ativa";
    case Cancelada = "cancelada";
    case Concluido = "concluido";
}
