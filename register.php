<!DOCTYPE html>
<html lang="en">

<?php
require 'start.php'; // Include the required dependencies

$errors = [];
$usernameError = '';
$passwordError = '';
$confirmPasswordError = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);

    // Validate the inputs
    if (empty($username) || strlen($username) < 3) {
        $usernameError = "Der Nutzername muss mindestens 3 Zeichen lang sein.";
    }

    if ($service->userExists($username)) {
        $usernameError = "Der Nutzername ist bereits vergeben.";
    }

    if (empty($password)) {
        $passwordError = "Das Passwort darf nicht leer sein.";
    }

    if (strlen($password) < 8) {
        $passwordError = "Das Passwort muss mindestens 8 Zeichen lang sein.";
    }

    if ($password !== $confirmPassword) {
        $confirmPasswordError = "Die Passwörter stimmen nicht überein.";
    }

    // Register the user if no errors
    if (empty($usernameError) && empty($passwordError) && empty($confirmPasswordError)) {
        
        $result = $service->register($username, $password);
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootchatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
</head>

<body>
    <div class="container">
        <header class="text- my-4">
            <a href="profile.php">
                <img src="logo.png" alt="logo" id="logo" class="img-fluid">
            </a>
        </header>

        <div class="text-center mb-4">
            <img src="register.png" alt="register" class="title-icon">
            <h1>Register</h1>
        </div>


        
        <div class="data-entry d-flex justify-content-center align-items-center" >
        <div class="col-md-6 col-lg-4" >
        
            <form action="register.php" id="registerForm" method="POST" class="needs-validation" novalidate>
                <div class="form-group">
                 
                    <input type="text" class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>" name="username" id="username" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                    <div class="invalid-feedback">
                        <?php echo $usernameError; ?>
                    </div>
                </div>

                <div class="form-group">
                
                    <input type="password" class="form-control <?php echo !empty($passwordError) ? 'is-invalid' : ''; ?>" name="password" id="password" required placeholder="Password" required>
                    <div class="invalid-feedback">
                        <?php echo $passwordError; ?>
                    </div>
                </div>

                <div class="form-group">
                
                    <input type="password" class="form-control <?php echo !empty($confirmPasswordError) ? 'is-invalid' : ''; ?>" name="confirm-password" id="confirm-password" required placeholder="Confirm Password" required>
                    <div class="invalid-feedback">
                        <?php echo $confirmPasswordError; ?>
                    </div>
                </div>

                <div class="buttons text-center">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='login.php';">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>

       

    </div>



    

    
</body>

</html>