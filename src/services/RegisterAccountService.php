<?php
    namespace web\services {

    use PDO;
    use web\classes\usuario\clientes\ClientePessoaFisica;
    use web\includes\Database;
    use web\repositories\UsuarioPessoaFisicaRepository;
    
        class RegisterAccountService {
            private PDO $pdo;

            // Método __construct()
            public function __construct()
            {
                $this->pdo = Database::GetBancoDadosInfos();
            }// Fim do método __construct()

            // Método __Destruct()
            public function __destruct() {  }

            // Método AccountCreatePessoaFisica()
            public function AccountCreatePessoaFisica($nome , $email, $telefone, $dataNascimento, $cpf, $senha) {
                $new_user = new ClientePessoaFisica($nome , $email, $telefone, $dataNascimento, $cpf, $senha);

                $repo = new UsuarioPessoaFisicaRepository();
                $repo->CriarEntidade($new_user);
                
            }// Fim do método AccountCreatePessoaFisica()
        }
    }