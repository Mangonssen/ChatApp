<?php
require("start.php");
require_once("Utils/BackendService.php");
require_once("Model/User.php");

$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

if (!isset($_SESSION['user']) && $_SESSION['user'] !== '') {
    header("Location: login.php");
    exit;
} else {
    $user = $backendService->loadUser($_GET['username']);
    //$user ist nun ein user-objekt, kein array mehr
}


$user = $service->loadUser($_SESSION['user']['username']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
</head>
<body>

    <div class="page-container">



    <header class="site-header">
        <!--LOGO-->
        <div class="logo">
            <a href="chat.html">
                <img src="logo.png" alt="logo" id="logo" >
            </a>
        </div>
    </header>

    <div class="heading-container-left">
        <h1>Profile of <?php echo $user->getUsername()?></h1>
    </div>

    <hr>
    

    <!-- Navigation -->
    <nav class="links">
        <a href="chat.html"> ← Back to Chat</a>  <a href="">× Remove Friend</a>
    </nav>
    <!-- profile picture -->
    
    <div class="profile-pic">
        <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallpaperaccess.com%2Ffull%2F2529900.png&f=1&nofb=1&ipt=21e0e665768c7f694c1241ccfd41be0f1165e9b7eff4488592e7397ae6859bd2&ipo=images" alt="PROFILE PICTURE">
    </div>

     <!-- biography -->

    <div class="bio">
        <h3>ABOUT <?php echo strtoupper($user->getUsername()) ?></h3>
        <p><?php echo $user->getBio()?></p>
    </div>
    
    <!-- lower info -->

    <div class="lower-info">
        <h3>Name</h3>
        <p><?php echo $user->getFirstname()." ".$user->getLastname()?></p>
        <h3>Coffee or Tea?</h3>
        <p><?php echo ucfirst($user->getCot()) ?></p> 
    </div>

   


    </div>
</body>
</html>