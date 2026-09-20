<?php
declare(strict_types=1);
namespace App\Models;
use App\Exceptions\HorarioIndisponivelException;
use Carbon\Carbon;

class Horario {
    private const BUFFER_MINUTOS = 20; # tempo que deve haver entre um horario e outro (em minutos) 
    private const ANTECEDENCIA_MINIMA_MINUTOS = 60; # tempo minimo para marcar visitação em um horario (em minutos) 

    protected ?int $id = null;
    protected Carbon $comeco;  
    protected Carbon $fim;

    protected HorarioStatus $horarioStatus;

    public function __construct(?int $id, Carbon $comeco, Carbon $fim, HorarioStatus $horarioStatus = HorarioStatus::Livre)
    {
        # Verifica se o fim da sessão e maior que o começo da sessão
        if ($fim->lessThanOrEqualTo($comeco)) {
            throw new HorarioIndisponivelException('O fim da sessão deve ser depois do comeco dela');
        }

        $this->id = $id;
        $this->comeco = $comeco;
        $this->fim = $fim;
        $this->horarioStatus = $horarioStatus;
    }

    public function reservar(): void {
        # Método de transição entre HorarioStatus Livre e Reservado

        # Verifica se o horario não estar disponivel
        if ($this->horarioStatus != HorarioStatus::Livre) {
            throw new HorarioIndisponivelException('Este horario nao estar disponivel para reserva');
        }
     
        $this->horarioStatus = HorarioStatus::Reservado;
    }

    public function marcarEmVisitacao(): void {
        # Método de transição entre status Livre e Em_visitacao

        # Verifica se o horario não estar disponivel
        if ($this->horarioStatus != HorarioStatus::Livre) {
            throw new HorarioIndisponivelException('Este horario nao estar disponivel para visitacao');
        }

        $this->horarioStatus = HorarioStatus::EmVisitacao;
    }

    public function liberar() {
        # Método de transiçao entre status EmVisitacao ou Reservado para Livre
        
        # Verifica se o horario estar disponivel
        if ($this->horarioStatus == HorarioStatus::Livre) {
            throw new HorarioIndisponivelException('Este horario já estar livre');
        }

        $this->horarioStatus = HorarioStatus::Livre;
    }

    public function conflitaCom(Horario $outroHorario) : bool {
        # Métdo que verifica se o tempo desse horario se sobrepoe a outro (dois horarios marcados no mesmo tempo)
            
        $inicioComBuffer = $this->comeco->copy()->subMinutes(self::BUFFER_MINUTOS); 
        $fimComBuffer = $this->fim->copy()->addMinutes(self::BUFFER_MINUTOS);

        return $inicioComBuffer->isBefore($outroHorario->fim) && $fimComBuffer->isAfter($outroHorario->comeco);
    }
    
    public function disponivelParaVisitacao() : bool {
        # Esse método serve para verificar se esse horario cumpre os requisitos para estar disponivel, sendo os requisitos:
        # 1. A Semana de inicio tem que estar na mesma semana do servidor;
        # 2. O Status deve estar marcado como Livre;
        # 3. A Reserva deve der sido feita entre o tempo minimo de reserva estibulado no BUFFER
        $agora = Carbon::now();

        $comecoDessaSemana = $agora->startOfWeek();
        $fimDessaSemana = $agora->endOfWeek();
            
        # Verifica se a semana do horario e DIFERENTE da semana do servidor (requisito numero 1)
        if (!( $this->comeco->between($comecoDessaSemana->copy(), $fimDessaSemana->copy()) )) {
            return false;
        }

        # Verifica se o status NÃO e Livre (requisito numero 2)
        if ($this->horarioStatus != HorarioStatus::Livre) {
            return false;
        }

        # verifica se o NÃO estar no limite de tempo do ANTECEDENCIA_MINIMA_MINUTOS (requisito numero 3)
        if (!( $agora->diffInMinutes($this->comeco, false) >= self::ANTECEDENCIA_MINIMA_MINUTOS )) {
            return false;
        }
        
        return true;
    }

    public function disponivelParaReserva() : bool {
        # Esse método serve para verificar sse esse horario cumpre os requisitos para ser reservado por um administrador ou monitor, sendo os requisitos:
        # 1. O Status deve ser Livre;
        # 2. Esse Horario não deve estar na semana de visitação

        $agora = Carbon::now();

        $comecoDessaSemana = $agora->startOfWeek();
        $fimDessaSemana = $agora->endOfWeek();

        # Verifica se o horario NÃO estar Livre (requisito numero 1)
        if ($this->horarioStatus != HorarioStatus::Livre) {
            return false;
        }

        # Verifica se o horario estar DENTRO da semana de visitação (requisito numero 2)
        if ( $this->comeco->between($comecoDessaSemana->copy(), $fimDessaSemana->copy()) ) {
            return false;
        }

        return true;
    }
}
