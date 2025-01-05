<?php
require("start.php");

if (isset($_GET['action']) && isset($_GET['friend'])) {
    $action = $_GET['action'];
    $friend = $_GET['friend'];

    if ($action == 'accept') {
        $service->friendAccept($friend);
    } elseif ($action == 'dismiss') {
        $service->friendDismiss($friend);
    } elseif ($action == 'remove') {
        $service->removeFriend($friend);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend List</title>
    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <script src="friendlist-js.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

</head>

<body>
    <div class="page-container">
        <header class="site-header">
            <a href="profile.php">
                <img src="logo.png" alt="logo" id="logo">
            </a>
        </header>

        <div class="heading-container-left">
            <img src="friends.png" alt="friends icon" class="title-icon">
            <h1 id="white-text">Friends</h1>
        </div>

        <hr>

        <nav class="links">
            <a href="logout.php">← Logout</a>
            <a href="usersettings.php">* Settings</a>
        </nav>

        <ul class="list-group" id="friendlist">

        </ul>

        <hr>

        <!-- <div class="modal" id="friendRequestModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Friend Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to accept or reject this friend request?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="acceptRequest()">Accept</button>
                        <button type="button" class="btn btn-danger" onclick="rejectRequest()">Reject</button>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="modal fade" id="friendRequestModal" tabindex="-1" aria-labelledby="friendRequestModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="friendRequestModalLabel">Friend Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="friendRequestText">Do you want to accept the friend request from <b></b>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="acceptButton" class="btn btn-primary">Accept</button>
                        <button type="button" id="rejectButton" class="btn btn-danger">Reject</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="friend-requests" style="color: white;">
            <h2>New Requests</h2>
            <ol id="friendRequests">

            </ol>
        </div> -->

        <hr>

        <form class="input-group mb-3" onsubmit="event.preventDefault(); addFriend();">
            <input type="text" id="addfriend" class="form-control" placeholder="Add Friend" required>
            <button class="btn btn-outline-secondary" type="button" onclick="addFriend()">Add</button>
        </form>
    </div>
</body>
<script>
    function showModal(username) {
        const modal = new bootstrap.Modal(document.getElementById('friendRequestModal'));
        document.getElementById('friendRequestModal').querySelector('.modal-body').innerText =
            `Do you want to accept or reject the friend request from ${username}?`;
        modal.show();
    }

</script>

</html>