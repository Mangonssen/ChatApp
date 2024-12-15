<?php
require("start.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  try {
    if ($service->login($username, $password)) {
      $_SESSION['user'] = $username;
      header("Location: friends.php");
      exit();
    } else {
      $errorMessage = "Incorrect username or password";
    }
  } catch (Exception $e) {
    $errorMessage = "An error occurred: " . $e->getMessage();
  }
}
?>
<!DOCTYPE html>

<html>

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="chatapp-css.css">
  <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
  <link rel="icon" href="logo.ico" type="image/x-icon">

</head>

<body>

  <div class="page-container">

    <header class="site-header">
      <a href="profile.php">
        <img src="logo.png" alt="logo" id="logo">
      </a>
    </header>

    <div class="heading-container-centered">
      <img src="key-icon.png" alt="login" class="title-icon">
      <h1>Please sign in</h1>
    </div>

    <div class="data-entry">
      <form id="loginForm" action="login.php" method="post">
  
        <div class="input-set">
          <label for="username">Username</label>
          <?php if (!empty($errorMessage)): ?>
          <span id="usernameError" class="error-message"><?= $errorMessage ?></span>
        <?php endif; ?>
          <br>
          <input type="text" name="username" id="username" required oninput="handleOnInput()" placeholder="Username"
            value="<?= $_POST['username'] ?? ''; ?>">
        </div>

        <div class="input-set">
          <label for="password">Password</label>
          <br>
          <input type="password" name="password" id="password" required placeholder="Password">
        </div>
        <br>

        <div class="buttons">

          <a id="regButton" href="register.php">Register</a>
          <button type="submit">Login</button>
        </div>

      </form>
    </div>
    <script>
      function handleOnInput() {
        const usernameError = document.getElementById('usernameError');
        if (usernameError) {
          usernameError.remove();
        }
      }
    </script>

</body>

</html>