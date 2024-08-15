<?php
    class DB
    {
        private static $conn = null;
    
        public static function connect()
        {
            if (self::$conn === null) {
                $host = 'localhost';
                $user = 'finapp';
                $pass = 'DBUCFGS';
                $database = 'finapp';
                $port = '3309';
    
                $dsn = "mysql:host={$host};dbname={$database};charset=UTF8;port={$port}";
    
                self::$conn = new PDO($dsn, $user, $pass);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$conn;
        }
    
        public static function beginTransaction()
        {
            self::connect()->beginTransaction();
        }
    
        public static function commit()
        {
            self::connect()->commit();
        }
    
        public static function rollBack()
        {
            self::connect()->rollBack();
        }

        public static function lastInsertId()
        {
            return self::connect()->lastInsertId();
        }
    }
    