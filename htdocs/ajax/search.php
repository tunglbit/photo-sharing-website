<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ImageDb.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/LikesDB.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ThemesDb.php');
$imgDb = new ImageDb();
$like = new LikesDB();
$themeDb = new ThemesDb();

if(isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $theme = $_POST['theme'];

    $result = $imgDb->searchImage($keyword, $theme);
    if($result->status == Response::$SUCCESS) {
        foreach($result->data as $item) {
            $path = $item['name'];
            $img = "uploads/" . $item['owner'] . "/" . $item['name'];
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            if ($extension == 'jpg' || $extension == 'png' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'jpeg' || $extension == 'JPEG') {
                $img = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $item['owner'] . "/" . $item['name'];
                if ($extension == 'png' || $extension == 'PNG')
                    $new = imagecreatefrompng($img);
                else
                    $new = imagecreatefromjpeg($img);
                $crop_width = imagesx($new);
                $crop_height = imagesy($new);
                $size = min($crop_width, $crop_height);
                if ($crop_width >= $crop_height) {
                    $newx = ($crop_width - $crop_height) / 2;
                    $im2 = imagecrop($new, ['x' => $newx, 'y' => 0, 'width' => $size, 'height' => $size]);
                } else {
                    $newy = ($crop_height - $crop_width) / 2;
                    $im2 = imagecrop($new, ['x' => 0, 'y' => $newy, 'width' => $size, 'height' => $size]);
                }
                ob_start();
                if ($extension == 'png' || $extension == 'PNG')
                    imagepng($im2, NULL);
                else
                    imagejpeg($im2, NULL);
                $rawImageBytes = ob_get_clean();
                echo '<div class="col-lg-4 col-md-6 mb-4">
							<div class="card h-100">
								<a href="showImage.php?owner=' . $item['owner'] . '&image=' . $item['name'] . '">' . "<img src='data:image/jpeg;base64," . base64_encode($rawImageBytes) . "' />" . '</a>
								<div class="card-footer" style="padding:5px; height: 60px">';
                $numLike = $like->getNumLike($item['owner'], $item['name']);
                $result = $imgDb->getNoView($item['name'], $item['owner']);
                if ($numLike->status == Response::$SUCCESS) {
                    echo '<div id="textbox">
							<p class="alignleft" style="margin-bottom:0.5px">' . $result->data[0] . ' Views</p>
							<p class="alignright" style="margin-bottom:0.5px">' . $numLike->data[0] . ' Likes</p>
						  </div>
						  <div style="clear: both;"></div>
						  <hr style="width:100%;margin-top: 2px;margin-bottom: 0px"><center><a href="showUser.php?owner=' . $item['owner'] . '">' . $item['owner'] . '</a></center>
								</div>';
                }
                echo ' 		</div>
					  </div>';
                imagedestroy($new);
                imagedestroy($im2);
            }
        }
    }else if ($result->status == Response::$FAILED) {
        echo $result->message;
    }else {
        echo $result->message;
    }
}