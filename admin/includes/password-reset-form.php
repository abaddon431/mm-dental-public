
<!DOCTYPE html>

<html>
<head>
    <title>Reset Password | Mary Mediatrix Dental Clinic</title>
    <link rel="shortcut icon" href="images/favicon.ico">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-icons/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/login-style.css" />
</head>
<body>
<div class="login">
			<div class="reset-head">
			<h1 class="text-uppercase">reset password</h1>
            <p>An email will be sent to your email to reset your password.</p>
			</div>
			<form action="mailing/password-forget.php" class="reset-form" method="post">
				<label for="username">
                    <i class="bi bi-envelope-fill"></i>
				</label>
				<input type="text" name="resetemail" placeholder="user@email" id="resetemail" required>
				<input type="submit" name="resetsubmit" value="Reset Password">
			</form>
            <div class="backlogin">
                <p >
                    <a href="login.php">Go back to Login</a>
                </p>
            </div>
            <?php
                if(isset($_GET['reset']))
                {
                    if($_GET['reset']=="success")
                    {
                        echo '<p class="resetsuccess">The password reset link has been sent to your email.</p>';
                    }
                }
            ?>
		</div>

<script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>