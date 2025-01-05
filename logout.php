<?php
session_start();
session_unset();
session_destroy();

// header("Location: login.php");
// exit();
?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">

</head>

<body>

<div class="page-container">

<header class="site-header">
    <!--LOGO-->
    <div class="logo">
        <a href="profile.php">
            <img src="logo.png" alt="logo" id="logo" >
        </a>
    </div>
</header>
    

<div class="heading-container-centered">
    <img src="logout.png" alt="logout" class="title-icon">
    <h1>Logged out...</h1>
  </div>


<div class="goodbye-message">
<p>See u!</p>    
</div>

<nav class="links-centered">
    <a href="login.php"> Login again</a>
</nav>


</div>


</body>

</html>