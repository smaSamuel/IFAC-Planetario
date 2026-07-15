<?php
    namespace web\repositories {

    use PDO;
    use web\classes\agendamento\SolicitacaoAssistencia;
    use web\includes\Database;
    use web\Interfaces\Repository;

        class solicitacoesAssistentesRepository implements Repository {
            private PDO $pdo;

            //Método __construct()
            public function __construct() {
                $this->pdo = Database::GetBancoDadosInfos();
            }//Fim do método __construct()

            
            //Método CriarEntidade()
            public function CriarEntidade($classe) {
                if ($classe instanceof SolicitacaoAssistencia) {
                    $query = "INSERT INTO solicitacoes_assistentes (id, id_monitor, diaAssistencia, diaSolicitacao) VALUES (?, ?, ?, ?);";
    
                    $stmt = $this->pdo->prepare($query);

                    $stmt->execute([
                        $classe->GetId(),
                        $classe->GetMonitorProfessor(),
                        $classe->GetHorario()->GetData(),
                        $classe->GetDataSolicitacao(),
                    ]);
    
                    return $this->pdo->lastInsertId();
                } 

                return false;
            }//Fim do método CriarEntidade()

            //Método RemoverEntidade() 
            public function RemoverEntidade($id) {
                $query = "DELETE FROM solicitacoes_assistentes WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }//Fim do método RemoverEntidade()

            //Método AtualizarEntidade()
            public function AtualizarEntidade($id, $classe) {
                if ($classe instanceof SolicitacaoAssistencia) {
                    $atualCadastro = $this->ProcurarEntidade($id);
    
                    $query = "UPDATE solicitacoes_assistentes SET id = :id, id_monitor = :id_monitor, diaAssistencia = :diaAssistencia, diaSolicitaca = :diaSolicitaca WHERE id = :id;";
    
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute([
                        ':id'                 => $id,
                        ':id_monitor'         => $classe->GetMonitorProfessor()->GetId() ?? $atualCadastro[0]["id_monitor"],
                        ':diaAssistencia'     => $classe->GetHorario()->GetData() ?? $atualCadastro[0]["diaAssistencia"],
                        ':diaSolicitacao'     => $classe->GetDataSolicitacao() ?? $atualCadastro[0]["diaSolicitacao"],
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
                $query = "SELECT id, id_horario, diaAssistencia, diaSolicitacao FROM usuarios;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListarEntidade()

            //Método ProcurarEntidade()
            public function ProcurarEntidade($id) {
                $query = "SELECT * FROM solicitacoes_assistentes WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarEntidade()

            //Método ProcurarAtributoEntidade()
            public function ProcurarAtributoEntidade($id, $valor) {
                $colunasRetornaveis = ['id', 'id_horario', 'diaAssistencia', 'diaSolicitacao'];
                
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