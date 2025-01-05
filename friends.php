<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend List</title>
    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <script src="friendlist-js.js" defer></script>
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
        <a href="logout.php">← Logout</a>
        <a href="usersettings.php">* Settings</a>
    </nav>

    <ul id="friendlist">

    </ul>

    <hr>

    <div class="friend-requests">
        <h2>New Requests</h2>
        <ol id="friendRequests">

        </ol>
    </div>

    <hr>

    <form onsubmit="event.preventDefault(); addFriend();">
        <input type="text" id="addfriend" placeholder="Add Friend to List" required>
        <button type="submit">Add</button>
    </form>
</div>
</body>

</html>
