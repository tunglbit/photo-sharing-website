<?php
	session_start();
	if(!isset($_SESSION['accountEmail']))
		header("Location: login.php");
	$name = $_SESSION['accountEmail'];

	ob_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ImageDb.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/LikesDB.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ThemesDb.php');
	$imgDb = new ImageDb();
	$like = new LikesDB();
	$themeDb = new ThemesDb();
	  
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
	$acc = new AccountDB();
	$result = $acc->getRole($name);
	$role = $result->data[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gallery</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/css/w3.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        function search_ajax() {
            $.ajax({
                url : "ajax/search.php",
                type : "post",
                dataType:"text",
                data : {
                    keyword : $('#search').val(),
                    theme : $('#theme').val()
                },
                success : function (result) {
                    $('#listImages').html(result);
                }
            });
        }
    </script>
	
    <style>
	img {
		border: 1px solid #ddd;
		border-radius: 4px;
		padding: 5px;
		width: 100%;
	}

	img:hover {
		box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
	}
	  
	.alignleft {
		float: left;
		text-align:left;
		width: 50%;
	}
	  
	.alignright {
		float: left;
		text-align:right;
		width: 50%;
	}
	</style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Gallery</a>
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
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="upload.php">Upload</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="showUser.php?owner=<?=$name?>">Hi, <?=$name?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <br>
          <div class="list-group">
			 <div class="list-group-item" style="padding-left: 11px;padding-right: 11px">Theme
				<?php
					if(isset($_GET['theme']))
						$theme = $_GET['theme'];
					else
						$theme = "All";
				?>
				<form method="GET">
					<select name="theme" id="theme">
						<option <?php if(isset($theme) && $theme == "All") echo "selected";?>>All</option>
						<?php
							$result = $themeDb->getTheme();
							foreach($result->data as $item) {
								$name = $item['name'];
								echo '<option '; if(isset($theme) && $theme == $name) { echo "selected"; } echo '>' . $name . '</option>';
							}
						?>
					</select>
					<input name="submit" type="submit" value="Go" style="margin-top: 4px;padding-top: 0px;padding-bottom: 0px;"/>	
				</form>
                 <br>
                 <p style="margin-bottom: 0px">Search</p>
                 <form>
                     <input type="text" name="search" placeholder="Search.." id="search" style="width:157px">
                 <button type="button" onclick="search_ajax()" style="margin-top: 4px">Search</button>
                 </form>
			 </div>
          </div>
		  <br>
        </div>
		
        <div class="col-lg-9">
		  <br>
          <div class="row" id="listImages">
            <?php
				if(!isset($_GET['theme']) || $_GET['theme'] == 'All') {
					$result = $imgDb->getAll();
				}
				else {
					$result = $imgDb->getImageByTheme($_GET['theme']);
				}
				if ($result->status == Response::$SUCCESS) {
					foreach($result->data as $item) {
						$path = $item['name'];
						$img = "uploads/" . $item['owner'] . "/" . $item['name'];
					    $extension = pathinfo($path, PATHINFO_EXTENSION);
						if($extension == 'jpg' || $extension == 'png' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'jpeg' || $extension == 'JPEG') {
							$img = "uploads/" . $item['owner'] . "/" . $item['name'];
							if($extension == 'png' || $extension == 'PNG')
								$new = imagecreatefrompng($img);
							else 
								$new = imagecreatefromjpeg($img);
							$crop_width = imagesx($new);
							$crop_height = imagesy($new);
							$size = min($crop_width, $crop_height);
							if($crop_width >= $crop_height) {
								$newx= ($crop_width-$crop_height)/2;
								$im2 = imagecrop($new, ['x' => $newx, 'y' => 0, 'width' => $size, 'height' => $size]);
							}
							else {
								$newy= ($crop_height-$crop_width)/2;
								$im2 = imagecrop($new, ['x' => 0, 'y' => $newy, 'width' => $size, 'height' => $size]);
							}
							ob_start();
							if($extension == 'png' || $extension == 'PNG')
								imagepng($im2, NULL);
							else 
								imagejpeg($im2, NULL);
							$rawImageBytes = ob_get_clean();
							echo '<div class="col-lg-4 col-md-6 mb-4">
									<div class="card h-100">
										<a href="showImage.php?owner=' . $item['owner'] . '&image=' . $item['name'] . '">' . "<img src='data:image/jpeg;base64," . base64_encode( $rawImageBytes ) . "' />" . '</a>
										<div class="card-footer" style="padding:5px; height: 60px">';
							$numLike = $like->getNumLike($item['owner'], $item['name']);
							$result = $imgDb->getNoView($item['name'], $item['owner']);
							if($numLike->status == Response::$SUCCESS) {
								echo '<div id="textbox">
										<p class="alignleft" style="margin-bottom:0.5px">' . $result->data[0] . ' Views</p>
										<p class="alignright" style="margin-bottom:0.5px">' . $numLike->data[0] . ' Likes</p>
										</div><div style="clear: both;"></div>
										<hr style="width:100%;margin-top: 2px;margin-bottom: 0px"><center><a href="showUser.php?owner=' . $item['owner'] . '">' . $item['owner'] . '</a></center></div>';
							}
							echo	'</div>
								  </div>';
							imagedestroy($new);
							imagedestroy($im2);
						}
					}
				}else if ($result->status == Response::$FAILED) {
					echo "<script>showError()</script>";
				}else{
					echo "<script>showError()</script>";
				}
            ?>
			
          </div>
          <!-- /.row -->
        </div>
        <!-- /.col-lg-9 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
	
    <!-- Footer -->
    <footer class="py-3 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PoD 2017</p>
      </div>
      <!-- /.container -->
    </footer>
</body>
</html>