<!DOCTYPE html>

<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="chatapp-css.css">
  <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
  <link rel="icon" href="logo.ico" type="image/x-icon">


</head>

<body>


  <div class="page-container">

    <header class="site-header">
      <a href="profile.html">
        <img src="logo.png" alt="logo" id="logo">
      </a>
    </header>

    <div class="heading-container-centered">
      <img src="register.png" alt="login" class="title-icon">
      <h1>Register</h1>
    </div>
    


    <div class="data-entry">

      <form action="register.php" id="registerForm" method="POST">
        <div class="input-set">
          <label for="username">Username</label><span id="usernameError" class="error-message"></span>
          <br>
          <input type="text" name="username" id="username" required placeholder="Username">
        </div>

        <div class="input-set">
          <label for="password">Password</label><span id="passwordError" class="error-message"></span>
          <br>
          <input type="password" name="password" id="password" required placeholder="Password">
        </div>

        <div class="input-set">
          <label for="confirm-password">Confirm Password</label><span id="confirmPasswordError" class="error-message"></span>
          <br>
          <input type="password" name="confirm-password" id="confirm-password" required placeholder="Confirm Password">
        </div>


        <br>
    </div>


    <div class="buttons">

      <button type="button" onclick="window.location.href='login.php';">Cancel</button>
      <button type="submit">Create Account</button>
    </div>
    </form>
<?php
    require 'start.php'; // Include the required dependencies

$errors = [];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);

    // Validate the inputs
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Der Nutzername muss mindestens 3 Zeichen lang sein.";
    }

    if ($service->userExists($username)) {
        $errors[] = "Der Nutzername ist bereits vergeben.";
    }

    if (empty($password)) {
        $errors[] = "Das Passwort darf nicht leer sein.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Das Passwort muss mindestens 8 Zeichen lang sein.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Die Passwörter stimmen nicht überein.";
    }

    // Register the user if no errors
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Secure password hashing
        $result = $service->register($username, $hashedPassword);
        if ($result) {
            session_start();
            $_SESSION['user'] = $username;
            header("Location: friends.php");
            exit();
        } else {
            $errors[] = "Die Registrierung ist fehlgeschlagen. Bitte versuchen Sie es erneut.";
        }
    }
}
?>
  </div>
  <script src="script.js"></script>
</body>

</html>