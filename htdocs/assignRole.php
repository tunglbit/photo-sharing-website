<?php
    session_start();
	if(!isset($_SESSION['accountEmail']))
		header("Location: login.php");
    $name = $_SESSION['accountEmail'];

	ob_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
	$acc = new AccountDB();
	
	$result = $acc->getRole($name);
	$role = $result->data[0];
	if($role != 'Administrator')
		header("Location: index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Roles</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/css/w3.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	
	<script language="javascript">
		function setrole_ajax(role, email) {
			$.ajax({
				url : "ajax/role.php",
				type : "post",
				dataType:"text",
				data : {
					role : role,
					email: email
				},
				success : function (result) {
					
				}	
			});
		}
	</script>
	
	<style>
		#setButton {
			height: 21px;
			padding-bottom: 0px;
			padding-top: 0px;
			border-top-width: 0px;
			border-bottom-width: 0px;
		}
		
		td {
			padding-right: 5px;
			padding-bottom: 10px;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Gallery</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="assignRole.php">Roles
				<span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="managetheme.php">Themes
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home
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
	<center>
	<table cellspacing="10">
		<tbody>
	<?php
		$result = $acc->getAccount();
		if($result->status == Response::$SUCCESS) {
			foreach($result->data as $item) {
				$email = $item['email'];
				$role = $item['role'];
				if($role != 'Administrator') {
					echo '<tr><form method="POST">
							<td><p style="margin-bottom: 0px;padding-bottom: 0px">'; echo '<a href="showUser.php?owner=' . $email . '">' . $email . '</a></td> 
								<td><select name="role">
									<option '; if(isset($role) && $role == "Moderator") echo "selected"; echo '>Moderator</option>
									<option '; if(isset($role) && $role == "User") echo "selected"; echo '>User</option>
								</select></td>
								<td><button type="button" name="set" id="setButton" class="btn btn-success" onclick="setrole_ajax(role.value,' . "'" . $email . "'" . ')"/>Set</button></td>
							</p>
							<div style="clear: both;"></div>
						  </form></tr>';
				}
			}
		}
	?>
		</tbody>
	</table>
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