<?php
    namespace web\includes {
    
    use PDO;

    class Database {
        private static ?PDO $_pdo = null;
        private function __construct() {  }

        public static function GetBancoDadosInfos() : PDO {
            $dbhost = getenv('DB_HOST');
            $dbport = getenv('DB_PORT');
            $dbname = getenv('DB_NAME');
            $dsn = "mysql:host=$dbhost;port=$dbport;dbname=$dbname";
            $dbusername = getenv('DB_USER');
            $dbpassword = getenv('DB_PASS');
        
            if (self::$_pdo === null) {
                self::$_pdo = new PDO(
                    $dsn,
                    $dbusername,
                    $dbpassword,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            }
            
            return self::$_pdo;
        } 
    }
}