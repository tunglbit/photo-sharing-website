<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ImageDb.php');
	$img = new ImageDb();

	if(isset($_POST['themeInfo'])) {
		$themeInfo = $_POST['themeInfo'];
		$owner = explode('/', $themeInfo)[0];
		$image = explode('/', $themeInfo)[1];
		$theme = $_POST['theme'];
		
		$result = $img->setTheme($image, $owner, $theme);
		if ($result->status == Response::$SUCCESS) {
			
		}else if ($result->status == Response::$FAILED) {
			echo $result->message;
		}else {
			echo $result->message;
		}
		
		unset($_POST['themeInfo']);
		unset($_POST['theme']);
	}
?>