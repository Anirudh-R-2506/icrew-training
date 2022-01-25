<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/static/config.php';
function logged_in ($link) {
    if(isset($_SESSION['user_id']) && check_login($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $link)) {
        return true;
    } else {
        return false;
    }
}
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (logged_in($link)){
    $result = $link->query("SELECT * FROM users WHERE id = '".$_SESSION['user_id']."'");
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $u_name = $row['username'];
    $bio = $row['bio'];
}
else{?>
    <script>
        window.location.href = "/login";
    </script>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            <div class="col-md-12">
                <div class="profile anim" data-type="fadeIn" data-delay="0.1s">
                    <img src="https://i.pinimg.com/236x/d9/d7/22/d9d722f1edfada6cb505b93bbdaca9dd--correct-psychology.jpg" alt="">
                    <div class="profile-header">
                        <h1 class="anim" data-type="fadeInUp" data-delay="0.2s"><?php echo $name;?></h1>                        
                        <p class="anim profile-details" data-type="fadeInUp" data-delay="0.25s">@<?php echo $u_name;?></p>
                    </div>
                    <div class="profile-details">
                        <div class="interactions">
                            <span class="anim" data-type="fadeInUp" data-delay="0.3s">100</span>&nbsp;<p class="mb-0 anim" data-type="fadeInUp" data-delay="0.3s">Followers</p>&nbsp;&nbsp;<span class="anim" data-type="fadeInUp" data-delay="0.35s">200</span>&nbsp;<p class="mb-0 anim" data-type="fadeInUp" data-delay="0.35s">Following</p>
                        </div>
                        <div class="bio">
                            <p class="mb-0 anim" data-type="fadeInUp" data-delay="0.4s"><?php echo $bio;?></p>
                        </div>
                    </div>
                    <button class="anim" data-type="fadeInDown" data-delay="0.55s">Update Profile</button>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>