<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/DbHelper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/Model.php');

	class LikesDb {
		public $db;

		public function __construct() {
			$this->db = DbHelper::getInstance();
		}
			
		public function getAll() {
			$response = new Response();
			try {
				$sql = "select * from likes";
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
			
		public function insertLike($emailOwner, $image, $emailLike) {
			$response = new Response();
			try {
				$sql = "insert into likes values(?, ?, ?)";
				$param = array($emailOwner, $image, $emailLike);
				$result = $this->db->executeSqlMultipleParam($sql, $param);
				if($result == Response::$FAILED) {
					$response->status = Response::$FAILED;
					$response->message = "Thất bại";
				}else {
					$response->status = Response::$SUCCESS;
					$response->message = "Thành công";
				}
			}catch(Exception $e) {
				$response->status = Response::$ERROR;
				$response->message = $e->getMessage();
			}
			return $response;
		}
		
		public function removeLike($emailOwner, $image, $emailLike) {
			$response = new Response();
			try {
				$sql = "delete from likes where emailOwner = ? and image = ? and emailLike = ?";
				$param = array($emailOwner, $image, $emailLike);
				$result = $this->db->executeSqlMultipleParam($sql, $param);
				if($result == Response::$FAILED) {
					$response->status = Response::$FAILED;
					$response->message = "Xóa thông tin không thành công";
				}else {
					$response->status = Response::$SUCCESS;
					$response->message = "Xóa thông tin thành công";
				}
			}catch(Exception $e) {
				$response->status = Response::$ERROR;
				$response->message = $e->getMessage();
			}
			return $response;
		}
		
        public function deleteImageLike($emailOwner, $image) {
            $response = new Response();
            try {
                $conn = $this->db->conn;
                $sql = "delete from likes where emailOwner = '$emailOwner' and image = '$image'";
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
		
		public function checkExistLike($emailOwner, $image, $emailLike) {
			$response = new Response();
			try {
				$sql = "select * from likes where emailOwner = '$emailOwner' and image = '$image' and emailLike = '$emailLike'";
				$param = array();
				$result = $this->db->get($sql, $param);
				if($result == Response::$FAILED) {
					$response->status = Response::$FAILED;
					$response->message = "Không tồn tại lượt thích";
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

		public function getNumLike($emailOwner, $image) {
			$response = new Response();
			try {
				$sql = "select COUNT(*) from likes where emailOwner = '$emailOwner' and image = '$image'";
				$param = array();
				$result = $this->db->get($sql, $param);
				if($result == Response::$FAILED) {
					$response->status = Response::$FAILED;
					$response->message = "Không tồn tại lượt thích";
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
	}
?>