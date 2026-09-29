<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\HorarioCorrompidoException;
use App\Exceptions\HorarioIndisponivelException;
use App\Exceptions\HorarioQueryException;
use App\Models\Horario;
use App\Models\HorarioStatus;
use PDO;
use Carbon\Carbon;

class HorarioRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }    

    private function hydrate(array $dados) : Horario {
        try {
            return new Horario(intval($dados['id']), Carbon::parse($dados['comeco']), Carbon::parse($dados['fim']), HorarioStatus::from($dados['status']));
        }
        catch (\Throwable $e) {
            throw new HorarioCorrompidoException($e->getMessage(), $e->getCode(), $e);
        }    
    }

    public function buscarPorId(int $id) : ?Horario {
        $query = "SELECT id, comeco, fim, status FROM horario WHERE id = :id;";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($dados === false) {
            return null;
        }
 
        return $this->hydrate($dados);
    }

    public function inserir(Horario $horario): int {
        $query = "INSERT INTO horario (comeco, fim, status) VALUES (:comeco, :fim, :status) RETURNING id;";
            
        $stmt = $this->pdo->prepare($query);

        $stmt->execute([
            "comeco" => $horario->getComeco()->toDateTimeString(),
            "fim" => $horario->getFim()->toDateTimeString(),
            "status" => $horario->getHorarioStatus()->value,            
        ]);
        $id = $stmt->fetchColumn();
        return intval($id);
    } 

    public function atualizar(Horario $horario) : void { 
        if ($horario->getId() === null) {
            throw new HorarioIndisponivelException("Essa instancia de Horario nao tem definido um ID!");            
        }
        
        $query = "UPDATE horario SET comeco = :comeco, fim = :fim, status = :status WHERE id = :id;";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "comeco" => $horario->getComeco()->toDateTimeString(),
            "fim" => $horario->getFim()->toDateTimeString(),
            "status" => $horario->getHorarioStatus()->value,
            "id" => $horario->getId(),
        ]);
        
        return;   
    }

    public function deletar(int $id) : void {
        $query = "DELETE FROM horario WHERE id = :id;";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "id" => $id,
        ]);
        
        return;
    }

    public function deletarHorariosPassados() : void {
        $diaAtual = Carbon::now()->toDateTimeString();
        
        $query = "DELETE FROM horario WHERE status = :status AND fim < :diaAtual;";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "status" => HorarioStatus::Livre->value,
            "diaAtual" => $diaAtual,
        ]);

        return;
    } 

    public function buscarHorariosDoDia(Carbon $data) : array {
        $comecoDia = $data->copy()->startOfDay()->toDateTimeString();
        $fimDia = $data->copy()->endOfDay()->toDateTimeString();

        $query = "SELECT id, comeco, fim, status FROM horario WHERE comeco >= :comeco AND fim < :fim;";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "comeco" => $comecoDia,
            "fim" => $fimDia,
        ]);
        
        $horarios = array();
        
        while ($dado = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $horarios[] = $this->hydrate($dado);
        }

        return $horarios;
    }
}
