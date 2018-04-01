<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
	$acc = new AccountDb();

	if(isset($_POST['role']) && isset($_POST['email'])) {
		$role = $_POST['role'];
		$email = $_POST['email'];
		
		$result = $acc->setRole($email, $role);
		if ($result->status == Response::$SUCCESS) {
			return $email;
		}else if ($result->status == Response::$FAILED) {
			echo $result->message;
		}else {
			echo $result->message;
		}
		
		unset($_POST['roleInfo']);
	}
?>