<?php
    namespace web\repositories {

    use web\classes\usuario\Administrador;
    use web\includes\Database;
    use PDO;
    use Reflector;
    use web\Interfaces\Repository;

        class AdministradorRepository implements Repository{
            private PDO $pdo;

            //Método __construct()
            public function __construct()
            {
                $this->pdo = Database::GetBancoDadosInfos();
            }//Fim do mtodo __construct()

            //Método CriarNovaLinhaTabela()
            public function CriarNovaLinhaTabela($classe) {
                if ($classe instanceof Administrador) {
                    $query = "INSERT INTO administradores (nome, email, telefone, dataNascimento, cpf, senha) VALUES (?, ?, ?, ?, ?, ?);";
    
                    $stmt = $this->pdo->prepare($query);

                    $stmt->execute([
                        $classe->GetNome(),
                        $classe->GetEmail(),
                        $classe->GetTelefone(),
                        $classe->getDataNascimento(),
                        $classe->getCPF(),
                        $classe->GetSenha(),
                    ]);
    
                    return $this->pdo->lastInsertId();
                } 

                return false;
            }//Fim do método CriarNovaLinhaTabela()

            //Método RemoverLinhaTabela() 
            public function RemoverLinhaTabela($id) {
                $query = "DELETE FROM administradores WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }//Fim do método RemoverLinhaTabela()

            //Método AtualizarNovaLinhaTabela()
            public function AtualizarNovaLinhaTabela($id, $classe) {
                if ($classe instanceof Administrador) {
                    $atualCadastro = $this->ProcurarLinhaNaTabela($id);
    
                    $query = "UPDATE administradores SET nome = :nome, email = :email, telefone = :telefone, senha = :senha WHERE id = :id;";
    
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute([
                        ':id'           => $id,
                        ':nome'         => $classe->GetNome() ?? $atualCadastro[0]["nome"],
                        ':email'        => $classe->GetEmail() ?? $atualCadastro[0]["email"],
                        ':telefone'     => $classe->GetTelefone() ?? $atualCadastro[0]["telefone"],
                        ':senha'        => $classe->GetSenha() ?? $atualCadastro[0]["senha"],
                    ]);
    
                    /*
                        Aparentimente isso PODE tar erro, já que os métodos gets[...]() nunca retorna null
                        Entretando isso AINDA (e espero) não é um problema
                        -01:28 da manhã 
                    */
                } else {
                    return false;
                }
            }//Fim do método AtualizarNovaLinhaTabela()

            //Método ListaLinhasTabela()
            public function ListaLinhasTabela() {
                $query = "SELECT id, nome, email, telefone FROM administradores;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListaLinhasTabela()

            //Método ProcurarLinhaNaTabela()
            public function ProcurarLinhaNaTabela($id) {
                $query = "SELECT * FROM administradores WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarLinhaNaTabela()

            //Método ProcurarColunaNaTabela()
            public function ProcurarColunaNaTabela($id, $valor) {
                $colunasRetornaveis = ['id', 'nome', 'email', 'telefone'];
                
                //Verifica se o $valor estar e $colunasRetornaveis
                if (!in_array($valor, $colunasRetornaveis)) {
                    //Se não estiver, retorne false
                    return false;
                }

                $query = "SELECT {$valor} FROM administradores WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarColunaNaTabela
        }
    }