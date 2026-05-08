<?php
    namespace web\repositories {

    use web\classes\usuario\Administrador;
    use web\includes\Database;
    use PDO;
        
        class AdministradorRepository{
            private PDO $_pdo;

            public function __construct() {
                $this->_pdo = Database::GetBancoDadosInfos();
            }

            //Método AdicionarAdministrador()
            public function AdicionarAdministrador(Administrador $administrador) {
                $query = "INSERT INTO administradores (nome, email, telefone, dataNascimento, cpf, senha) VALUES (?, ?, ?, ?, ?, ?);";
                    
                $stmt = $this->_pdo->prepare($query);

                $stmt->execute([
                    $administrador->getNome(),
                    $administrador->getEmail(),
                    $administrador->getTelefone(),
                    $administrador->getDataNascimento(),
                    $administrador->getCPF(),
                    $administrador->getSenha()
                ]); 
                    
            }//Fim do método AdicionarAdministrador()

            //Método RemoverAdministradorr()
            public function RemoverAdministrador($id) {
                $query = "DELETE FROM administradores WHERE id = :id;";
                    
                $stmt = $this->_pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute(); 
                
            }//Fim método RemoverAdministrador()

            //Método AlterarCadastroAdministrador()
            public function AlterarCadastroAdministrador($id, Administrador $administrador) {
                $atualCadastro = $this->ProcurarAdministrador($id);

                $query = "UPDATE administradores SET nome = :nome, email = :email, senha = :senha, telefone = :telefone, dataNascimento = :dataNascimento WHERE id = :id;";
                    
                $stmt = $this->_pdo->prepare($query);

                $stmt->execute([
                    ':id'                   => $id,
                    ':nome'                 => $administrador->getNome() ?? $atualCadastro[0]["nome"],
                    ':email'                => $administrador->getEmail() ?? $atualCadastro[0]["email"],
                    ':senha'                => $administrador->getSenha() ?? $atualCadastro[0]["senha"],
                    ':telefone'             => $administrador->getTelefone() ?? $atualCadastro[0]["telefone"],
                    ':dataNascimento'       => $administrador->getDataNascimento() ?? $atualCadastro[0]["dataNascimento"]
                ]); 

                /*
                    Aparentimente isso PODE tar erro, já que os métodos gets[...]() nunca retorna null
                    Entretando isso AINDA (e espero) não é um problema
                    -01:28 da manhã 
                */
            }//Fim do método AlterarCadastroAdministrador()

            //Método ListarAdministradores()
            public function ListarAdministradores() {
                $query = "SELECT id, nome, email FROM administradores;";
                    
                $stmt = $this->_pdo->prepare($query);

                $stmt->execute(); 
                             
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ListarAdministradores()

            //Método ProcurarAdministrador()
            public function ProcurarAdministrador($id) {
                $query = "SELECT * FROM administradores WHERE id = :id; ";
                    
                $stmt = $this->_pdo->prepare($query);
                $stmt->execute([
                    ':id'   => $id,
                ]); 
                                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarAdministrador()

            //Método ProcurarAtributoAdministrador()
            public function ProcurarAtributoAdministrador($id, $valor) {
                $colunasRetornaveis = ['id', 'nome', 'email', 'telefone', 'dataNascimento'];

                //Verifica se o $valor estar e $colunasRetornaveis
                if (!in_array($valor, $colunasRetornaveis)) {
                    //Se não estiver, retorne false
                    return false; 
                }

                $query = "SELECT {$valor} FROM administradores WHERE id = :id; ";
                    
                $stmt = $this->_pdo->prepare($query);
                $stmt->execute([':id' => $id]); 
                           
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim do método ProcurarAtributoAdministrador()

            //Método VerificarLogin()
            public function VerificarLogin($login) {
                $hashLogin = hash_hmac('sha256', $login, getenv('HASH_SECRET_KEY'));
                
                $query = "SELECT * FROM administradores WHERE cpf = :cpf";
                    
                $stmt = $this->_pdo->prepare($query);
                $stmt->execute([
                    ':cpf'        => $hashLogin,
                ]); 

                return $stmt->fetchAll(PDO::FETCH_ASSOC);          
            }//Fim do método VerificarLogin()

            //Método AutorizarAcesso()
            public function AutorizarAcesso($login, $senha) {
                $login = str_replace(['-', '.'], '', $login);
                $verificarLogin = $this->VerificarLogin($login);
                //Verifica se o login foi encontrado
                if($verificarLogin) {
                    //Se sim, verifica se a senha estar correta
                    if (password_verify($senha, $verificarLogin[0]['senha'])) {
                        echo 'Bem vindo ' . $verificarLogin[0]['nome'];
                    } else {
                        //Se não, devolve false
                        return false;
                    }
                } else {
                    //Se não, devolve false
                    return false;
                }
            }//Fim do método AutorizarAcesso()
        }
    }