<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/static/config.php';
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (isset($_POST['submit'])){
    $user = NULL;
    $pass = NULL;
    if (isset($_POST['user'])){
        echo "<script>alert('Enter an email ID')</script>";
    }
    else{
        $user = $_POST['user'];
    }
    if (isset($_POST['pass'])){
        echo "<script>alert('Enter a password')</script>";
    }
    else{
        $pass = $_POST['pass'];
    }
    if ($user && $pass){
        $sql = "SELECT * FROM users WHERE email = '$user'";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        if ($row['password'] == $pass){
            $_SESSION['user_id'] = md5($_SERVER['REMOTE_ADDR']);
            $sql = "UPDATE users SET id = '".$_SESSION['user_id']."' WHERE email = '".$user."'; UPDATE users SET ip = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '".$_SESSION['user_id']."'";
            if ($link->query($sql)){
                echo "<script>window.location.href = '/profile'</script>";
            }            
            else {
                echo "<script>alert('Error: ".$link->error."')</script>";
            }
        }
        else{
            echo "<script>alert('Incorrect Password')</script>";
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
    <title>Login</title>
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
                <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_q5pk6p1k.json"  background="transparent"  speed="1"  style="width: 90%; height: 90%;margin-top: 10%;"  loop autoplay></lottie-player>                
            </div>
            <div class="col-md-6">
                <div class="login-form anim" data-type="fadeIn" data-delay="0.1s">
                    <div class="form-header">
                        <h1><span class="anim" data-type="fadeInUp" data-delay="0.2s">Welcome</span><br><span class="anim" data-type="fadeInUp" data-delay="0.25s">Back</span></h1>
                        <p class="anim" data-type="fadeInUp" data-delay="0.3s">Lorum Ipsum Dolor</p>
                    </div>
                    <form action="" id="form-l" class="form-l" method="post">
                        <input name="user" class="input-field anim" data-type="fadeIn" data-delay="0.35s" type="email" placeholder="Email" required>
                        <input name="pass" class="input-field anim" data-type="fadeIn" data-delay="0.4s" type="password" placeholder="Password" required>
                        <p class="anim" data-type="fadeIn" data-delay="0.45s"><a href="#">Forgot Password</a></p>
                        <p class="anim mt10" data-type="fadeIn" data-delay="0.5s"><a href="/register">Register</a></p>
                        <button name="submit" type="submit" class="anim" data-type="fadeInDown" data-delay="0.55s">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>