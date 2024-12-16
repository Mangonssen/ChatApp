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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addfriend'])) {
    $friendToAdd = $_POST['addfriend'];
    $friendData = ['username' => $friendToAdd];

    $friendRequestSuccess = $service->friendRequest($friendData);

    if ($friendRequestSuccess) {
        echo "<p>Friend request sent to $friendToAdd.</p>";
    } else {
        echo "<p>Failed to send friend request to $friendToAdd.</p>";
    }
}
?>

<!DOCTYPE html>

<html>

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Friend List</title>
  <link rel="stylesheet" href="chatapp-css.css">
  <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
  <link rel="icon" href="logo.ico" type="image/x-icon">

  <script>
    function loadFriends() {
      fetch("ajax_load_friends.php")
        .then(response => {
          if (response.status === 200) {
            return response.json();
          } else {
            throw new Error("Failed to load friends");
          }
        })
        .then(data => {
          const friendsList = document.getElementById("friends-list");
          friendsList.innerHTML = "";
          data.forEach(friend => {
            const listItem = document.createElement("li");
            listItem.className = "friendnot";
            console.log();
            listItem.innerHTML = `
                        <a class="friend" href="chat.php?friend=${friend.username}">${friend.username} (${friend.status})</a>
                    `;
            friendsList.appendChild(listItem);
          });
        })
        .catch(error => console.error(error));
    }

    window.addEventListener("DOMContentLoaded", loadFriends);
  </script>

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
      <h1>Friends</h1>
    </div>

    <hr>

    <nav class="links">
      <a href="logout.php"> ← Logout</a> <a href="usersettings.php">* Settings</a>
    </nav>

    <ul id="friends-list">

    </ul>

    <hr>

    <div class="friend-requests">
      <h2>New Requests</h2>
      <ol>
        <?php if (!empty($friendRequests)): ?>
          <?php foreach ($friendRequests as $request): ?>
            <li>
              Friend request from <b><?php echo $request->getUsername(); ?></b>
              <a href="friends.php?action=accept&friend=<?php echo $request->getUsername(); ?>">Accept</a>
              <a href="friends.php?action=dismiss&friend=<?php echo $request->getUsername(); ?>">Reject</a>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No new friend requests.</li>
        <?php endif; ?>
      </ol>
    </div>


    <hr>

    <form action="friends.php" method="post">
      <input type="text" name="addfriend" id="addfriend" required placeholder="Add Friend to List">
      <button type="submit">Add</button>
    </form>


  </div>

</body>

</html>