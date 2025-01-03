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
    <a href="#" class ="btn btn-primary" data-bs-toggle="modal" data-bs-target="#removeFriendModal">Remove Friend</a>

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

</body>
</html>
