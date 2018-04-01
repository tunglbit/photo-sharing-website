<?php
    session_start();
	if(!isset($_SESSION['accountEmail']))
		header("Location: login.php");
    $email = $_SESSION['accountEmail'];

	ob_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/AccountDb.php');
	$acc = new AccountDB();
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/ThemesDb.php');
	$theme = new ThemesDb();
	
	$result = $acc->getRole($email);
	$role = $result->data[0];
	if($role == 'User')
		header("Location: index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Themes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/css/w3.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
	<script language="javascript">
		function deleteTheme_ajax(name) {
			var yes = confirm("Are you sure?")
			if(yes == true) {
				$.ajax({
					url : "ajax/deleteTheme.php",
					type : "post",
					dataType:"text",
					data : {
						name: name
					},
					success : function (result) {
						window.location.reload();
					}	
				});
			}
		}
		
		function addTheme_ajax() {
			var name = document.getElementById("addText").value;
			$.ajax({
				url : "ajax/addTheme.php",
				type : "post",
				dataType:"text",
				data : {
					name: name
				},
				success : function (result) {
					window.location.reload();
				}	
			});
		}
	</script>
  
	<style>
		#deleteButton {
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
			<?php
				if($role == 'Administrator') {
					echo '<li class="nav-item">
							<a class="nav-link" href="assignRole.php">Roles</a>
						  </li>';
				}
				if($role != 'User') {
					echo '<li class="nav-item active">
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
	<table cellspacing="10">
		<tbody>
			<tr bgcolor = '#CCCCCC'>
				<td style="padding: 5px; text-align: center"><b>Theme</b></td>
			</tr>
	<?php
		$result = $theme->getTheme();
		if($result->status == Response::$SUCCESS) {
			foreach($result->data as $item) {
				$name = $item['name'];
					echo '<tr><form method="POST">
							<td><p style="margin-bottom: 0px;padding-bottom: 0px;padding-left: 5px">' . $name . '</a></td> 
								<td><button type="button" name="delete" id="deleteButton" class="btn btn-danger" onclick="deleteTheme_ajax(' . "'" . $name . "'" . ')"/>Delete</button></td>
							</p>
						  </form></tr>';
			}
		}
	?>
		</tbody>
	</table>
	<form method="POST">
		<input type="text" name="addText" id="addText">
		<button type="button" name="add" id="addButton" class="btn btn-success" onclick="addTheme_ajax()"/>Add</button>
	</form>
	
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