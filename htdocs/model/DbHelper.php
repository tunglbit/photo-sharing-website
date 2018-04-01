<?php
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    //define("DB_PASSWORD", "Gatrong123");
    define("DB_PASSWORD", "");
    define("DB_DATABASE", "PhotoSharing");

    class DbHelper {
        private static $instance;
        public $conn;

        private function __construct() {
            $this->conn = new PDO("mysql:host=" .DB_HOST. ";dbname=" .DB_DATABASE, DB_USER, DB_PASSWORD);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }

        public static function getInstance() {
            if (self::$instance == null)
                self::$instance = new DbHelper();
            return self::$instance;
        }

        function __destruct() {
            $this->conn = null;
        }

        function close() {
            $this->conn = null;
        }

        function getConnection() {
            return $this->conn;
        }

        public function get($sql, $param) {
            try {
                $command = $this->conn->prepare($sql);
                $status = $command->execute($param);
                if ($status && $command->rowCount()>0)
                    return $command->fetchAll();
                else 
					return Response::$FAILED;
            }catch(PDOException $e) {
                throw $e;
            }
        }

        public function executeSqlMultipleParam($sql, $param) {
            try {
                $command = $this->conn->prepare($sql);
                $status = $command->execute($param);
                if($status == TRUE)
                    return Response::$SUCCESS;
                else
                    return Response::$FAILED;
            }catch(PDOException $e) {
                throw $e;
            }
        }
    }
?>
