<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/DbHelper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/Model.php');

	class CommentsDb {
        public $db;

        public function __construct() {
            $this->db = DbHelper::getInstance();
        }

        public function insertComment($owner, $email, $image, $comment) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "insert into comments values('$owner', '$email', '$image', '$comment', now())";
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
		
        public function getComment($email, $image) {
            $response = new Response();
            try {
                $sql = "select * from comments where email = '$email' and image = '$image' order by UNIX_TIMESTAMP(uploaddate) desc";
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
		
        public function deleteImageComment($email, $image) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "delete from comments where email = '$email' and image = '$image'";
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
		
        public function deleteComment($owner, $uploadDate) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "delete from comments where owner = '$owner' and uploadDate = '$uploadDate'";
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