<?php
    namespace web\repositories {

    use web\classes\usuario\Administrador;
    use web\includes\Database;
    use PDO;
        
        class AdministradorRepository{
            private PDO $_pdo;
        
            private array $_Administradores = [];

            public function __construct() {
                $this->_pdo = Database::GetBancoDadosInfos();
            }

            //Método AdicionarAdministrador()
            public function AdicionarAdministrador($nome, $telefone, $email, $cpf, $dataNascimento) {
                $query = "INSERT INTO administradores (nome, email, senha, telefone, dataNascimento) VALUES (?, ?, ?, ?, ?);";
                    
                $stmt = $this->_pdo->prepare($query);

                $stmt->execute([$nome, $email, '12345', $telefone, $dataNascimento]);
                    
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }//Fim do método AdicionarAdministrador()

            //Método RemoverAdministradorr()
            public function RemoverAdministrador(Administrador $administrador) {
                foreach ($this->_Administradores as $key => $curret) {
                    if ($administrador === $curret) { //Encontra o administrador que será removido 
                        unset($this->_Administradores[$key]);
                        break;
                    }
                }
            }//Fim método RemoverAdministrador()

            //Método AlterarCadastroAdministrador()
            public function AlterarCadastroAdministrador(Administrador $administrador) {
                foreach ($this->_Administradores as $key => $curret) {
                    /*
                        IMPLEMENTAR LÓGICA DEPOIS
                    */
                }
            }//Fim do método AlterarCadastroAdministrador()

            //Método ListarAdministradores()
            public function ListarAdministradores() {
                return $this->_Administradores;
            }//Fim do método ListarAdministradores()

        }
    }