<?php
    namespace web\repositories {

    use web\includes\Database;
    use PDO;
    use web\classes\usuario\monitores\MonitorProfessor;
    use web\Interfaces\Repository;

        class MonitorProfessorRepository implements Repository {
            private PDO $pdo;

            //Método __construct()
            public function __construct()
            {
                $this->pdo = Database::GetBancoDadosInfos();
            }//Fim do mtodo __construct()

            //Método CriarNovaLinhaTabela()
            public function CriarNovaLinhaTabela($classe, $chave_estrangeira = null) {
                if ($classe instanceof MonitorProfessor) {
                    $query = "INSERT INTO monitores_professores (id_monitor) VALUES (?);";
    
                    $stmt = $this->pdo->prepare($query);

                    $stmt->execute([$chave_estrangeira]);
    
                    return $this->pdo->lastInsertId();
                } 

                return false;
            }//Fim do método CriarNovaLinhaTabela()

            //Método RemoverNovaLinhaTabela() 
            public function RemoverNovaLinhaTabela($id) {
                $query = "DELETE FROM monitores_professores WHERE :id = id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }//Fim do método RemoverNovaLinhaTabela()

            //Método AtualizarNovaLinhaTabela()
            public function AtualizarNovaLinhaTabela($id, $classe) {
                return false; //Não à o que atualizar
            }//Fim do método AtualizarNovaLinhaTabela()

            //Método ListaLinhasTabela()
            public function ListaLinhasTabela() {
                $query = "SELECT * FROM monitores_professores;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListaLinhasTabela()

            //Método ProcurarLinhaNaTabela()
            public function ProcurarLinhaNaTabela($id) {
                $query = "SELECT * FROM monitores_professores WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarLinhaNaTabela()

            //Método ProcurarColunaNaTabela()
            public function ProcurarColunaNaTabela($id, $valor) {
                $colunasRetornaveis = ['id', 'id_monitor'];
                
                //Verifica se o $valor estar e $colunasRetornaveis
                if (!is_array($valor, $colunasRetornaveis)) {
                    //Se não estiver, retorne false
                    return false;
                }   

                $query = "SELECT {$valor} FROM monitores_professores WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarColunaNaTabela
        }

    }