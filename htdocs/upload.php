<?php
	session_start();
	if(isset($_SESSION['accountEmail']))
		$dir = $_SESSION['accountEmail'];
	else
		header("Location: login.php");
	$name = $_SESSION['accountEmail'];
  
	ob_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ImageDb.php');
	$imgDb = new ImageDb();
  
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
	$acc = new AccountDB();
	$result = $acc->getRole($name);
	$role = $result->data[0];
?>

<!doctype html>
<html>
<head>
    <title>Upload</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/css/w3.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
	<style>
		tr {
			height: 20px;
		}
		
		img {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 5px;
			width: 150px;
		}

		img:hover {
			box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
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
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="upload.php">Upload</a>
                <span class="sr-only">(current)</span>
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
	<br>
	
	<center>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<div>
				<td>
					<label style="margin-bottom:0px">Choose File:</label>
				</td>
				<td>
					<input name="file_upload[]" multiple type="file" id = "hinhdcup">
				</td>
				<td>
					<div><input type="submit" name="submitBtn" value="Upload"></div>
				</td>
			</div>
		</tr>
	</table>
	<br>
	
	<table>
		<tbody>
			<tr>
				<td>
	<?php
		function cameraUsed($imagePath) {
			if((isset($imagePath)) and (file_exists($imagePath))) {
				$extension = pathinfo($imagePath, PATHINFO_EXTENSION);						  
				if($extension == 'jpg' || $extension == 'JPG' || $extension == 'jpeg' || $extension == 'JPEG') {
					$exif_ifd0 = read_exif_data($imagePath ,'IFD0' ,0);
					$exif_exif = read_exif_data($imagePath ,'EXIF' ,0);
				}
				else {
					$exif_ifd0 = null;
					$exif_exif = null;
				}
				$notFound = "Unavailable";
				
				if(@array_key_exists('Make', $exif_ifd0)) {
					$camMake = $exif_ifd0['Make'];
				} else { $camMake = $notFound; }

				if(@array_key_exists('Model', $exif_ifd0)) {
					$camModel = $exif_ifd0['Model'];
				} else { $camModel = $notFound; }

				if(@array_key_exists('ExposureTime', $exif_ifd0)) {
					$camExposure = $exif_ifd0['ExposureTime'];
				} else { $camExposure = $notFound; }

				if(@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
					$camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
				} else { $camAperture = $notFound; }

				if(@array_key_exists('DateTime', $exif_ifd0)) {
					$camDate = $exif_ifd0['DateTime'];
				} else { $camDate = $notFound; }

				if(@array_key_exists('ISOSpeedRatings',$exif_exif)) {
					$camIso = $exif_exif['ISOSpeedRatings'];
				} else { $camIso = $notFound; }

				if(@array_key_exists('Orientation',$exif_exif)) {
					$ort = $exif_exif['Orientation'];
				} else { $ort = $notFound; }
				
				$return = array();
				$return['make'] = $camMake;
				$return['model'] = $camModel;
				$return['exposure'] = $camExposure;
				$return['aperture'] = $camAperture;
				$return['date'] = $camDate;
				$return['iso'] = $camIso;
				$return['ort'] = $ort;
				return $return;
			}else
				return false;
		}
	?>

	<?php
		if(isset($_POST['submitBtn'])) {
			$uploads = dirname(__FILE__) . DIRECTORY_SEPARATOR .'uploads/' . $dir . DIRECTORY_SEPARATOR;
			for($i=0; $i<count($_FILES['file_upload']['name']);$i++) {
				$extension = pathinfo($_FILES['file_upload']['name'][$i], PATHINFO_EXTENSION);
				if($_FILES['file_upload']['name'][0] == '') {
					echo "Please select image to upload first!";
				} else if($extension == 'png' || $extension == 'PNG' || $extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
					$target_path = $uploads . basename( $_FILES['file_upload']['name'][$i]);
					move_uploaded_file($_FILES['file_upload']['tmp_name'][$i], $target_path);
					$image = $_FILES['file_upload']['name'][$i];
					$img = "uploads/" . $dir . "/" . $image;
					
					$camera = cameraUsed($img);
					
					$result = $imgDb->insertImage($_FILES['file_upload']['name'][$i],$dir, date('Y-m-d H:i:s'));
					if($extension == 'png' || $extension == 'PNG')
						$new = imagecreatefrompng($img);
					else 
						$new = imagecreatefromjpeg($img);

					$ort = $camera['ort'];
					switch($ort)
					{
						case 1:
						break;

						case 2: // horizontal flip
							$new = imageflip($new,1);
						break;
												
						case 3: // 180 rotate left
							$new = imagerotate($new,180, 0);
						break;
									
						case 4: // vertical flip
							$new = imageflip($new,2);
						break;
								
						case 5: // vertical flip + 90 rotate right
							$new = imageflip($new, 2);
							$new = imagerotate($new, -90, 0);
						break;
								
						case 6: // 90 rotate right
							$new = imagerotate($new, -90, 0);
						break;
								
						case 7: // horizontal flip + 90 rotate right
							$new = imageflip($new,1);    
							$new = imagerotate($new, -90, 0);
						break;
								
						case 8:    // 90 rotate left
							$new = imagerotate($new, 90, 0);
						break;
					}
					
					// TRANSPARENT 
					if ($extension == 'png' || $extension == 'PNG') {
						$transindex = imagecolortransparent($new);
						if($transindex >= 0) {
							$transcol = imagecolorsforindex($new, $transindex);
							$transindex = imagecolorallocatealpha($new, $transcol['red'], $transcol['green'], $transcol['blue'], 127);
							imagefill($new, 0, 0, $transindex);
							imagecolortransparent($new, $transindex);
						}
						else if($extension == 'png' || $extension == 'PNG') {
							imagealphablending($new, false);
							$color = imagecolorallocatealpha($new, 0, 0, 0, 127);
							imagefill($new, 0, 0, $color);
							imagesavealpha($new, true);
						}
					}
					
					if($extension == 'png' || $extension == 'PNG')
						imagepng($new, $target_path);
					else 
						imagejpeg($new, $target_path);
					
					$crop_width = imagesx($new);
					$crop_height = imagesy($new);
					$size = min($crop_width, $crop_height);
					if($crop_width >= $crop_height) {
						$newx= ($crop_width-$crop_height)/2;
						$new = imagecrop($new, ['x' => $newx, 'y' => 0, 'width' => $size, 'height' => $size]);
					}
					else {
						$newy= ($crop_height-$crop_width)/2;
						$new = imagecrop($new, ['x' => 0, 'y' => $newy, 'width' => $size, 'height' => $size]);
					}
					
					ob_start();
					if($extension == 'png' || $extension == 'PNG')
						imagepng($new, null);
					else 
						imagejpeg($new, null);
					$rawImageBytes = ob_get_clean();
			
					echo '<table><tbody>
							<tr>
								<td rowspan="6">
									<a target="_blank" href="' . $img . '">' . 
										"<img src='data:image/jpeg;base64," . base64_encode( $rawImageBytes ) . "' />" . '
									</a>
								</td>
							</tr>';
					if($camera['make'] == 'Unavailable')
						echo "<tr><td>Camera Used: " . $camera['make'] . "</td></tr>";
					else
						echo "<tr><td>Camera Used: " . $camera['make'] . " " . $camera['model'] . "</td></tr>";
					echo "<tr><td>Exposure Time: " . $camera['exposure'] . "</td></tr>";
					echo "<tr><td>Aperture: " . $camera['aperture'] . "</td></tr>";
					echo "<tr><td>ISO: " . $camera['iso'] . "</td></tr>";
					echo "<tr><td>Date Taken: " . $camera['date'] . "</td></tr></tbody></table>";
					if($result->status == Response::$SUCCESS) {
						
					}else if($result->status == Response::$FAILED) {
						echo "<script>showError()</script>";
					}else {
						echo "<script>showError()</script>";
					}
				} else {
					echo "Unsupported file type!";
				}
			}
		}
	?>
				</td>
			</tr>
		</tbody>
	</table>
	</center>
	
    <!-- Footer -->
	<br>
    <footer class="py-3 bg-dark navbar-fixed-bottom">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; PoD 2017</p>
      </div>
      <!-- /.container -->
    </footer>
</body>
</html>