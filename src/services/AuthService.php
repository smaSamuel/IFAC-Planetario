<?php
    namespace web\services {

        class AuthService {
            
        }
    }


/*

            //Método VerificarLogin()
            private function VerificarLogin($login) {
                $hashLogin = hash_hmac(getenv('HASH_ALGORITHM'), $login, getenv('HASH_SECRET_KEY'));
                
                $query = "SELECT * FROM administradores WHERE cpf = :cpf";
                    
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([
                    ':cpf'        => $hashLogin,
                ]); 

                return $stmt->fetchAll(PDO::FETCH_ASSOC); //Retorna Null caso não encontre       
            }//Fim do método VerificarLogin()

            //Método AutorizarAcesso()
            protected function AutorizarAcesso($login, $senha) {
                $login = str_replace(['-', '.'], '', $login);
                $verificarLogin = $this->VerificarLogin($login);
                //Verifica se o login foi encontrado
                if($verificarLogin) {
                    //Se sim, verifica se a senha estar correta
                    if (password_verify($senha, $verificarLogin[0]['senha'])) {
                        return $verificarLogin[0]['id']; //Retornar ID
                    } else {
                        //Se não, devolve nulo
                        return null;
                    }
                } 

                return null;
            }//Fim do método AutorizarAcesso()

*/