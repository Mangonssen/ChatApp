<?php
require("start.php");
require_once("Utils/BackendService.php");
require_once("Model/User.php");

$backendService = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

if (!isset($_SESSION['user']) && $_SESSION['user'] !== '') {
    header("Location: login.php");
    exit;
} else if (isset($_GET['username']) && !empty($_GET['username'])) {
    $username = $_GET['username'];
    $user = $backendService->loadUser ($username);
} else {
    header("Location: friends.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrapregister-css.css">
    
    <link rel="icon" href="logo.ico" type="image/x-icon">
</head>
<body>

<div class="container mt-5">
    <header class="site-header">
        <div class="logo">
            <!-- Logo hier -->
        </div>
    </header>

    <div class="heading-container-left">
        <h1>Profile of <?php echo htmlspecialchars($user->getUsername()) ?></h1>
    </div>


    
    <hr>

    
    <!-- Navigation -->
    <nav class="links mb-3">
        <a href="#" onclick="history.go(-1)" class="btn btn-secondary">← Back to Chat</a>
        <button class="btn btn-danger" data-toggle="modal" data-target="#removeFriendModal">× Remove Friend</button>
    </nav>

    
    <!-- Profile Picture -->
    <div class="profile-pic text-center mb-4">
        <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallpaperaccess.com%2Ffull%2F2529900.png&f=1&nofb=1" alt="PROFILE PICTURE" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
    </div>

    <!-- Biography -->
    <div class="bio">
        <h3>ABOUT <?php echo strtoupper(htmlspecialchars($user->getUsername())) ?></h3>
        <p><?php echo htmlspecialchars($user->getBio()) ?></p>
    </div>

    <!-- Lower Info -->
    <div class="lower-info">
        <h3>Name</h3>
        <p><?php echo htmlspecialchars($user->getFirstname() . " " . $user->getLastname()) ?></p>
        <h3>Coffee or Tea?</h3>
        <p><?php echo ucfirst(htmlspecialchars($user->getCot())) ?></p>
    
    </div>

        <!-- Change History -->
        <div class="d-flex justify-content-end">
        <div class='change-history'>
        <h3 class='change-history-header'> CHANGE HISTORY </h3>
        <ul class='change-history-list'>
            <?php
            if ($user->getHistory() !== null) {
                foreach ($user->getHistory() as $history) {
                    echo $history;
                }
            } else {
                echo "<li class='change-history-item'>No changes made yet.</li>";
            }
            ?>
        </ul>
    </div>
    </div>
</div>

<!-- Modal for Remove Friend Confirmation -->
<div class="modal fade" id="removeFriendModal" tabindex="-1" role="dialog" aria-labelledby="removeFriendModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeFriendModalLabel">Remove Friend</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to remove this friend?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="<?php printf('friends.php?action=remove&friend=%s', $_GET['username']) ?>" method="POST" style="display:inline;">
                    <button type="submit" class="btn btn-danger">Remove Friend</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
if (isset($_GET['action']) && $_GET['action'] === 'remove_friend' && isset($_GET['friend'])) {
    $friend = $_GET['friend'];

    try {
        // removeFriend-Methode aufrufen
        if ($backendService->removeFriend($friend)) {
            echo "<script>alert('Friend successfully removed!');</script>";
        } else {
            echo "<script>alert('Failed to remove friend. Please try again.');</script>";
        }
    } catch (Exception $e) {
        // Fehlerbehandlung
        error_log("Error removing friend: " . $e->getMessage());
        echo "<script>alert('An error occurred. Please try again later.');</script>";
    }
}
?>