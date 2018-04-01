<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/DbHelper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/Model.php');

    class registerDB {
        public $db;

        public function __construct() {
            $this->db = DbHelper::getInstance();
        }

        /**
         * @param $username
         * @param $email
         * @param $password
         * @return Response
         */
        public function get($username, $email, $password) {
            $response = new Response();
			if($username == '' || $password == '' || $email == '') {
				echo '<Center>
						<div class="panel panel-danger" style="width: 27.5%">
						  <div class="panel-heading">Please fill in all fields!</div>
						</div>
					  </Center>';
				$response->message = "Please fill in all fields!";
				$response->status = Response::$FAILED;
				return $response;
			}
            try {
                $conn = $this->db->conn;
                $sql = "insert into account values('$username', '$email', '$password', 'User')";
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
		
		public function getGoogle($username, $email) {
            $response = new Response();
			if($username == '' || $email == '') {
				$response->message = 'Please choose "Get Google Account Information"';
				$response->status = Response::$FAILED;
				return $response;
			}
            try {
                $conn = $this->db->conn;
                $sql = "insert into account values('$username', '$email', '', 'User')";
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

        public function getFacebook($username, $email) {
            $response = new Response();
            if($username == '' || $email == '') {
				$response->message = 'Please choose "Get Facebook Account Information"';
                $response->status = Response::$FAILED;
                return $response;
            }
            try {
                $conn = $this->db->conn;
                $sql = "insert into account values('$username', '$email', '', 'User')";
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