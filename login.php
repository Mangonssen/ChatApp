<?php
require("start.php");

$errorMessage = '';

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
  <link rel="stylesheet" href="bootstrap.css">
  <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
  <link rel="icon" href="logo.ico" type="image/x-icon">
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

    <div class="heading-container-centered">
      <img src="key-icon.png" alt="login" class="title-icon">
      <h1 id="white-text">Please sign in</h1>
    </div>

    <div class="data-entry">
      <?php if (!empty($errorMessage)): ?>
        <span id="usernameError" class="error-message"><?= $errorMessage ?></span>
      <?php endif; ?>
      <form id="loginForm" action="login.php" method="post">
        <div class="mb-3">
          <label for="username" class="form-label" id="white-text">Username</label>
          <input type="text" name="username" id="username" class="form-control" required oninput="handleOnInput()"
            placeholder="Username" value="<?= $_POST['username'] ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label" id="white-text">Password</label>
          <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
        </div>
        <div class="d-flex justify-content-between">
          <a class="btn btn-secondary" href="register.php" role="button">Register</a>
          <button type="submit" class="btn btn-primary ms-3">Login</button>
        </div>
      </form>

    </div>
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