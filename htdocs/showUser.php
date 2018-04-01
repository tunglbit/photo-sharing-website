<?php
    session_start();
	if(!isset($_SESSION['accountEmail']))
		header("Location: login.php");
    $name = $_SESSION['accountEmail'];
	
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
	$acc = new AccountDB();
	$result = $acc->getRole($name);
	$role = $result->data[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>User : <?=$_GET['owner']?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="vendor/css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/css/w3.css">
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
	<style>
		hr {
			color: #f00;
			background-color: black;
			height: 5px;
		}
	</style>
<body>
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
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="upload.php">Upload</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="showUser.php?owner=<?=$name?>">Hi, <?=$name?></a>
			  <span class="sr-only">(current)</span>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
	
	<center>
	<div class="w3-content w3-display-container">
		<?php
			$owner = $_GET['owner'];
			echo '<h1>Gallery of ' . $owner . '</h1>';
			$accountFolder = opendir("uploads/" . $owner);
			while($imagesName = readdir($accountFolder)) {
				$images[] = $imagesName;
			}
			closedir($accountFolder);
			$numImages = count($images);
			$count = 1;
			for($j = 0; $j < $numImages; $j++) {
				$extension = substr($images[$j], -3);
				if($extension == 'jpg' || $extension == 'png' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'jpeg' || $extension == 'JPEG') {
					echo '<img class="mySlides" src="uploads/' . $owner . '/' . $images[$j] . '" style="max-width: 728px; height: 420px">';
				}
			}
		?>
		<button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
		<button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
	</div>
	<br>
	
	<hr style="color:red">
	<br>
	
	<script>
		var slideIndex = 0;
		showDivs(slideIndex);

		function plusDivs(n) {
		  showDivs(slideIndex += n);
		}

		function showDivs(n) {
		  var i;
		  var x = document.getElementsByClassName("mySlides");
		  if(n > x.length) {slideIndex = 1}    
		  if(n < 1) {slideIndex = x.length}
		  for(i = 0; i < x.length; i++) {
			 x[i].style.display = "none";  
		  }
		  x[slideIndex-1].style.display = "block";
		}
		
		autoSlideShow();
		function autoSlideShow() {
			var i;
			var x = document.getElementsByClassName("mySlides");
			for (i = 0; i < x.length; i++) {
			  x[i].style.display = "none"; 
			}
			slideIndex++;
			if (slideIndex > x.length) {slideIndex = 1} 
			x[slideIndex-1].style.display = "block"; 
			setTimeout(autoSlideShow, 3500); // Change image every 2 seconds
		}
	</script>
	<?php
		$numImages = 0;
		$images = array();
		$owner = $_GET['owner'];
		$accountFolder = opendir("uploads/" . $owner);
		while ($imagesName = readdir($accountFolder)) {
			$images[] = $imagesName;
		}
		closedir($accountFolder);
		$numImages = count($images);
		for($j = 0; $j < $numImages; $j++) {
			$extension = substr($images[$j], -3);
			if ($extension == 'jpg' || $extension == 'png' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'jpeg' || $extension == 'JPEG') {
				echo '<div class="card h-100" style="width: 729.5px">
						<div class="card-footer"><a href="showImage.php?owner=' . $owner . '&image=' . $images[$j] . '"><b>' . $images[$j] . '</b></a></div>
						<div class="panel-body" style="padding: 0px"> <img src = "uploads/' . $owner . '/' . $images[$j] . '" style="max-width: 728px; max-height: 409"> </div>
					  </div>' . "<br>";
			}
		}
	?>
	</center>
	<br>
	
	<!-- Footer -->
    <footer class="py-3 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PoD 2017</p>
      </div>
      <!-- /.container -->
    </footer>
</body>
</html>