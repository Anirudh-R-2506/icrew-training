<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/static/config.php';
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
function logged_in ($link) {
    if(isset($_SESSION['user_id']) && check_login($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $link)) {
        return true;
    } else {
        return false;
    }
}
if (logged_in($link)){?>
    <script>
        window.location.href = "/profile";
    </script>
<?php    
}
if (isset($_POST['submit1'])){
    $user = NULL;
    $pass = NULL;
    if (!isset($_POST['email'])){
        echo "<script>alert('Enter an email ID');window.location.href = '/'</script>";
    }
    else{
        $user = $_POST['email'];
    }
    if (!isset($_POST['pass'])){
        echo "<script>alert('Enter a password');window.location.href = '/'</script>";
    }
    else{
        $pass = $_POST['pass'];
    }
    if ($user && $pass){
        $sql = "SELECT * FROM users WHERE email = '$user'";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        if (!$row){
            echo "<script>alert('Account does not exist. Please sign up');window.location.href = '/'</script>";
        }
        if ($row['password'] == $pass){
            $_SESSION['user_id'] = md5($_SERVER['REMOTE_ADDR']);
            $sql = "UPDATE users SET id = '".$_SESSION['user_id']."' WHERE email = '".$user."';UPDATE users SET ip = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '".$_SESSION['user_id']."'";
            $link->multi_query($sql);
            echo "<script>window.location.href = '/profile'</script>";
        }
        else{
            echo "<script>alert('Incorrect Password');window.location.href = '/'</script>";
        }
    }
}
if (isset($_POST['submit2'])){
    $email = NULL;
    $pass = NULL;
    $name = NULL;
    $bio = 'Just another homosapien';
    $exit = 1;
    if (!isset($_POST['email'])){
        echo "<script>alert('Enter an email ID');window.location.href = '/'</script>";
        $exit = 0;
    }
    else{
        $email = $_POST['email'];
    }
    if (!isset($_POST['pass'])){
        echo "<script>alert('Enter a password');window.location.href = '/'</script>";
        $exit = 0;
    }
    else{
        if ($_POST['pass'] == $_POST['pass2']){
            if (strlen($_POST['pass']) < 8){
                echo "<script>alert('Password must be at least 8 characters long');window.location.href = '/'</script>";
                $exit = 0;
            }
            else{
                $pass = $_POST['pass'];
            }
        }
        else{
            echo "<script>alert('Passwords do not match');window.location.href = '/'</script>";
            $exit = 0;
        }
    }
    if (!isset($_POST['name'])){
        echo "<script>alert('Enter a name');window.location.href = '/'</script>";
        $exit = 0;
    }
    else{
        $name = $_POST['name'];
    }
    if ($exit){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $link->query($sql);
        $row = $result->fetch_assoc();
        if ($row['email']){
            echo "<script>alert('Email already exists');window.location.href = '/'</script>";
        }
        else{
            $_SESSION['user_id'] = md5($_SERVER['REMOTE_ADDR']);
            $sql = "INSERT INTO users (email, password, name, bio, id, ip) VALUES ('$email', '$pass', '$name', '$bio', '".$_SESSION['user_id']."', '".$_SERVER['REMOTE_ADDR']."')";
            print($sql);
            if ($link->query($sql)){
                echo "<script>window.location.href = '/profile'</script>";
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
    <title>Welcome</title>
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
            <div class="col-md-6 anim" id="l-svg" data-type="fadeIn" data-delay="0.2s">
                <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_q5pk6p1k.json"  background="transparent"  speed="1"  style="width: 90%; height: 90%;margin-top: 10%;"  loop autoplay></lottie-player>                
            </div>
            <div class="col-md-6 anim hide" id="r-svg" data-type="fadeIn" data-delay="0.2s">
                <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_1pxqjqps.json"  background="transparent"  speed="1"  style="width: 90%; height: 90%;margin-top: 10%;"  loop autoplay></lottie-player>                
            </div>
            <div class="col-md-6">
                <div class="login-form anim" data-type="fadeIn" data-delay="0.1s">
                    <div class="row">
                        <div class="col-md-6"><!--style="border-right: 1px solid grey;"-->
                            <button id="switch-btn-1" class="active-page" disabled="true">Login</button>
                        </div>
                        <div class="col-md-6">
                            <button id="switch-btn-2">Sign Up</button>
                        </div>
                    </div>
                    <div id="login-sec" class="active">
                        <div class="form-header">                        
                            <h1><span class="anim" data-type="fadeInUp" data-delay="0.2s">Welcome</span><br><span class="anim" data-type="fadeInUp" data-delay="0.25s">Back</span></h1>
                            <p class="anim" data-type="fadeInUp" data-delay="0.3s">Lorum Ipsum Dolor</p>
                        </div>
                        <form action="" id="form-l" class="form-l" method="post">
                            <input name="email" class="input-field anim" data-type="fadeIn" data-delay="0.35s" type="email" placeholder="Email" required>
                            <input name="pass" class="input-field anim" data-type="fadeIn" data-delay="0.4s" type="password" placeholder="Password" required>
                            <p class="anim" data-type="fadeIn" data-delay="0.45s"><a href="#">Forgot Password</a></p>
                            <button name="submit1" type="submit" class="anim" data-type="fadeInDown" data-delay="0.5s">Login</button>
                        </form>
                    </div>
                    <div id="register-sec" class="hide">
                        <div class="form-header">
                            <h1><span class="anim" data-type="fadeInUp" data-delay="0.2s">Create</span><br><span class="anim" data-type="fadeInUp" data-delay="0.25s">An Account</span></h1>
                            <p class="anim" data-type="fadeInUp" data-delay="0.3s">Lorum Ipsum Dolor</p>
                        </div>
                        <form action="" id="form-r" class="form-l" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="input-field anim" data-type="fadeIn" data-delay="0.35s" type="text" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-md-6">
                                    <input class="input-field anim" data-type="fadeIn" data-delay="0.4s" type="text" name="name" placeholder="Full Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="input-field anim" data-type="fadeIn" data-delay="0.4s" type="password" name="pass" placeholder="Password" required>
                                </div>
                                <div class="col-md-6">
                                    <input class="input-field anim" data-type="fadeIn" data-delay="0.45s" type="password" name="pass2" placeholder="Confirm Password" required>
                                </div>
                            </div>                                    
                            <div class="terms-privacy anim" data-type="fadeIn" data-delay="0.5s">
                                <input type="checkbox" class="input-check" required name="terms">
                                <label for="terms-privacy-checkbox">I agree to the Terms of Service and Privacy Policy</label>
                            </div>
                            <button name="submit2" type="submit" class="anim" data-type="fadeInDown" data-delay="0.55s">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
    let switchLogin = $('#switch-btn-1');
        switchRegister = $('#switch-btn-2');
        loginForm = $('#login-sec');
        registerForm = $('#register-sec');
        loginSVG = $('#l-svg');
        registerSVG = $('#r-svg');
    switchLogin.click(function(){
        registerForm.fadeOut(300, function(){
            registerForm.removeClass('active');
            registerForm.addClass('hide');
            loginForm.fadeIn(300);
            loginForm.removeClass('hide');
            loginForm.addClass('active');
            registerSVG.fadeOut(300, function(){
                registerSVG.removeClass('active');
                registerSVG.addClass('hide');
                loginSVG.fadeIn(300);
                loginSVG.removeClass('hide');
                loginSVG.addClass('active');
            });
        });
        switchLogin.addClass('active-page');
        switchRegister.removeClass('active-page');
        switchRegister.prop('disabled',false);        
        switchLogin.prop('disabled',true);
    });
    switchRegister.click(function(){
        loginForm.fadeOut(300, function(){
            loginForm.removeClass('active');
            loginForm.addClass('hide');
            registerForm.fadeIn(300);
            registerForm.removeClass('hide');
            registerForm.addClass('active');
            loginSVG.fadeOut(300, function(){
                loginSVG.removeClass('active');
                loginSVG.addClass('hide');
                registerSVG.fadeIn(300);
                registerSVG.removeClass('hide');
                registerSVG.addClass('active');
            });
        });
        switchLogin.removeClass('active-page');
        switchRegister.addClass('active-page');
        switchLogin.prop('disabled',false);        
        switchRegister.prop('disabled',true);
    });
});
    </script>
</body>
</html>