<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ImageDb.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/CommentsDb.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/LikesDB.php');
	$like = new LikesDB();

	if(isset($_POST['likeInfo'])) {
		$likeInfo = $_POST['likeInfo'];
		$emailOwner = explode('/', $likeInfo)[0];
		$image = explode('/', $likeInfo)[1];
		$emailLike = explode('/', $likeInfo)[2];
		$type = explode('/', $likeInfo)[3];
		if($type == 'like')
			$result = $like->insertLike($emailOwner, $image, $emailLike);
		else
			$result = $like->removeLike($emailOwner, $image, $emailLike);

		if($result->status == Response::$SUCCESS) {
			$numLike = $like->getNumLike($emailOwner, $image);
			echo $numLike->data[0] . ' people like this';
		}else if ($result->status == Response::$FAILED) {
			echo $result->message;
		}else {
			echo $result->message;
		}
		
		unset($_POST['likeInfo']);
	}
?>