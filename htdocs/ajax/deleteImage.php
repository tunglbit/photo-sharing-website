<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ImageDb.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/LikesDb.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/CommentsDb.php');
	$imageDb = new ImageDb();
	$likeDb = new LikesDb();
	$commentDb = new CommentsDb();

	if(isset($_POST['email']) && isset($_POST['image'])) {
		$email = $_POST['email'];
		$image = $_POST['image'];
		
		$result = $imageDb->deleteImage($image, $email);
		if ($result->status == Response::$SUCCESS) {
			
		}else if ($result->status == Response::$FAILED) {
			echo $result->message;
		}else {
			echo $result->message;
		}
		
		$result2 = $likeDb->deleteImageLike($email, $image);
		if ($result2->status == Response::$SUCCESS) {
			
		}else if ($result2->status == Response::$FAILED) {
			echo $result2->message;
		}else {
			echo $result2->message;
		}
		
		$result3 = $commentDb->deleteImageComment($email, $image);
		if ($result3->status == Response::$SUCCESS) {
			
		}else if ($result3->status == Response::$FAILED) {
			echo $result3->message;
		}else {
			echo $result3->message;
		}
		
		$path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $email . "/" . $image;
		unlink($path);
		
		unset($_POST['email']);
		unset($_POST['image']);
	}
?>