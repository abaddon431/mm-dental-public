<!DOCTYPE html>
<html>
<head>
    <title>Create New Password | Mary Mediatrix Dental Clinic</title>
    <link rel="shortcut icon" href="images/favicon.ico">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-icons/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/login-style.css" />
</head>
<body>
            <?php
                $selector=$_GET['selector'];
                $validator=$_GET['validator'];
                if(empty($selector)||empty($validator))
                {
                    echo "<p class='text-center failed-request'>could not validate your request!</p>";
                }
                else
                {
                    if(ctype_xdigit($selector)!==false && ctype_xdigit($validator)!==false)
                    {
                        ?>
                        <div class="login">
                            <div class="login-head">
                                <h1 class="text-uppercase">Create New Password</h1>
                            </div>
                            <form action="mailing/reset-password.php" class="createpassform" method="post">
                                <input type="hidden" name="selector" value="<?php echo $selector?>">
                                <input type="hidden" name="validator" value="<?php echo $validator?>">
                                
                                <label for="password" generated="true" class="error"></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label for="password">
                                            <i class="bi bi-key-fill"></i>
                                        </label>
                                    </div>
                                    <input type="password" name="password" placeholder="Type New Password" id="password">
                                </div>
                                <label for="cpassword" generated="true" class="error"></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label for="cpassword">
                                            <i class="bi bi-key-fill"></i>
                                        </label>
                                    </div>
                                    <input type="password" name="cpassword" placeholder="Confirm New Password" id="cpassword" required>
                                </div>
                                <input type="submit" name="createpassword" value="Create New Password">
                            </form>
			
                        </div>
                        <?php
                    }
                }
            ?>

<script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../js/jquery/jquery-3.6.0.min.js"></script>
<script src="../js/jquery/jquery.validate.min.js"></script>
<script src="../js/jquery/jquery.validate.extend.js"></script>
<script>
    $(document).ready(function(){
        function formValidation()
        {
            $('.createpassform').validate({ // initialize the plugin
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                cpassword:{
                    required:true,
                    equalTo:'#password'
                }
            },
                messages:{
                    password: {
                    required: "*Please enter a password",
                    minlength: "Password should be 8 characters long!"
                },
                cpassword:{
                    required:"*Please confirm password",
                    equalTo:"Passwords do not match!"
                }
            }
            });
        }
        formValidation();
    });
</script> 
</body>
</html>