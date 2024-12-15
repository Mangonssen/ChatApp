<?php 
require("start.php");
require_once("Utils/BackendService.php");
require_once("Model/User.php");

$backendService = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

if (!isset($_SESSION['user']) && $_SESSION['user'] !== '') {
    header("Location: login.php");
    exit;
} else {
    $user = $backendService->loadUser($_SESSION['user']['username']);
    //$user ist nun ein user-objekt, kein array mehr
}

echo "<b>User:</b> <br>";
var_dump($user);

echo $user->getBio();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
</head>
<body>
    <div class="page-container">

    <header class="site-header">
        <!--LOGO-->
        <div class="logo">
            <a href="profile.php">
                <img src="logo.png" alt="logo" id="logo" >
            </a>
        </div>
    </header>
    
    <!--USER SETTINGS TITLE-->
    <div class="heading-container-left">
        <img src="gear.png" alt="user settings" class="title-icon">
        <h1>User Settings</h1>
    </div>


    <hr>
    <!-- GENERAL SETTINGS-->
    <h2>General Settings</h2>

    <div class="data-entry-left">

        <form action="usersettings.php" method="post">

        <div class="input-set">
            <label for="firstname">First Name</label> 
            <br>
            <input type="text" name="firstname" id="firstname" required placeholder="First Name" value=
            "<?php if ($user->getFirstname() !== null) {echo $user->getFirstname();}?>"
            >
        </div>
        
        <div class="input-set">
            <label for="lastname">Last Name</label>
            <br>
            <input type="text" name="lastname" id="lastname" required placeholder="Last Name" value=
            "<?php if ($user->getLastname() !== null) {echo $user->getLastname();}?>"
            >
        </div>

        <div class = "input-set">
            <label for="CoT">Coffee or Tea?</label>
            <br>
            <select name="CoT" id="CoT" required>
                <option value="coffee" <?php if($user->getCot() === 'coffee') { echo 'selected'; } ?>>Coffee</option>
                <option value="tea" <?php if($user->getCot() === 'tea') { echo 'selected'; } ?>>Tea</option>
                <option value="both" <?php if($user->getCot() === 'both') { echo 'selected'; } ?>>Both</option>
                <option value="neither <?php if($user->getCot() === 'neither') { echo 'selected'; } ?>">Neither</option>
            </select>
        </div>



    <!-- BIOGRAPHY -->

    <div class="bio">
    <h2>Your Biography</h2>

        <textarea name="biography" id="biography" cols="30" rows="10"><?php if ($user->getBio() !== null) { echo htmlspecialchars($user->getBio()); } ?></textarea>
    </div>
    <br>

    <!-- CHAT LAYOUT -->
    <h2>Chat Layout Settings</h2>

    <div class="layout">

        <div class="input-set-radio" name="layout" >
            <input type="radio" name="layout" id="layoutone" value="layout1" <?php echo ($user->getLayout() === 'layout1') ? 'checked' : ''; ?>>
            <label for="layoutone">
                Layout 1
            </label>
        </div>
        <div class="input-set-radio" name="layout">
            <input type="radio" name="layout" id="layouttwo" value="layout2" <?php echo ($user->getLayout() === 'layout2') ? 'checked' : ''; ?>>
            <label for="layouttwo">
                Layout 2
            </label> 
        </div>
        
    </div>
    <br>

    <hr>
    
    <!-- SAVE AND CANCEL -->
    <div class="buttons">
        <button type="button" id="cancel" onclick="window.location.href='friends.php';">Cancel</button>
        <button type="submit" id="save">Save</button>
    </div>
    </form>

</div>
</body>
</html>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setBio($_POST['biography']);
    $user->setCot($_POST['CoT']);
    $user->setLayout($_POST['layout']);

    
    $backendService->saveUser($user);
    $_SESSION['user'] = $user->jsonSerialize();

    //Aktualisierung
    $user = Model\User::fromJSON($_SESSION['user']);

}
?>
