<?php 
    namespace web\services {

    use PDO;
    use web\includes\Database;
    
    class AuthService {
            private PDO $pdo;

            //Método __construct()
            public function __construct() {
                $this->pdo = Database::GetBancoDadosInfos();
            }//Fim do Método __construct()

            //Método __destruct()
            public function __destruct() { }//Fim do Método __destruct()

            //Função Chamar Login do Usuário()
            private function verificar_login_usuario ($login) {
                $hashlogin = hash_hmac('sha256', $login, getenv('HASH_SECRET_KEY'));
                $query = "SELECT * FROM cliente_pessoaFisica WHERE cpf =:cpf;";
                $stmt = $this->pdo->prepare($query);
                $stmt-> execute ([':cpf' => $hashlogin]);
                return $stmt-> fetchAll(PDO::FETCH_ASSOC);
            }//Fim da Função Chamar Login do Usuário()

            //Função Chamar Login dos Monitores()
            private function verificar_login_monitor ($login) {
                $hashlogin = hash_hmac('sha256', $login, getenv('HASH_SECRET_KEY'));
                $query = "SELECT * FROM monitores WHERE cpf =:cpf;";
                $stmt = $this->pdo->prepare($query);
                $stmt-> execute ([':cpf' => $hashlogin]);
                return $stmt-> fetchAll(PDO::FETCH_ASSOC);
            }//Fim da Função Chamar Login dos Monitores()
        
            //Função Chamar Login dos Administradores()
            private function verificar_login_administrador ($login) {
                $hashlogin = hash_hmac('sha256', $login, getenv('HASH_SECRET_KEY'));
                $query = "SELECT * FROM administradores WHERE cpf =:cpf;";
                $stmt = $this->pdo->prepare($query);
                $stmt-> execute ([':cpf' => $hashlogin]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }//Fim da Função Chamar Login dos Administradores()

            //Funçãp Autorizar Acesso aos Monitores e Administradores
            public function autorizar_acesso($login, $senha) {
                    $login = str_replace(['-','.'],'', $login);
                    $verificar_login = $this->verificar_login_usuario($login);

                    if ($verificar_login) {//Verificação do Login do Usuário
                            if (password_verify($senha, $verificar_login[0]['senha'])) {
                                return $verificar_login[0]['id'];
                            } else {
                                return null;
                            }
                        }

                    $verificar_login = $this->verificar_login_monitor($login);

                    if ($verificar_login) {//Verificação do Login do monitor
                            if (password_verify($senha, $verificar_login[0]['senha'])) {
                                return $verificar_login[0]['id'];
                            } else {
                                return null;
                            }
                        }

                    $verificar_login = $this-> verificar_login_administrador($login);

                    if ($verificar_login) {//Verificação do Login do administrador
                            if (password_verify($senha, $verificar_login[0]['senha'])) {
                                return $verificar_login[0]['id'];
                            } else {
                                return null;
                            }
                        }

                    return null;
                }

    }//Fim da Classe AuthService
}