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

        //Método CriarNovaLinhaTabela()
        public function CriarNovaLinhaTabela($classe)
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
        } //Fim do método CriarNovaLinhaTabela()

        //Método RemoverLinhaTabela() 
        public function RemoverLinhaTabela($id)
        {
            $query = "DELETE FROM horarios WHERE id = :id;";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } //Fim do método RemoverNovaLinhaTabela()

        //Método AtualizarNovaLinhaTabela()
        public function AtualizarNovaLinhaTabela($id, $classe)
        {
            if ($classe instanceof Horario) {
                $atualCadastro = $this->ProcurarLinhaNaTabela($id);

                $query = "UPDATE horarios SET id = :id, id_monitor = :id_monitor, dataHorario = :dataHorario WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([
                    ':id'                 => $id,
                    ':id_monitor'         => $classe->GetProfessor() ?? $atualCadastro[0]["nome"],
                    ':dataHorario'        => $classe->GetHorario() ?? $atualCadastro[0]["email"],
                ]);

                /*
                        Aparentimente isso PODE tar erro, já que os métodos gets[...]() nunca retorna null
                        Entretando isso AINDA (e espero) não é um problema
                    */
            } else {
                return false;
            }
        } //Fim do método AtualizarNovaLinhaTabela()

        //Método ListaLinhasTabela()
        public function ListaLinhasTabela()
        {
            $query = "SELECT id, id_monitor, dataHorario FROM horarios;";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } //Fim do método ListaLinhasTabela()

        //Método ProcurarLinhaNaTabela()
        public function ProcurarLinhaNaTabela($id)
        {
            $query = "SELECT * FROM horarios WHERE id = :id;";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } //Fim do método ProcurarLinhaNaTabela()

        //Método ProcurarColunaNaTabela()
        public function ProcurarColunaNaTabela($id, $valor)
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
        } //Fim do método ProcurarColunaNaTabela

    }
}
