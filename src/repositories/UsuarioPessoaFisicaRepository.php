<?php
    namespace web\repositories {

    use web\includes\Database;
    use PDO;
    use web\classes\usuario\clientes\ClientePessoaFisica;
    use web\Interfaces\Repository;

        class UsuarioPessoaFisicaRepository implements Repository {
            private PDO $pdo;

            //Método __construct()
            public function __construct()
            {
                $this->pdo = Database::GetBancoDadosInfos();
            }//Fim do mtodo __construct()

            //Método CriarEntidade()
            public function CriarEntidade($classe) {
                if ($classe instanceof ClientePessoaFisica) {
                    //Instancia no banco de dados a classe Usuario
                    $chave_estrangeira = new UsuarioRepository();
                    $chave_estrangeira = $chave_estrangeira->CriarEntidade($classe); //Retornar como chave estrangeira o ID do novo usuario

                    $query = "INSERT INTO cliente_pessoaFisica (id_usuario) VALUES (?);";
    
                    $stmt = $this->pdo->prepare($query);

                    $stmt->execute([$chave_estrangeira]);
    
                    return $this->pdo->lastInsertId();
                } 

                return false;
            }//Fim do método CriarEntidade()

            //Método RemoverEntidade() 
            public function RemoverEntidade($id) {
                $query = "DELETE FROM cliente_pessoaFisica WHERE :id = id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }//Fim do método RemoverEntidade()

            //Método AtualizarEntidade()
            public function AtualizarEntidade($id, $classe) {
                if ($classe instanceof ClientePessoaFisica) {
                    $atualCadastro = $this->ProcurarEntidade($id);
    
                    $query = "UPDATE cliente_pessoaFisica SET dataNascimento = :dataNascimento, cpf = :cpf WHERE id = :id;";
    
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute([
                        ':id'                     => $id,
                        ':dataNascimento'         => $classe->GetDataNascimento() ?? $atualCadastro[0]["dataNascimento"],
                        ':cpf'                    => $classe->GetCPF() ?? $atualCadastro[0]["cpf"],
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
                $query = "SELECT * FROM cliente_pessoaFisica;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListarEntidade()

            //Método ProcurarEntidade()
            public function ProcurarEntidade($id) {
                $query = "SELECT * FROM cliente_pessoaFisica WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarEntidade()

            //Método ProcurarAtributoEntidade()
            public function ProcurarAtributoEntidade($id, $valor) {
                $colunasRetornaveis = ['id', 'id_usuario', 'dataNascimento', 'cpf'];
                
                //Verifica se o $valor estar e $colunasRetornaveis
                if (!in_array($valor, $colunasRetornaveis)) {
                    //Se não estiver, retorne false
                    return false;
                }   

                $query = "SELECT {$valor} FROM cliente_pessoaFisica WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarAtributoEntidade
        }

    }