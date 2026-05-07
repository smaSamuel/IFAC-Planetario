<?php
    namespace web\includes {
    
    use PDO;

    class Database {
        private static ?PDO $_pdo = null;
        private function __construct() {  }

        public static function GetBancoDadosInfos() : PDO {
            // Verifica se já há conexão com o db
            if (self::$_pdo === null) { //Se não houver
                //Retornar as variaveis do ambiente
                $dbhost = getenv('DB_HOST');
                $dbport = getenv('DB_PORT');
                $dbname = getenv('DB_NAME');
                $dbusername = getenv('DB_USER');
                $dbpassword = getenv('DB_PASS');
                
                $dsn = "mysql:host=$dbhost;port=$dbport;dbname=$dbname;charset=utf8mb4"; 
                //Crie a conexãp
                self::$_pdo = new PDO(
                    $dsn,
                    $dbusername,
                    $dbpassword,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            }
            
            return self::$_pdo; //Retorne a conexão
        } 
    }
}