<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/DbHelper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/Model.php');
	
    class ImageDb {
        public $db;

        public function __construct() {
            $this->db = DbHelper::getInstance();
        }

        public function getAll() {
            $response = new Response();
            try {
                $sql = "select * from image order by UNIX_TIMESTAMP(uploaddate) desc";
                $param = array();
                $result = $this->db->get($sql, $param);
                if($result == Response::$FAILED){
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

        public function getImageByTheme($theme) {
            $response = new Response();
            try {
                $sql = "select * from image where theme = '$theme' order by UNIX_TIMESTAMP(uploaddate) desc";
                $param = array();
                $result = $this->db->get($sql, $param);
                if ($result == Response::$FAILED) {
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
		
		public function getTheme($name, $owner) {
            $response = new Response();
            try {
                $sql = "select theme from image where name = '$name' and owner = '$owner'";
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
		
		public function setTheme($name, $owner, $theme) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "update image set theme = '$theme' where name = '$name' and owner = '$owner'";
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

        public function insertImage($name, $owner, $uploaddate) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "insert into image values('$name', '$owner', 'Uncategorized', now(), 0, 0)";
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
		
		public function deleteImage($name, $owner) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "delete from image where name = '$name' and owner = '$owner'";
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

        public function increaseView($name, $owner) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "update image set noview = noview + 1 where name = '$name' and owner = '$owner'";
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
		
		public function decreaseView($name, $owner) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "update image set noview = noview - 1 where name = '$name' and owner = '$owner'";
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
		
		public function getNoView($name, $owner) {
            $response = new Response();
            try {
                $sql = "select noview from image where name = '$name' and owner = '$owner'";
                $param = array();
                $result = $this->db->get($sql, $param);
                if ($result == Response::$FAILED) {
                    $response->status = Response::$FAILED;
                    $response->message = "Thất bại";
                }else {
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
		
        public function increaseDownload($name, $owner) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "update image set noDownload = noDownload + 1 where name = '$name' and owner = '$owner'";
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
		
		public function getNoDownload($name, $owner) {
            $response = new Response();
            try {
                $sql = "select nodownload from image where name = '$name' and owner = '$owner'";
                $param = array();
                $result = $this->db->get($sql, $param);
                if($result == Response::$FAILED) {
                    $response->status = Response::$FAILED;
                    $response->message = "Thất bại";
                }else {
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

        public function searchImage($keyword, $theme) {
            $response = new Response();
            try {
                if($theme == 'All'){
                    $sql = "select * from image where name LIKE '%$keyword%' or owner LIKE '%$keyword%' order by UNIX_TIMESTAMP(uploaddate) desc";
                }
                else $sql = "select * from image where (name LIKE '%$keyword%' or owner LIKE '%$keyword%') and theme = '$theme' order by UNIX_TIMESTAMP(uploaddate) desc";
                $param = array();
                $result = $this->db->get($sql, $param);
                if($result == Response::$FAILED){
                    $response->status = Response::$FAILED;
                    $response->message = "Không tìm thấy ảnh với từ khóa bạn yêu cầu.";
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
    }
?>