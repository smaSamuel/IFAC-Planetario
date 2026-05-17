<?php

namespace web\repositories {

    use PDO;
    use web\classes\agendamento\Horario;
    use web\classes\usuario\Usuario;
    use web\includes\Database;
    use web\Interfaces\Repository;

    class HorarioRepository implements Repository
    {
        private PDO $pdo;

        //Método __construct()
        public function __construct()
        {
            $this->pdo = Database::GetBancoDadosInfos();
        } //Fim do mtodo __construct()

        //Método CriarEntidade()
        public function CriarEntidade($classe)
        {
            if ($classe instanceof Horario) {
                $query = "INSERT INTO horarios (id_monitor, dataHorario) VALUES (?, ?);";

                $stmt = $this->pdo->prepare($query);

                $stmt->execute([
                    $classe->GetProfessor(),
                    $classe->GetHorario(),
                ]);

                return $this->pdo->lastInsertId();
            }

            return false;
        } //Fim do método CriarEntidade()

        //Método RemoverEntidade() 
        public function RemoverEntidade($id)
        {
            $query = "DELETE FROM horarios WHERE id = :id;";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } //Fim do método RemoverEntidade()

        //Método AtualizarEntidade()
        public function AtualizarEntidade($id, $classe)
        {
            if ($classe instanceof Horario) {
                $atualCadastro = $this->ProcurarEntidade($id);

                $query = "UPDATE horarios SET id = :id, id_monitor = :id_monitor, dataHorario = :dataHorario WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([
                    ':id'                 => $id,
                    ':id_monitor'         => $classe->GetProfessor() ?? $atualCadastro[0]["id_monitor"],
                    ':dataHorario'        => $classe->GetHorario() ?? $atualCadastro[0]["dataHorario"],
                ]);

                /*
                        Aparentimente isso PODE tar erro, já que os métodos gets[...]() nunca retorna null
                        Entretando isso AINDA (e espero) não é um problema
                    */
            } else {
                return false;
            }
        } //Fim do método AtualizarEntidade()

        //Método ListarEntidade()
        public function ListarEntidade()
        {
            $query = "SELECT id, id_monitor, dataHorario FROM horarios;";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } //Fim do método ListarEntidade()

        //Método ProcurarEntidade()
        public function ProcurarEntidade($id)
        {
            $query = "SELECT * FROM horarios WHERE id = :id;";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } //Fim do método ProcurarEntidade()

        //Método ProcurarAtributoEntidade()
        public function ProcurarAtributoEntidade($id, $valor)
        {
            $colunasRetornaveis = ['id', 'id_monitor', 'dataHorario'];

            //Verifica se o $valor estar e $colunasRetornaveis
            if (!in_array($valor, $colunasRetornaveis)) {
                //Se não estiver, retorne false
                return false;
            }

            $query = "SELECT {$valor} FROM horarios WHERE id = :id;";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } //Fim do método ProcurarAtributoEntidade

    }
}
