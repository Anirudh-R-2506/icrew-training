<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/static/config.php';
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (isset($_POST['submit'])){
    $email = NULL;
    $pass = NULL;
    $name = NULL;
    $bio = NULL;
    $exit = 1;
    if (isset($_POST['email'])){
        echo "<script>alert('Enter an email ID');window.location.href = '/register'</script>";
        $exit = 0;
    }
    else{
        $email = $_POST['email'];
    }
    if (isset($_POST['pass'])){
        echo "<script>alert('Enter a password');window.location.href = '/register'</script>";
        $exit = 0;
    }
    else{
        if ($_POST['pass'] == $_POST['pass2']){
            if (strlen($_POST['pass']) < 8){
                echo "<script>alert('Password must be at least 8 characters long');window.location.href = '/register'</script>";
                $exit = 0;
            }
            else{
                $pass = $_POST['pass'];
            }
        }
        else{
            echo "<script>alert('Passwords do not match');window.location.href = '/register'</script>";
            $exit = 0;
        }
    }
    if (isset($_POST['name'])){
        echo "<script>alert('Enter a name');window.location.href = '/register'</script>";
        $exit = 0;
    }
    else{
        $name = $_POST['name'];
    }
    if (isset($_POST['bio'])){
        echo "<script>alert('Enter a bio');window.location.href = '/register'</script>";
        $exit = 0;
    }
    else{
        $bio = $_POST['bio'];
    }
    if ($exit){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        if ($row['email']){
            echo "<script>alert('Email already exists');window.location.href = '/register'</script>";
        }
        else{
            $sql = "INSERT INTO users (email, password, name, bio) VALUES ('$email', '$pass', '$name', '$bio')";
            if ($link->query($sql)){
                $_SESSION['user_id'] = md5($_SERVER['REMOTE_ADDR']);
                $sql = "UPDATE users SET id = '".$_SESSION['user_id']."' WHERE email = '".$email."'; UPDATE users SET ip = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '".$_SESSION['user_id']."'";
                if ($link->query($sql)){
                    echo "<script>window.location.href = '/profile'</script>";
                }            
                else {
                    echo "<script>alert('Error: ".$link->error."')</script>";
                }
            }
            else {
                echo "<script>alert('Error: ".$link->error."')</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/anim.css">
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
    <script defer src="/static/js/script.js"></script>
</head>
<body>        
    
    <div class="container" style="height: 100vh;">
        <div class="row" style="height: 100%;">
            <div class="col-md-6 anim" data-type="fadeIn" data-delay="0.2s">
                <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_1pxqjqps.json"  background="transparent"  speed="1"  style="width: 90%; height: 90%;margin-top: 10%;"  loop autoplay></lottie-player>
            </div>
            <div class="col-md-6">
                <div class="login-form anim" data-type="fadeIn" data-delay="0.1s">
                    <div class="form-header">
                        <h1><span class="anim" data-type="fadeInUp" data-delay="0.2s">Create</span><br><span class="anim" data-type="fadeInUp" data-delay="0.25s">An Account</span></h1>
                        <p class="anim" data-type="fadeInUp" data-delay="0.3s">Lorum Ipsum Dolor</p>
                    </div>
                    <form action="" id="form-l" class="form-l" method="post">
                        <input name="email" class="input-field anim" data-type="fadeIn" data-delay="0.35s" type="email" placeholder="Email" required>
                        <input name="pass" class="input-field anim" data-type="fadeIn" data-delay="0.4s" type="password" placeholder="Password" required>
                        <input name="pass2" class="input-field anim" data-type="fadeIn" data-delay="0.45s" type="password" placeholder="Confirm Password" required>
                        <input name="name" class="input-field anim" data-type="fadeIn" data-delay="0.5s" type="text" placeholder="Full Name" required>
                        <input name="bio" class="input-field anim" data-type="fadeIn" data-delay="0.55s" type="text" placeholder="Bio" required>
                        <div class="terms-privacy anim" data-type="fadeIn" data-delay="0.6s">
                            <input type="checkbox" class="input-check" required>
                            <label for="terms-privacy-checkbox">I agree to the Terms of Service and Privacy Policy</label>
                        </div>
                        <button name="submit" type="submit" class="anim" data-type="fadeInDown" data-delay="0.65s">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>