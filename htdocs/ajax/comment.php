<?php
    session_start();
    $name = $_SESSION['accountEmail'];
	  
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
	$acc = new AccountDB();
	$result = $acc->getRole($name);
	$role = $result->data[0];
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/CommentsDb.php');
	$cmtDb = new CommentsDb();

	if(isset($_POST['theComment'])) {
		$comment = $_POST['theComment'];
		$commentInfo = $_POST['commentInfo'];
		$email = explode('/', $commentInfo)[0];
		$owner = explode('/', $commentInfo)[1];
		$image = explode('/', $commentInfo)[2];
		if($comment != '') {
			$comment = str_replace("\n", "<br>", $comment);
			$result = $cmtDb->insertComment($email, $owner, $image, $comment);
			if($result->status == Response::$SUCCESS) {
				echo '</div>';
			}else if($result->status == Response::$FAILED) {
				echo "<script>showError()</script>";
			}else {
				echo "<script>showError()</script>";
			}
		}
		$result2 = $cmtDb->getComment($owner, $image);
			if($result2->status == Response::$SUCCESS) {
				foreach($result2->data as $item) {
					$deleteCommentPermission = false;
					if($item['owner'] == $name)
						$deleteCommentPermission = true;
					else {
						$deleteCommentPermission = false;
					}
					if($role != 'User')
						$deleteCommentPermission = true;
					echo '<form method="POST"><div class="panel panel-primary" style="text-align: left;margin-bottom: 5px;margin-left: 5px;margin-right: 5px">
							<div class="panel-heading" style="padding-left: 5px;height: 36px; padding-top: 0px; padding-bottom: 0px"><a class="alignleft2" style="padding-top: 10px" href="showUser.php?owner=' . $item['owner'] . '" style="color: white;"><b>' . $item['owner'] . '</b></a>
							<p class="aligncenter2" style="padding-top: 10px">' . $item['uploadDate'] . '</p>'; if($deleteCommentPermission == true) {echo '<p class="alignright2"><button type="button" id="deleteCommentButton" class="btn btn-danger" onclick="deleteComment_ajax(' . "'" . $item['owner'] . "', '" . $item['uploadDate'] . "', '" . $owner . "', '" . $image . "'" . ')" style="padding-top: 0px;padding-bottom: 0px">Remove</button></p>';} echo '</div>
							<div style="clear: both;"></div>
							<div class="panel-body" style=" padding:5px;overflow: auto">' . $item['comment'] . '</div>
						  </div></form>';
				}
			}else if($result2->status == Response::$FAILED) {
				echo "<script>showError()</script>";
			}else {
				echo "<script>showError()</script>";
			}
			
		unset($_POST['theComment']);
		unset($_POST['commentInfo']);
	}
?>