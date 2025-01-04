<?php 
require("start.php");
require_once("Utils/BackendService.php");
require_once("Model/User.php");

$backendService = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

var_dump ($_SESSION);

echo $backendService->loadUser($_SESSION['user'])->getFirstname();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
</head>
<body>
<div class="container">
<div class="row align-items-start">
<div class="col col-8 bg-white">

    <header class="site-header">
        <!--LOGO-->
        <div class="logo">
            <a href="profile.php">
                <img src="logo.png" alt="logo" id="logo" >
            </a>
        </div>
    </header>

    <!--USER SETTINGS TITLE-->
    <div class="heading-container-left">
        <img src="gear.png" alt="user settings" class="title-icon">
        <h1>User Settings</h1>
    </div>
</div>
<div class="col col-2 border">
    <nav class="links">
        <a href="profile.php">← Back</a>
    </nav>
</div>    

</div>
</div>

</body>
</html>
