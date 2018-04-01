<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/DbHelper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/Model.php');

	class AccountDB {
        public $db;

        public function __construct() {
            $this->db = DbHelper::getInstance();
        }

        public function checkExistAccount($username, $password) {
            $response = new Response();
			if($username == '' || $password == '') {
				$response->message = "Wrong Username or Password!";
				$response->status = Response::$FAILED;
				return $response;
			}
            try {
                $sql = "select * from account where (username = '$username' or email = '$username') and password = '$password'";
                $param = array();
                $result = $this->db->get($sql, $param);
                if($result == Response::$FAILED) {
                    $response->status = Response::$FAILED;
                    $response->message = "Sai Username hoặc Password";
                }else {
                    $response->status = Response::$SUCCESS;
                    $response->message = "Đăng nhập thành công";
                    $response->data = $result[0];
                }
            }catch (Exception $e) {
                $response->status = Response::$ERROR;
                $response->message = $e->getMessage();
            }
            return $response;
        }

        public function checkExistEmail($email) {
            $response = new Response();
            try {
                $sql = "select * from account where email = '$email'";
                $param = array();
                $result = $this->db->get($sql, $param);
                if($result == Response::$FAILED) {
                    $response->status = Response::$FAILED;
                    $response->message = "Sai Username hoặc Password";
                }else {
                    $response->status = Response::$SUCCESS;
                    $response->message = "Đăng nhập thành công";
                    $response->data = $result[0];
                }
            }catch(Exception $e) {
                $response->status = Response::$ERROR;
                $response->message = $e->getMessage();
            }
            return $response;
        }
		
		public function getAccount() {
            $response = new Response();
            try {
                $sql = "select email, role from account";
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
            }catch(Exception $e) {
                $response->status = Response::$ERROR;
                $response->message = $e->getMessage();
            }
            return $response;
        }
		
		public function getRole($email) {
            $response = new Response();
            try {
                $sql = "select role from account where email = '$email'";
                $param = array();
                $result = $this->db->get($sql, $param);
                if ($result == Response::$FAILED){
                    $response->status = Response::$FAILED;
                    $response->message = "Thất bại";
                }else{
                    $response->status = Response::$SUCCESS;
                    $response->message = "Thành công";
                    $response->data = $result[0];
                }
            }catch(Exception $e) {
                $response->status = Response::$ERROR;
                $response->message = $e->getMessage();
            }
            return $response;
        }
		
		public function setRole($email, $role) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "update account set role = '$role' where email = '$email'";
                if($conn->query($sql) == TRUE) 
                    $response->status = Response::$SUCCESS;
                else
                    $response->status = Response::$FAILED;
            }catch(Exception $e) {
                $response->status = Response::$ERROR;
                $response->message = $e->getMessage();
            }
            return $response;
        }
    }
?>