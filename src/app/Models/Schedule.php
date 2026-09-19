<?php
namespace app\Models {
    use Carbon\Carbon;
    use Carbon\Exceptions\InvalidIntervalException;
    use InvalidArgumentException;

    class Schedule {
        private const BUFFER_MINUTES = 20; # tempo que deve haver entre um horario e outro (em minutos) 
        private const MAX_MINUTES_FOR_RESERVED = 60; # tempo minimo para reservar reservar um horario (em minutos) 

        protected ?int $id = null;
        protected Carbon $start;  
        protected Carbon $end;

        protected Status $status;

        public function __construct(?int $id, Status $status = Status::FREE, Carbon $start, Carbon $end)
        {
            # Verifica se o end (fim da sessão) e maior que start (o começo da sessão)
            if ($end->lessThanOrEqualTo($start)) {
                throw new \InvalidArgumentException('O fim da sessão deve ser depois do comeco dela');
            }

            $this->id = $id;
            $this->start = $start;
            $this->end = $end;
            $this->status = $status;
        }

        public function Reserva(): void {
            # Método de transição entre status FREE e RESERVED (LIVRE PARA RESERVADO)

            # Verifica se o horario não estar disponivel
            if ($this->status != status::FREE) {
                throw new \InvalidArgumentException('Este horario nao estar disponivel para reserva');
                die;
            }

            # verifica se o horario estar dentro da faixa de tempo maximo para reservar o horario (MAX_MINUTE_FOR_RESERVED)
            if ( ($this->start->subUnitNoOverflow('hour', SELF::MAX_MINUTES_FOR_RESERVED, 'day'))->hour < Carbon::now()->hour )  {
                throw new \InvalidArgumentException('Nao e possivel reservar antes de ' . self::MAX_MINUTES_FOR_RESERVED . ' minutos do começo da sessao');            
                die;
            }
            
            $this->status = Status::RESERVED;
        }


    }
}
