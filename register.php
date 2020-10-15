

<?php

$msg = "";
	use PHPMailer\PHPMailer\PHPMailer;

	if (isset($_POST['submit'])) {
		$con = mysqli_connect('gator4207.hostgator.com','loni_zia','s0048','loni_phpEmailConfirmation');

		$name = $con->real_escape_string($_POST['name']);
		$email = $con->real_escape_string($_POST['email']);
		$password = $con->real_escape_string($_POST['password']);
		$cPassword = $con->real_escape_string($_POST['cPassword']);

		if ($name == "" || $email == "" || $password != $cPassword)
			$msg = "Please check your inputs!";
		else {
			$sql = $con->query("SELECT id FROM users WHERE email='$email'");
			if ($sql->num_rows > 0) {
				$msg = "Email already exists in the database!";
			} else {
				$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);

				$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

				$con->query("INSERT INTO users (name,email,password,isEmailConfirmed,token)
					VALUES ('$name', '$email', '$hashedPassword', '0', '$token');
				");

                include_once "PHPMailer/PHPMailer.php";

                $mail = new PHPMailer();
                $mail->setFrom('hello@markhormedia.com');
                $mail->addAddress($email, $name);
                $mail->Subject = "Please verify email!";
                $mail->isHTML(true);
                $mail->Body = "
                    Please click on the link below:<br><br>
                    
                    <a href='https://markhormedia.org/phpemailconfirmation/confirm.php?email=$email&token=$token'>Click Here</a>";

                if ($mail->send())
                    $msg = "You have been registered! Please verify your email!";
                else
                    $msg = "Something wrong happened! Please try again!";
			}
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
  <div class="container" style="margin-top: 100px;">
     <div class="row justify-content-center">
       <div class="col-md-6 col-md-offset-3 align-center">

        <?php if($msg != "") echo $msg . "<br><br>" ?>

         <form method="post" action="register.php">
             <input class="form-control" name="name" placeholder="Name..."><br>
             <input class="form-control" name="email" type="email" placeholder="Email..."><br>
             <input class="form-control" name="password" type="password" placeholder="Password..."><br>
             <input class="form-control" name="cPassword" type="password" placeholder="Confirm Password..."><br>
             <input class="btn btn-primary" type="submit" name="submit" value="Register"><br>
         </form>
       <div>
     </div> 
  </div>   
</body>
</html>