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
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

</head>

<body>

    <div class="page-container">

        <header class="site-header">
            <!--LOGO-->
            <div class="logo">
                <a href="profile.php">
                    <img src="logo.png" alt="logo" id="logo">
                </a>
            </div>
        </header>


        <div class="heading-container-centered">
            <img src="logout.png" alt="logout" class="title-icon">
            <h1 id="white-text">Logged out...</h1>
        </div>


        <div class="goodbye-message" id="white-text">
            <p>See u!</p>
        </div>

        <div class="d-flex justify-content-center">
            <a class="btn btn-primary" href="login.php" role="button">Login again</a>
        </div>



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