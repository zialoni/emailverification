<?php



function redirect() {
    header('Location: register.php');
    exit();
}

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    redirect();
} else {
    $con = mysqli_connect('gator4207.hostgator.com','loni_zia','s0048','loni_phpEmailConfirmation');
    $email = $con->real_escape_string($_GET['email']);
    $token = $con->real_escape_string($_GET['token']);

    $sql = $con->query("SELECT id FROM users WHERE email='$email' AND token='$token' AND isEmailConfirmed=0");

    if ($sql->num_rows > 0) {
        $con->query("UPDATE users SET isEmailConfirmed=1, token='' WHERE email='$email'");
        echo 'Your email has been verified! You can log in now!';
    } else
        redirect();
}

?>