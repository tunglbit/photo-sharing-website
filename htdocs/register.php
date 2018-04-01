<?php
    session_start();
	
    ob_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/registerDB.php');
    $acc = new registerDB();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="vendor/css/style.css">
    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <script src="vendor/jquery.min.js"></script>
    <script src="vendor/bootstrap.min.js"></script>
	<script src="vendor/js/jquery.min.js"></script>
	<script src="vendor/js/index.js"></script>

	<script>
		function showError() {
			$(".alert-danger").fadeIn(1500);
			setTimeout(function () {
				$(".alert-danger").fadeOut(3000);
			},3000);
		}
	</script>
</head>
<body>
  <div class="register-page">
    <div class="form"style="margin-bottom: 20px; margin-top: 10px;padding-top: 5px; padding-bottom: 20px">
		<h2 style="margin-top: 5px"><b>Sign Up</b></h2>
		<form class="register-page" method="post">
			<input type="text" placeholder="Name" name="name"/>
			<input type="email" placeholder="Email" name="email"/>
			<input type="password" placeholder="Password" name="pass"/>
			<button>Register</button>
			<p class="message">Back to <a href="login.php">Login Page</a></p>
		</form>		
    </div>
  </div>
  
  <?php
        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pass'])) {
			$name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
			
            $result = $acc->get($name,$email, $pass);
            if($result->status == Response::$SUCCESS) {
				//Make directory
                $filename = "/uploads/" . $email . "/";
                if(!file_exists($filename))
                    mkdir("uploads/" . $email, 0777);
                $_SESSION['accountEmail'] = $email;
                header("Location: login.php");
            }else if($result->status == Response::$FAILED) {
                echo "<script>showError()</script>";
            }else {
                echo "<script>showError()</script>";
            }
        }
  ?>
</body>
</html>