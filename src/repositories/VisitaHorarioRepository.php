<?php
namespace web\repositories {

    use PDO;
    use web\classes\agendamento\Visitacao;
    use web\includes\Database;
    use web\Interfaces\Repository;

        class VisitaHorarioRepository implements Repository {
            private PDO $pdo;

            //Método __construct()
            public function __construct()
            {
                $this->pdo = Database::GetBancoDadosInfos();
            }//Fim do mtodo __construct()

            //Método CriarEntidade()
            public function CriarEntidade($classe) {
                if ($classe instanceof Visitacao) {
                    $query = "INSERT INTO visitas_horario (id id_horario id_cliente_pessoaFisica) VALUES (?, ?, ?);";
    
                    $stmt = $this->pdo->prepare($query);

                    $stmt->execute([
                        $classe->GetId(),
                        $classe->GetHorario()->GetId(),
                        $classe->GetVisitante()->GetId(),
                    ]);
        
                    return $this->pdo->lastInsertId();
                } 

                return false;
            }//Fim do método CriarEntidade()
        
            //Método RemoverEntidade() 
            public function RemoverEntidade($id) {
                $query = "DELETE FROM visitas_horario WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }//Fim do método RemoverEntidade()
    
                 //Método AtualizarEntidade()
            public function AtualizarEntidade($id, $classe) {
                if ($classe instanceof Visitacao) {
                    $atualCadastro = $this->ProcurarEntidade($id);
    
                    $query = "UPDATE visitas_horario SET id = :id, id_horario = :id_horairo, id_cliente_pessoaFisica = :id_cliente_pessoaFisica WHERE id = :id;";
    
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute([
                        ':id'                             => $id,
                        ':id_horario'                     => $classe->GetHorario()->GetId() ?? $atualCadastro[0]["id_horario"],
                        ':id_cliente_pessoaFisica'        => $classe->GetVisitante()->GetId() ?? $atualCadastro[0]["id_cliente_pessoaFisica"],
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
                $query = "SELECT id, id_horario, id_cliente_pessoaFisica FROM visitas_horario;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListarEntidade()

            //Método ProcurarEntidade()
            public function ProcurarEntidade($id) {
                $query = "SELECT * FROM visitas_horario WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarEntidade()

            //Método ProcurarAtributoEntidade()
            public function ProcurarAtributoEntidade($id, $valor) {
                $colunasRetornaveis = ['id', 'id_horario', 'id_cliente_pessoaFisica'];
                
                //Verifica se o $valor estar e $colunasRetornaveis
                if (!in_array($valor, $colunasRetornaveis)) {
                    //Se não estiver, retorne false
                    return false;
                }

                $query = "SELECT {$valor} FROM usuarios WHERE id = :id;";

               $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarAtributoEntidade 

        }
    }