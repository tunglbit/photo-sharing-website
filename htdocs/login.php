<?php
    session_start();
    if (isset($_SESSION['accountEmail']))
        header("Location: index.php");
	
    ob_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
    $acc = new AccountDb();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="vendor/css/style.css">
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <script src="vendor/js/client_platform.js" async defer></script>
    <script src="vendor/js/angular.min.js"></script>
    <script src="vendor/google_and_facebook/FB_GG_LoginScript.js" type="text/javascript"></script>
    <script src="vendor/google_and_facebook/FB_GG_LoginApp.js" type="text/javascript"></script>
	<script src="vendor/js/jquery.min.js"></script>
	<script src="vendor/js/index.js"></script>
	
	<style>
		.form input.getGoogleAccInfo {
			clear: both;
			font-family: "Roboto", sans-serif;
			text-transform: uppercase;
			outline: 0;
			background: #bd831f;
			width: 100%;
			border: 0;
			padding: 15px;
			color: #FFFFFF;
			font-size: 14px;
			cursor: pointer;
		}

		.form input.getGoogleAccInfo:hover {
			background: #ac2925;
		}

		.form input.getFacebookAccInfo {
			clear: both;
			font-family: "Roboto", sans-serif;
			text-transform: uppercase;
			outline: 0;
			background: #0D72B2;
			width: 100%;
			border: 0;
			padding: 15px;
			color: #FFFFFF;
			font-size: 13px;
			cursor: pointer;
		}

		.form input.getFacebookAccInfo:hover {
			background: #0A246A;
		}
		
		.loginBtn {
		  box-sizing: border-box;
		  position: relative;
		  /* width: 13em;  - apply for fixed size */
		  margin: 0.2em;
		  padding: 0 15px 0 46px;
		  border: none;
		  text-align: left;
		  line-height: 34px;
		  white-space: nowrap;
		  border-radius: 0.2em;
		  font-size: 16px;
		  color: #FFF;
		}
		.loginBtn:before {
		  content: "";
		  box-sizing: border-box;
		  position: absolute;
		  top: 0;
		  left: 0;
		  width: 34px;
		  height: 100%;
		}
		.loginBtn:focus {
		  outline: none;
		}
		.loginBtn:active {
		  box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
		}


		/* Facebook */
		.loginBtn--facebook {
		  background-color: #4C69BA;
		  background-image: linear-gradient(#4C69BA, #3B55A0);
		  /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
		  text-shadow: 0 -1px 0 #354C8C;
		}
		.loginBtn--facebook:before {
		  border-right: #364e92 1px solid;
		  background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
		}
		.loginBtn--facebook:hover,
		.loginBtn--facebook:focus {
		  background-color: #5B7BD5;
		  background-image: linear-gradient(#5B7BD5, #4864B1);
		}


		/* Google */
		.loginBtn--google {
		  /*font-family: "Roboto", Roboto, arial, sans-serif;*/
		  background: #DD4B39;
		}
		.loginBtn--google:before {
		  border-right: #BB3F30 1px solid;
		  background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') 6px 6px no-repeat;
		}
		.loginBtn--google:hover,
		.loginBtn--google:focus {
		  background: #E74B37;
		}
	</style>

	<script>
		function showFB() {
			var FB = document.getElementById("formFB");
			var GG = document.getElementById("formGG");
			if(FB.style.display === "none") {
				FB.style.display = "block";
			}
			if(GG.style.display == "block") {
				GG.style.display = "none";
			}
			var div = document.getElementById("errorDiv");
			div.style.display = "none";
		}
		
		function showGG() {
			var FB = document.getElementById("formFB");
			var GG = document.getElementById("formGG");
			if(GG.style.display === "none") {
				GG.style.display = "block";
			}
			if(FB.style.display == "block") {
				FB.style.display = "none";
			}
			var div = document.getElementById("errorDiv");
			div.style.display = "none";
		}
		
		function showErrorSI() {
			var div = document.getElementById("errorDiv2");
			div.style.display = "block";
		}
		
		function showErrorFB() {
			showFB();
			var div = document.getElementById("errorDiv");
			var mess = document.getElementById("errorMessage");
			mess.innerHTML = 'Please choose "Get Facebook Account Information"';
			div.style.display = "block";
		}
		
		function showErrorGG() {
			showGG();
			var div = document.getElementById("errorDiv");
			var mess = document.getElementById("errorMessage");
			mess.innerHTML = 'Please choose "Get Google Account Information"';
			div.style.display = "block";
		}
	</script>
</head>
<body ng-app="myApp" ng-controller="myController">
	<div class="login-page" style="padding-top: 0px">
		<div class="form" style="margin-bottom: 15px;padding-top: 5px;padding-bottom: 20px; margin-top: 10px">
			<h2 style="margin-top: 5px">Sign In</h2>
			<form class="login-form" action ="login.php" method="post">
				<input type="text" placeholder="Username/Email" name="user"/>
				<input type="password" placeholder="Password" name="pass"/>
				<button>Login</button>
				<p class="message">Not registered? <a href="register.php">Create an account</a></p>
			</form>
		</div>
		
		<center>
		<div class="panel panel-danger" style="width: 100%;display: none" id="errorDiv2">
			<div class="panel-heading">Wrong Username or Password!</div>
		</div>
		</center>
		
		<div style="width: 100%; height: 15px; border-bottom: 1px solid white; text-align: center">
		  <span style="font-size: 20px;color: white; background-color:rgb(129, 188, 97);; padding: 0 10px;">
			or
		  </span>
		</div>
		
		<center>
		<button class="loginBtn loginBtn--facebook" style="margin-top: 20px; height: 100%; width: 60%" onclick="showFB()">
		  Login with Facebook
		</button>

		<button class="loginBtn loginBtn--google" style="margin-bottom: 20px;height: 100%; width: 60%" onclick="showGG()">
		  Login with Google
		</button>
		</center>

		<?php
			if(isset($_POST['user']) && isset($_POST['pass'])) {
				$user = $_POST['user'];
				$pass = $_POST['pass'];

				$result = $acc->checkExistAccount($user, $pass);
				if($result->status == Response::$SUCCESS) {
					if($row = $result->data) {
						$dir = $result->data['email'];
						$_SESSION['accountEmail'] = $dir;
						header("Location: index.php");
						exit();
					}
				}else if ($result->status == Response::$FAILED) {
						echo '<script type="text/javascript">
								 showErrorSI();
							 </script>';
				}else {
					echo "<script>showError()</script>";
				}
			}
		?>
		
		<!-- Container with the Sign-In button. -->
		<?php
			$googleUsername = '{{gmail.username}}';
			$googleEmail = '{{gmail.email}}';
			$facebookUsername = '{{facebook.username}}';
			$facebookEmail = '{{facebook.email}}';
		?>
        <div class="form" style="margin-bottom:20px; padding-top: 20px; display:none" id="formGG">
			<img src="img/GG_Logo.png" height ="170px" width="170px" style="margin-bottom: 10px">
            <input type="button" ng-click="onGoogleLogin()" value="Get Google Account Information" class="getGoogleAccInfo"/>
            <form class="login-form" action ="login.php" method="post">
                <input type="text" value="<?=$googleUsername?>" name="googleUser" readonly="readonly"/>
                <input type="text" value="<?=$googleEmail?>" name="googleEmail" readonly="readonly"/>
                <button>Login with Google</button>
            </form>
        </div>

        <div class="form" style="margin-bottom:20px; padding-top: 20px; display:none" id="formFB">
            <img src="img/FB_Logo.png" height ="170px" width="170px" style="margin-bottom: 10px">
            <input type="button" ng-click="onFacebookLogin()" value="Get Facebook Account Information" class="getFacebookAccInfo"/>
            <form class="login-form" action ="login.php" method="post">
                <input type="text" value="<?=$facebookUsername?>" name="facebookUser" readonly="readonly"/>
                <input type="text" value="<?=$facebookEmail?>" name="facebookEmail" readonly="readonly"/>
                <button>Login with Facebook</button>
            </form>
        </div>
			
		<div class="panel panel-danger" style="width: 100%;display: none" id="errorDiv">
			<div class="panel-heading" id="errorMessage"></div>
		</div>
    </div>
	
    <?php
		if(isset($_POST['googleUser']) && isset($_POST['googleEmail'])) {
			$googleUsername = $_POST['googleUser'];
			$googleEmail = $_POST['googleEmail'];
			$result = $acc->checkExistEmail($googleEmail);
			if($result->status == Response::$SUCCESS) {
				if($row = $result->data) {
					$dir = $result->data['email'];
					$_SESSION['accountEmail'] = $dir;
					header("Location: index.php");
					exit();
				}
			} else if($result->status == Response::$FAILED) {
					echo '<script type="text/javascript">
							 showErrorGG();
						 </script>';
			}

			// nếu không có tài khoản trước thì tạo tài khoản với gmail, username, còn pass bỏ trống
			require_once($_SERVER['DOCUMENT_ROOT'].'/model/registerDB.php');
			$registerAcc = new registerDB();
			$registerResult = $registerAcc->getGoogle($googleUsername, $googleEmail);
			if($registerResult->status == Response::$SUCCESS) {
				//Make directory
				$filename = "/uploads/" . $googleEmail . "/";
				if(!file_exists($filename))
					mkdir("uploads/" . $googleEmail, 0777);
				$_SESSION['accountEmail'] = $googleEmail;
				header("Location: index.php");
			}else if($result->status == Response::$FAILED) {
				
			}else {
				echo "<script>showError()</script>";
			}
		}

		if(isset($_POST['facebookUser']) && isset($_POST['facebookEmail'])) {
			$facebookUsername = $_POST['facebookUser'];
			$facebookEmail = $_POST['facebookEmail'];
			$result = $acc->checkExistEmail($facebookEmail);
			if($result->status == Response::$SUCCESS) {
				if($row = $result->data) {
					$dir = $result->data['email'];
					$_SESSION['accountEmail'] = $dir;
					header("Location: index.php");
					exit();
				}
			}

			// nếu không có tài khoản trước thì tạo tài khoản với facebookEmail, username, còn pass bỏ trống
			require_once($_SERVER['DOCUMENT_ROOT'].'/model/registerDB.php');
			$registerAcc = new registerDB();
			$registerResult = $registerAcc->getFacebook($facebookUsername, $facebookEmail);
			if($registerResult->status == Response::$SUCCESS) {
				//Make directory
				$filename = "/uploads/" . $facebookEmail . "/";
				if(!file_exists($filename))
					mkdir("uploads/" . $facebookEmail, 0777);
				$_SESSION['accountEmail'] = $facebookEmail;
				header("Location: index.php");
			}else if($result->status == Response::$FAILED) {
					echo '<script type="text/javascript">
							 showErrorFB();
						 </script>';
			}else {
				echo "<script>showError()</script>";
			}
		}
    ?>
	
    <script type="text/javascript">
        (function () {
            var p = document.createElement('script');
            p.type = 'text/javascript';
            p.async = true;
            p.src = 'https://apis.google.com/js/client.js?onload=onloadFunction';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(p, s);
        })();
    </script>
</body>
</html>