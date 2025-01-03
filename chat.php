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
    
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
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
        <a href="<?php printf('profile.php?username=%s', $_GET['friend']) ?>" >Profile</a>
        <a href="<?php printf('friends.php?action=remove&friend=%s', $_GET['friend']) ?>" data-bs-toggle="modal" data-bs-target="#removeFriendModal">Remove Friend</a>
    </nav>

    <div class="modal fade" id="removeFriendModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-dark">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Remove friend</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this friend?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="friends.php?action=remove&friend=<?php echo $_GET['friend']?>" class="btn btn-primary">Remove</a>
                </div>
            </div>
        </div>
    </div>

    <div id="chat" class="chat"> <!-- Chat wird per JS erzeugt! -->
    </div> 

    <div class="input-bg"></div>

    
    <div class="chat-input-wrapper">
    <form id="mInput">
        <div class="input-group mb-3">
            <input type="text" name="msg" id="msg" class="form-control"  placeholder="Enter message..." aria-label="Enter message..." aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="sendButton">Send</button>
        </div>
    </form>
    </div>
    


    <script src="chat-js.js"></script>

</body>
</html>