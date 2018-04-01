<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ThemesDb.php');
	$theme = new ThemesDb();

	if(isset($_POST['name'])) {
		$name = $_POST['name'];
		
		$result = $theme->deleteTheme($name);
		if ($result->status == Response::$SUCCESS) {
			
		}else if ($result->status == Response::$FAILED) {
			echo $result->message;
		}else {
			echo $result->message;
		}
		
		unset($_POST['name']);
	}
?>