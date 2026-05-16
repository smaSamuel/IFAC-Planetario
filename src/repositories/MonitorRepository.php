<?php
    namespace web\repositories {

    use web\classes\usuario\monitores\Monitor;
    use web\includes\Database;
    use PDO;
    use web\Interfaces\Repository;

        class MonitorRepository implements Repository{
            private PDO $pdo;

            //Método __construct()
            public function __construct()
            {
                $this->pdo = Database::GetBancoDadosInfos();
            }//Fim do mtodo __construct()

            //Método CriarNovaLinhaTabela()
            public function CriarNovaLinhaTabela($classe, $chave_estrangeira = null) {
                if ($classe instanceof Monitor) {
                    $query = "INSERT INTO monitores (id_usuario, matricula, dataNascimento, cpf) VALUES (?, ?, ?, ?);";
    
                    $stmt = $this->pdo->prepare($query);

                    $stmt->execute([
                        $chave_estrangeira,
                        $classe->GetMatricula(),
                        $classe->GetDataNascimento(),
                        $classe->GetCPF(),
                    ]);
    
                    return $this->pdo->lastInsertId();
                } 

                return false;
            }//Fim do método CriarNovaLinhaTabela()

            //Método RemoverNovaLinhaTabela() 
            public function RemoverNovaLinhaTabela($id) {
                $query = "DELETE FROM monitores WHERE :id = id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }//Fim do método RemoverNovaLinhaTabela()

            //Método AtualizarNovaLinhaTabela()
            public function AtualizarNovaLinhaTabela($id, $classe) {
                if ($classe instanceof Monitor) {
                    $atualCadastro = $this->ProcurarLinhaNaTabela($id);
    
                    $query = "UPDATE monitores SET matricula = :matricula, dataNascimento = :dataNascimento, cpf = :cpf WHERE id = :id;";
    
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute([
                        ':id'           => $id,
                        ':matricula'         => $classe->GetMatricula() ?? $atualCadastro[0]["matricula"],
                        ':dataNascimento'        => $classe->GetDataNascimento() ?? $atualCadastro[0]["dataNascimento"],
                        ':cpf'        => $classe->GetCPF() ?? $atualCadastro[0]["cpf"],
                    ]);
    
                    /*
                        Aparentimente isso PODE tar erro, já que os métodos gets[...]() nunca retorna null
                        Entretando isso AINDA (e espero) não é um problema
                    */
                } else {
                    return false;
                }
            }//Fim do método AtualizarNovaLinhaTabela()

            //Método ListaLinhasTabela()
            public function ListaLinhasTabela() {
                $query = "SELECT id, id_usuario, matricula, dataNascimento FROM monitores;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListaLinhasTabela()

            //Método ProcurarLinhaNaTabela()
            public function ProcurarLinhaNaTabela($id) {
                $query = "SELECT * FROM monitores WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarLinhaNaTabela()

            //Método ProcurarColunaNaTabela()
            public function ProcurarColunaNaTabela($id, $valor) {
                $colunasRetornaveis = ['id', 'id_usuario', 'dataNascimento', 'matricula'];
                
                //Verifica se o $valor estar e $colunasRetornaveis
                if (!in_array($valor, $colunasRetornaveis)) {
                    //Se não estiver, retorne false
                    return false;
                }   

                $query = "SELECT {$valor} FROM monitores;";
            }//Fim do método ProcurarColunaNaTabela

        }
    }