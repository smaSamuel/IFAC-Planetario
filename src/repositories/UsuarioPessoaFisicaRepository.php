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

            //Método CriarNovaLinhaTabela()
            public function CriarNovaLinhaTabela($classe, $chave_estrangeira = null) {
                if ($classe instanceof ClientePessoaFisica) {
                    $query = "INSERT INTO cliente_pessoaFisica (id_usuario) VALUES (?);";
    
                    $stmt = $this->pdo->prepare($query);

                    $stmt->execute([$chave_estrangeira]);
    
                    return $this->pdo->lastInsertId();
                } 

                return false;
            }//Fim do método CriarNovaLinhaTabela()

            //Método RemoverNovaLinhaTabela() 
            public function RemoverNovaLinhaTabela($id) {
                $query = "DELETE FROM cliente_pessoaFisica WHERE :id = id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }//Fim do método RemoverNovaLinhaTabela()

            //Método AtualizarNovaLinhaTabela()
            public function AtualizarNovaLinhaTabela($id, $classe) {
                if ($classe instanceof ClientePessoaFisica) {
                    $atualCadastro = $this->ProcurarLinhaNaTabela($id);
    
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
            }//Fim do método AtualizarNovaLinhaTabela()

            //Método ListaLinhasTabela()
            public function ListaLinhasTabela() {
                $query = "SELECT * FROM cliente_pessoaFisica;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListaLinhasTabela()

            //Método ProcurarLinhaNaTabela()
            public function ProcurarLinhaNaTabela($id) {
                $query = "SELECT * FROM cliente_pessoaFisica WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarLinhaNaTabela()

            //Método ProcurarColunaNaTabela()
            public function ProcurarColunaNaTabela($id, $valor) {
                $colunasRetornaveis = ['id', 'id_usuario', 'dataNascimento', 'cpf'];
                
                //Verifica se o $valor estar e $colunasRetornaveis
                if (!is_array($valor, $colunasRetornaveis)) {
                    //Se não estiver, retorne false
                    return false;
                }   

                $query = "SELECT {$valor} FROM cliente_pessoaFisica WHERE id = :id;";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarColunaNaTabela
        }

    }