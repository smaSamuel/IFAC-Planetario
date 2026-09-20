<?php
declare(strict_types=1);

namespace App\Models;    

enum HorarioStatus: string {
    case Livre = 'livre';
    case Reservado = 'reservado';
    case EmVisitacao = 'em_visitacao';
}
