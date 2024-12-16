<?php 
require("start.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}



if (!isset($_GET['friend']) || empty($_GET['friend'])) {
    echo '<script>window.location.href = "friends.php";</script>';
    exit();
}

$chatPartner = htmlspecialchars($_GET['friend']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
    
</head>
<body>

    <div class="page-container">

        <!-- Header mit Logo -->
        <header class="site-header">
            <a href="profile.html">
                <img src="logo.png" alt="logo" id="logo" >
            </a>
        </header>
    
    <!-- Titel -->
    <div id="chat-title" class="heading-container-centered">
      </div>

    <hr>

    <!-- Navigationslinks -->
    <nav class="links">
        <a href="friends.html">← Back</a>
        <a href="profile.html">Profile</a>
        <a href="">Remove Friend</a>
    </nav>

    <div id="chat" class="chat"> <!-- Chat wird per JS erzeugt! -->
    </div> 

    <div class="input-bg"></div>


    <div class="chat-input">
            <form id="mInput">
                <input type="text" name="msg" id="msg" required placeholder="Type a message...">
                <button type="button" id="sendButton">Send</button>
            </form>
    </div>


    <script src="chat-js.js"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
    
</head>
<body>

    <div class="page-container">

        <!-- Header mit Logo -->
        <header class="site-header">
            <a href="profile.php0">
                <img src="logo.png" alt="logo" id="logo" >
            </a>
        </header>
    
    <!-- Titel -->
    <div id="chat-title" class="heading-container-centered">
      </div>

    <hr>

    <!-- Navigationslinks -->
    <nav class="links">
        <a href="friends.php">← Back</a>
        <a href="profile.php">Profile</a>
        <a href="<?php printf('friends.php?action=remove&friend=%s', $_GET['friend']) ?>">Remove Friend</a>
    </nav>

    <div id="chat" class="chat"> <!-- Chat wird per JS erzeugt! -->
    </div> 

    <div class="input-bg"></div>


    <div class="chat-input">
            <form id="mInput">
                <input type="text" name="msg" id="msg" required placeholder="Type a message...">
                <button type="button" id="sendButton">Send</button>
            </form>
    </div>


    <script src="chat-js.js"></script>

</body>
</html>