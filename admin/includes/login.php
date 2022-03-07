<?php
	session_start();
	if(isset($_SESSION['username'])){
		header("location:../index.php");
	}
	// if(isset($_SESSION['username'])&& $_SESSION['role']=="admin"){
	// 	header("location:../index.php");
	// }
?>
<!DOCTYPE html>

<html>
<head>
    <title>Login Page | Mary Mediatrix Dental Clinic</title>
    <link rel="shortcut icon" href="images/favicon.ico">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-icons/bootstrap-icons.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">   -->
    <link rel="stylesheet" href="../css/login-style.css" />
</head>
<body>
		<!-- 	<img src="../images/mediatrix-main-logo.svg" width="250" alt="Girl in a jacket">  -->
        <div class="login">
			<div class="login-head">
			<h1 class="text-uppercase">login</h1>
			</div>
			<form class="login-form" method="post">
				<label for="username">
				<i class="bi bi-person-fill"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="bi bi-key-fill"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
			<div class="login-head">
			<h1>
				<a href="password-reset-form.php">Forgot your password?</a>
			</h1>
			</div>
		</div>

<script src="../js/jquery/jquery-3.6.0.min.js"></script>
<script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../js/login.js"></script>
</body>
</html>