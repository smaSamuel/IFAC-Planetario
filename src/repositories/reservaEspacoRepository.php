<?php
    namespace web\repositories {
    
    use PDO;
    use web\classes\agendamento\ReservaEspaco;
    use web\includes\Database;
    use web\Interfaces\Repository;

        class reservaEspacoRepository implements Repository {
            private PDO $pdo;

            //Método __construct()
            public function __construct() {
                $this->pdo = Database::GetBancoDadosInfos();
            }//Fim do método __construct()

            //Método CriarEntidade()
            public function CriarEntidade($classe) {
                if ($classe instanceof ReservaEspaco) {
                    $query = "INSERT INTO reservaEspaco (id, id_horario, id_pessoaJuridica) VALUES (?, ?, ?);";
    
                    $stmt = $this->pdo->prepare($query);

                    $stmt->execute([
                        $classe->GetId(),
                        $classe->GetHorario()->GetId(),
                        $classe->GetResponsavel()->GetId(),
                    ]);
    
                    return $this->pdo->lastInsertId();
                } 

                return false;
            }//Fim do método CriarEntidade()

            //Método RemoverEntidade() 
            public function RemoverEntidade($id) {
                $query = "DELETE FROM reservaEspaco WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }//Fim do método RemoverEntidade()

            //Método AtualizarEntidade()
            public function AtualizarEntidade($id, $classe) {
                if ($classe instanceof ReservaEspaco) {
                    $atualCadastro = $this->ProcurarEntidade($id);
    
                    $query = "UPDATE reservaEspaco SET id = :id, id_horario = :id_horario, id_pessoaJuridica = :id_pessoaJuridica WHERE id = :id;";
    
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute([
                        ':id'                 => $id,
                        ':id_horario'         => $classe->GetHorario()->GetId() ?? $atualCadastro[0]["id_horario"],
                        ':id_pessoaJuridica'  => $classe->GetResponsavel()->GetId() ?? $atualCadastro[0]["id_pessoaJuridica"],
                    ]);
    
                    /*
                        Aparentimente isso PODE tar erro, já que os métodos gets[...]() nunca retorna null
                        Entretando isso AINDA (e espero) não é um problema
                    */
                } else {
                    return false;
                }
            }//Fim do método AtualizarEntidade()

            //Método ListarEntidade()
            public function ListarEntidade() {
                $query = "SELECT id, id_horario FROM reservaEspaco;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListarEntidade()

            //Método ProcurarEntidade()
            public function ProcurarEntidade($id) {
                $query = "SELECT * FROM reservaEspaco WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarEntidade()

            //Método ProcurarAtributoEntidade()
            public function ProcurarAtributoEntidade($id, $valor) {
                $colunasRetornaveis = ['id', 'id_horario', 'id_pessoaJuridica'];
                
                //Verifica se o $valor estar e $colunasRetornaveis
                if (!in_array($valor, $colunasRetornaveis)) {
                    //Se não estiver, retorne false
                    return false;
                }

                $query = "SELECT {$valor} FROM reservaEspaco WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarAtributoEntidade


        }
    }