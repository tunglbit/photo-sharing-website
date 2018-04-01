<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/DbHelper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/Model.php');

	class ThemesDb {
        public $db;

        public function __construct() {
            $this->db = DbHelper::getInstance();
        }

        public function insertTheme($name) {
            $response = new Response();
			if($name == '') {
                $response->status = Response::$FAILED;
				return $response;
			}
            try {
                $conn = $this->db->conn;
                $sql = "insert into theme values('$name')";
                if($conn->query($sql) == TRUE) {
                    $response->status = Response::$SUCCESS;
                }
                else {
                    $response->status = Response::$FAILED;
                }
            }catch (Exception $e) {
                $response->status = Response::$ERROR;
                $response->message = $e->getMessage();
            }
            return $response;
        }
		
        public function getTheme() {
            $response = new Response();
            try {
                $sql = "select * from theme";
                $param = array();
                $result = $this->db->get($sql, $param);
                if($result == Response::$FAILED) {
                    $response->status = Response::$FAILED;
                    $response->message = "Thất bại";
                }else {
                    $response->status = Response::$SUCCESS;
                    $response->message = "Thành công";
                    $response->data = $result;
                }
            }catch (Exception $e) {
                $response->status = Response::$ERROR;
                $response->message = $e->getMessage();
            }
            return $response;
        }
		
        public function deleteTheme($name) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "delete from theme where name = '$name'";
                if($conn->query($sql) == TRUE) {
                    $response->status = Response::$SUCCESS;
                }
                else {
                    $response->status = Response::$FAILED;
                }
            }catch (Exception $e) {
                $response->status = Response::$ERROR;
                $response->message = $e->getMessage();
            }
            return $response;
        }
		
    }
?>