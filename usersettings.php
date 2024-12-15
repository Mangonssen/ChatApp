<?php 
require("start.php");
require_once("Utils/BackendService.php");
require_once("Model/User.php");

$backendService = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

$testUser = new \Model\User();
$testUser->setUsername("testuser");
$testUser->setFirstname("Max");
$testUser->setLastname("Mustermann");
$testUser->setBio("I am a test user");
$testUser->setCot("coffee");
$testUser->setLayout("one");

$backendService->register($testUser->getUsername(),"11223344");

echo $testUser->getUsername();
echo $testUser->getFirstname();
echo $testUser->getLastname();
echo $testUser->getBio();
echo $testUser->getCot();
echo $testUser->getLayout();

$_SESSION['user'] = $testUser->jsonSerialize();
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
            <input type="text" name="firstname" id="firstname" required placeholder="First Name" value="<?php if(isset($_POST['firstname'])) { echo $_POST['firstname']; } ?>">
        </div>
        
        <div class="input-set">
            <label for="lastname">Last Name</label>
            <br>
            <input type="text" name="lastname" id="lastname" required placeholder="Last Name" value="<?php if(isset($_POST['lastname'])) { echo $_POST['lastname']; } ?>">
        </div>

        <div class = "input-set">
            <label for="CoT">Coffee or Tea?</label>
            <br>
            <select name="CoT" id="CoT" required>
                <option value="coffee" <?php if(isset($_POST['CoT'])&& $_POST['CoT'] === 'coffee') { echo 'selected'; } ?>>Coffee</option>
                <option value="tea" <?php if(isset($_POST['CoT'])&& $_POST['CoT'] === 'tea') { echo 'selected'; } ?>>Tea</option>
                <option value="both" <?php if(isset($_POST['CoT'])&& $_POST['CoT'] === 'both') { echo 'selected'; } ?>>Both</option>
                <option value="neither <?php if(isset($_POST['CoT'])&& $_POST['CoT'] === 'neither') { echo 'selected'; } ?>">Neither</option>
            </select>
        </div>



    <!-- BIOGRAPHY -->

    <div class="bio">
    <h2>Your Biography</h2>

        <textarea name="biography" id="biography" cols="30" rows="10"><?php if (isset($_POST['biography'])) { echo htmlspecialchars($_POST['biography']); } ?></textarea>
    </div>
    <br>

    <!-- CHAT LAYOUT -->
    <h2>Chat Layout Settings</h2>

    <div class="layout">

        <div class="input-set-radio" name="layout" value="one" <?php echo (isset($userData['layout']) && $userData['layout'] === 'one') ? 'checked' : ''; ?>>
            <input type="radio" name="layoutone" id="layoutone" value="one">
            <label for="layoutone">Layout 1</label>
        </div>
        <div class="input-set-radio" name="layout" value="two" <?php echo (isset($userData['layout']) && $userData['layout'] === 'two') ? 'checked' : ''; ?>>
            <input type="radio" name="layouttwo" id="layouttwo" value="two">
            <label for="layouttwo">Layout 2</label> 
        </div>
        
    </div>
    <br>

    <hr>
    
    <!-- SAVE AND CANCEL -->
    <div class="buttons">
        <button type="button" id="cancel" onclick="window.location.href='aaa.php';">Cancel</button>
        <button type="submit" id="save">Save</button>
    </div>
    </form>

</div>
</body>
</html>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new Model\User($_SESSION['user']['username']);
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setCot($_POST['CoT']);
    $user->setBio($_POST['biography']);
    $user->setLayout($_POST['layoutone']);
    $user->setLayout($_POST['layouttwo']);

    $backendService->saveUser($user);
}

echo "<br>";
var_dump($_POST);
?>
