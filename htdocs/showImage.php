<?php
    session_start();
	if(!isset($_SESSION['accountEmail']))
		header("Location: login.php");
	
	ob_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ImageDb.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/CommentsDb.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/LikesDB.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ThemesDb.php');
	$imgDb = new ImageDb();
	$cmtDb = new CommentsDb();
	$like = new LikesDB();
	$themeDb = new ThemesDb();
    $email = $_SESSION['accountEmail'];
	  
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
	$acc = new AccountDB();
	$result = $acc->getRole($email);
	$role = $result->data[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Image : <?=$_GET['image']?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/css/w3.css">
	<link href="vendor/css/shop-homepage.css" rel="stylesheet">
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
	<script language="javascript">
        function like_ajax() {
            $.ajax({
                url : "ajax/like.php",
                type : "post",
                dataType:"text",
                data : {
                    likeInfo : $('#likeButton').val()
                },
                success : function (result) {
                    $('#likeResult').html(result);
                }
            });
            $('#likeButton').css('display', 'none');
            $('#unlikeButton').css('display', 'inline');
        }

        function unlike_ajax() {
            $.ajax({
                url : "ajax/like.php",
                type : "post",
                dataType:"text",
                data : {
                    likeInfo : $('#unlikeButton').val()
                },
                success : function (result) {
                    $('#likeResult').html(result);
                }
            });
            $('#likeButton').css('display', 'inline');
            $('#unlikeButton').css('display', 'none');
        }
		
		function settheme_ajax(val) {
            $.ajax({
                url : "ajax/theme.php",
                type : "post",
                dataType:"text",
                data : {
					theme : val,
                    themeInfo : $('#setButton').val()
                },
                success : function (result) {
					
                }
            });
        }
		
		function deleteComment_ajax(owner, uploadDate, imageOwner, image) {
			var yes = confirm("Are you sure?")
			if(yes == true) {
				$.ajax({
					url : "ajax/deleteComment.php",
					type : "post",
					dataType:"text",
					data : {
						owner: owner,	
						uploadDate: uploadDate,
						imageOwner : imageOwner,
						image : image
					},
					success : function (result) {
						$('#comments').html(result);
					}	
				});
			}
		}
		
		function deleteImage_ajax(email, image) {
			var yes = confirm("Are you sure?")
			if(yes == true) {
				$.ajax({
					url : "ajax/deleteImage.php",
					type : "post",
					dataType:"text",
					data : {
						email: email,
						image : image
					},
					success : function (result) {
						window.location.href = "index.php";
					}
				});
			}
		}
	</script>
	
	<style>
		textarea {
			width: 715px;
			height: 75px;
		}
		
		.alignleft {
			float: left;
			text-align:left;
			width:33.33333%;
			margin-bottom: 0px;
		}
		
		.alignleft2 {
			float: left;
			text-align:left;
			width:55%;
			margin-bottom: 0px;
		}
		
		.aligncenter {
			float: left;
			text-align:center;
			width:33.33333%;
			margin-bottom: 0px;
		}
		
		.aligncenter2 {
			float: left;
			text-align:right;
			width:34.8%;
			padding-right: 20px;
			margin-bottom: 0px;
		}
		
		.alignright {
			float: left;
			text-align:right;
			width:33.33333%;
			margin-bottom: 0px;
		}
		
		.alignright2 {
			float: left;
			text-align:right;
			width:10%;
			margin-bottom: 0px;
		}
		
		#setButton {
			height: 21px;
			padding-bottom: 0px;
			padding-top: 0px;
			border-top-width: 0px;
			border-bottom-width: 0px;
		}
	</style>
</head>
<body>
	<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="padding-top: 0px;padding-bottom: 0px">
      <div class="container">
        <a class="navbar-brand" href="index.php" style="height: 37.375px">Gallery</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
			<?php
				if($role == 'Administrator') {
					echo '<li class="nav-item">
							<a class="nav-link" href="assignRole.php">Roles</a>
						  </li>';
				}
				if($role != 'User') {
					echo '<li class="nav-item">
							<a class="nav-link" href="manageTheme.php">Themes</a>
						  </li>';
				}
			?>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="upload.php">Upload</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="showUser.php?owner=<?=$email?>">Hi, <?=$email?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
	
	<center>
	<?php
		if(isset($_GET['owner']) && isset($_GET['image'])) {
			$owner = $_GET['owner'];
			$image = $_GET['image'];
			
			$result = $imgDb->increaseView($image, $owner);
			if($result->status == Response::$SUCCESS) {
				
			}else if($result->status == Response::$FAILED) {
				echo "<script>showError()</script>";
			}else {
				echo "<script>showError()</script>";
			}
			echo '<div class="panel panel-default" style="width: 730px">
					<div class="panel-body" style="padding: 0px"><a href="uploads/' . $owner . '/' . $image . '" target="_blank"><img src = "uploads/' . $owner . '/' . $image . '" style="max-width: 728px; max-height: 409"></a></div>
					<div class="panel-heading"><b>' . $image . '</b><br> by <a href="showUser.php?owner=' . $owner . '">' . $owner . '</a></div>';
		}
		if(isset($_POST['likeButton'])) {
			$likeDirectory = $_POST['likeButton'];
			$emailOwner = explode('/', $likeDirectory)[1];
			$image = explode('/', $likeDirectory)[2];
			
			$result = $like->insertLike($emailOwner,$image, $email);
			if ($result->status == Response::$SUCCESS) {
				
			}else if($result->status == Response::$FAILED) {
				echo "<script>showError()</script>";
			}else {
				echo "<script>showError()</script>";
			}

			unset($_POST['likeButton']);
		}
		if(isset($_POST['unlikeButton'])) {
			$likeDirectory = $_POST['unlikeButton'];
			$emailOwner = explode('/', $likeDirectory)[1];
			$image = explode('/', $likeDirectory)[2];
			
			$result = $like->removeLike($emailOwner,$image, $email);
			if ($result->status == Response::$SUCCESS) {
				
			}else if($result->status == Response::$FAILED) {
				echo "<script>showError()</script>";
			}else {
				echo "<script>showError()</script>";
			}

			unset($_POST['likeButton']);
		}
		
		$result = $imgDb->getNoView($image, $owner);
		if ($result->status == Response::$SUCCESS) {
				$noview = $result->data[0];
        }else if ($result->status == Response::$FAILED) {
            echo "<script>showError()</script>";
        }else {
            echo "<script>showError()</script>";
        }
		
		$result = $imgDb->getNoDownload($image, $owner);
		if ($result->status == Response::$SUCCESS) {
				$nodownload = $result->data[0];
        }else if ($result->status == Response::$FAILED) {
            echo "<script>showError()</script>";
        }else {
            echo "<script>showError()</script>";
        }
		
		$numLike = $like->getNumLike($owner, $image);
		if($numLike->status == Response::$SUCCESS) {
			echo '<div id="textbox">
					<p class="alignleft">' . $noview . ' Views</p>
					<p class="aligncenter" id="likeResult">' . $numLike->data[0] . ' people like this</p>
					<p class="alignright">' . $nodownload . ' Downloads</p>
				  </div><div style="clear: both;"></div>';
		}
		$existLike = $like->checkExistLike($owner, $image, $email);
		
		$deleteImagePermission = false;
		if($owner == $email)
			$deleteImagePermission = true;
		else
			$deleteImagePermission = false;
		if($role != 'User')
			$deleteImagePermission = true;
				
		if($owner == $email) {
			if(isset($_POST['theme']))
				$theme = $_POST['theme'];
			else {
				$result = $imgDb->getTheme($image, $owner);
				if($result->status == Response::$SUCCESS) {
					$theme = $result->data[0];
				}else if ($result->status == Response::$FAILED) {
					echo "<script>showError()</script>";
				}else{
					echo "<script>showError()</script>";
				}
			}
			echo '<form method="POST">
					<p class="alignleft2">Theme:
						<select name="theme">';
							$result = $themeDb->getTheme();
							foreach($result->data as $item) {
								$name = $item['name'];
								echo '<option '; if(isset($theme) && $theme == $name) { echo "selected"; } echo '>' . $name . '</option>';
							}
						echo '</select>
						<button type="button" name="set" id="setButton" class="btn btn-success" onclick="settheme_ajax(theme.value)" value="' . $owner . '/' . $image . '/' . $theme . '"/>Set</button>
					</p>';
					if($deleteImagePermission == true) {echo '<p class="alignright" style="width:45%"><button type="button" name="deleteImage" id="deleteImage" class="btn btn-danger" onclick="deleteImage_ajax(' . "'" . $owner . "', '" . $image . "'" . ')">Remove Image</button></p>';}
					echo '<div style="clear: both;"></div>
				  </form>';
		}
		else {
			echo '<p class="alignleft2">Theme: ';
			$result = $imgDb->getTheme($image, $owner);
			if($result->status == Response::$SUCCESS) {
				echo '<a href="index.php?theme=' . $result->data[0] . '">' . $result->data[0] . '</a>';
				if($deleteImagePermission == true) {echo '<p class="alignright" style="width:45%"><button type="button" name="deleteImage" id="deleteImage" class="btn btn-danger" onclick="deleteImage_ajax(' . "'" . $owner . "', '" . $image . "'" . ')">Remove Image</button></p>';}
			}else if ($result->status == Response::$FAILED) {
				echo "<script>showError()</script>";
			}else {
				echo "<script>showError()</script>";
			}
			echo '</p>
				  <div style="clear: both;"></div>';
		}
	?>
	
    <form action="" method="post">
        <?php
			if($existLike->status == Response::$FAILED) {
		?>
			<button type="button" name="clickme" id="likeButton" class="btn btn-primary" onclick="like_ajax()" value="<?=$owner . '/' . $image . '/' . $email . '/like'?>"/>Like</button>
			<button type="button" name="clickme" id="unlikeButton" class="btn btn-danger" onclick="unlike_ajax()" style="display: none" value="<?=$owner . '/' . $image . '/' . $email . '/unlike'?>"/>Unlike</button>
			<button class="btn btn-success" name="download" id="download">Download</button>
		<?php
			}
			else if($existLike->status == Response::$SUCCESS) {
		?>
			<button type="button" name="clickme" id="likeButton" class="btn btn-primary" onclick="like_ajax()" style="display: none" value="<?=$owner . '/' . $image . '/' . $email . '/like'?>"/>Like</button>
			<button type="button" name="clickme" id="unlikeButton" class="btn btn-danger" onclick="unlike_ajax()" value="<?=$owner . '/' . $image . '/' . $email . '/unlike'?>"/>Unlike</button>
			<button class="btn btn-success" name="download" id="download">Download</button>
		<?php
			}
        ?>
    </form>
	
	<?php
		if(array_key_exists('download',$_POST)) {
			$file_url = 'uploads/' . $owner . '/' . $image;
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
			while(ob_get_level()) {
				ob_end_clean();
			}
			readfile($file_url);
			
			$result = $imgDb->increaseDownload($image, $owner);
			if($result->status == Response::$SUCCESS) {
				
			}else if($result->status == Response::$FAILED) {
				echo "<script>showError()</script>";
			}else {
				echo "<script>showError()</script>";
			}
			
			$result2 = $imgDb->decreaseView($image, $owner);
			if($result2->status == Response::$SUCCESS) {
				
			}else if($result2->status == Response::$FAILED) {
				echo "<script>showError()</script>";
			}else {
				echo "<script>showError()</script>";
			}
		}
	?>

	<form action="" method="POST" id="commentForm">
		<div style="text-align: left;padding:5px">Comment:</div>
		<div style="text-align: left;padding-left:5px"><textarea id="commentArea" name="commentArea" form="commentForm"></textarea></div>
        <div style="text-align: right;padding-right:8px; display: none"><input type="text" name="info" id="commentInfo" value="<?= $email . '/' . $owner . '/' . $image ?>" /></div>
        <button style="float: right;margin-bottom: 5px;margin-right: 8px" id="commentButton" type="button" onclick="comment_ajax()">Comment</button>
		<div style="clear: both;"></div>
	</form>
	
    <script type="text/javascript">
        function comment_ajax() {
            $.ajax({
                url : "ajax/comment.php",
                type : "post",
                dataType:"text",
                data : {
                    commentInfo : $('#commentInfo').val(),
                    theComment : $('#commentArea').val()
                },
                success : function (result) {
                    $('#comments').html(result);
					document.getElementById('commentArea').value = "";
                }
            });
        }
    </script>
	
    <div id="comments">
    <?php
		$result2 = $cmtDb->getComment($owner, $image);
		if($result2->status == Response::$SUCCESS) {
			foreach($result2->data as $item) {
				$deleteCommentPermission = false;
				if($item['owner'] == $email)
					$deleteCommentPermission = true;
				else
					$deleteCommentPermission = false;
				if($role != 'User')
					$deleteCommentPermission = true;
				$comment = str_replace("\n", "<br>", $item['comment']);
				echo '<form method="POST"><div class="panel panel-primary" style="text-align: left;margin-bottom: 5px;margin-left: 5px;margin-right: 5px">
						<div class="panel-heading" style="padding-left: 5px;height: 36px; padding-top: 0px; padding-bottom: 0px"><a class="alignleft2" style="padding-top: 10px" href="showUser.php?owner=' . $item['owner'] . '" style="color: white;"><b>' . $item['owner'] . '</b></a>
						<p class="aligncenter2" style="padding-top: 10px">' . $item['uploadDate'] . '</p>'; if($deleteCommentPermission == true) {echo '<p class="alignright2"><button type="button" id="deleteCommentButton" class="btn btn-danger" onclick="deleteComment_ajax(' . "'" . $item['owner'] . "', '" . $item['uploadDate'] . "', '" . $owner . "', '" . $image . "'" . ')" style="padding-top: 0px;padding-bottom: 0px">Remove</button></p>';} echo '</div>
						<div style="clear: both;"></div>
						<div class="panel-body" style=" padding:5px;overflow: auto">' . $comment . '</div>
					  </div></form>';
			}
		}else if($result2->status == Response::$FAILED) {
			
		}else {
			
		}
    ?>
    </div>
	</center>
	
	<br>
    <!-- Footer -->
    <footer class="py-3 bg-dark" style="max-width: 200%">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PoD 2017</p>
      </div>
      <!-- /.container -->
    </footer>
</body>
</html>