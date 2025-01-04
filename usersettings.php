<?php 
require("start.php");
require_once("Utils/BackendService.php");
require_once("Model/User.php");

$backendService = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
} else {
    $user = $backendService->loadUser($_SESSION['user']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>

    <link rel="icon" href="logo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="chatapp-css.css">
    <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
</head>
<body>
    
<div class="container">
    <div class="row align-items-start">
    <div class="col col-8">

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

            <form method="POST">

            <div class="input-group mb-2 mt-2">
                <span class="input-group-text border-0" id="basic-addon1">Username</span>
                <input type="text" class="form-control text-white bg-transparent" name="firstname" id="firstname" required placeholder="First Name" value="<?php echo htmlspecialchars($user->getFirstname()); ?>">
            </div>
            
            <div class="input-group mb-2 mt-2">
                <span class="input-group-text border-0" id="basic-addon1">Lastname</span>
                <input type="text" class="form-control text-white bg-transparent" name="lastname" id="lastname" required placeholder="Last Name" value="<?php echo htmlspecialchars($user->getLastname()); ?>">
            </div>

            <div class = "input-set">
                <label for="CoT">Coffee or Tea?</label>
                <br>
                <select class="form-select bg-transparent text-white" name="CoT" id="CoT" required>
                    <option value="coffee" <?php if($user->getCot() === 'coffee') { echo 'selected'; } ?>>Coffee</option>
                    <option value="tea" <?php if($user->getCot() === 'tea') { echo 'selected'; } ?>>Tea</option>
                    <option value="both" <?php if($user->getCot() === 'both') { echo 'selected'; } ?>>Both</option>
                    <option value="neither <?php if($user->getCot() === 'neither') { echo 'selected'; } ?>">Neither</option>
                </select>
            </div>



        <!-- BIOGRAPHY -->

        <div class="bio">
        <h2>Your Biography</h2>

            <textarea class="form-control bg-transparent text-white" name="biography" id="biography" cols="30" rows="10"><?php if ($user->getBio() !== null) { echo htmlspecialchars($user->getBio()); } ?></textarea>
        </div>
        <br>

        <!-- CHAT LAYOUT -->
        <h2>Chat Layout Settings</h2>

        <div class="layout">
                <input type="radio" class ="btn-check" name="layout" id="layoutone" value="layout1" <?php echo ($user->getLayout() === 'layout1') ? 'checked' : ''; ?>>
                <label class="btn btn-outline-light" for="layoutone">
                    Layout 1
                </label>
        
                <input type="radio" class="btn-check" name="layout" id="layouttwo" value="layout2" <?php echo ($user->getLayout() === 'layout2') ? 'checked' : ''; ?>>
                <label class="btn btn-outline-light" for="layouttwo">
                    Layout 2
                </label> 
            
            
        </div>
        <br>

        <hr>

        <!-- SAVE AND CANCEL -->
        <div class="buttons">
            <button class="btn btn-light m-1" type="button" id="cancel" onclick="window.location.href='friends.php';">Cancel</button>
            <button class="btn btn-light m-1" type="submit" id="save">Save</button>
        
        </form>
        </div>
        </div>
    </div>
    
        <div class="col col-4">
          
    


<?php
//CHANGE HISTORY HTML
echo "
<div class='change-history-container m-3'>
    <h3 class='change-history-header'> CHANGE HISTORY </h3>
    <ul class='list-group bg-transparent text-secondary'>";
    if($user->getHistory() !== null)
    {foreach($user->getHistory() as $history){
        echo "<li class='change-history-item'>".$history."</li>";
    }} else {
        echo "<li class='change-history-item'>No changes made yet.</li>";
    }
    echo "</ul></div>";
?>

</div>
</div>
</div>
</body>



<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //CHANGE HISTORY BEFÜLLEN
    if($_POST['firstname'] !== $user->getFirstname()) {
        $user->addToHistory("First Name changed from " . $user->getFirstname() . " to " . $_POST['firstname']
        ."<br><p>[".date('Y-m-d H:i:s')."]</p>");
    }
    if($_POST['lastname'] !== $user->getLastname()) {
        $user->addToHistory("Last Name changed from " . $user->getLastname() . " to " . $_POST['lastname']
        ."<br><p>[".date('Y-m-d H:i:s')."]</p>");
    }
    if($_POST['CoT'] !== $user->getCot()) {
        $user->addToHistory("Preferred drink changed from " . $user->getCot() . " to " . $_POST['CoT']
        ."<br><p>[".date('Y-m-d H:i:s')."]</p>");
    }
    if($_POST['biography'] !== $user->getBio()) {
        $user->addToHistory("Biography changed."
        ."<br><p>[".date('Y-m-d H:i:s')."]</p>");
    }
    if($_POST['layout'] !== $user->getLayout()) {
        $user->addToHistory("Chat layout changed from " . $user->getLayout() . " to " . $_POST['layout']
        ."<br><p>[".date('Y-m-d H:i:s')."]</p>");
    }

    //USER OBJECT UPDATEN
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setBio($_POST['biography']);
    $user->setCot($_POST['CoT']);
    $user->setLayout($_POST['layout']);

    //SESSION UPDATEN
    
    $backendService->loadUser($_SESSION['user'])->setFirstname($user->getFirstname());
    $backendService->loadUser($_SESSION['user'])->setLastname($user->getLastname());
    $backendService->loadUser($_SESSION['user'])->setBio($user->getBio());
    $backendService->loadUser($_SESSION['user'])->setCot($user->getCot());
    $backendService->loadUser($_SESSION['user'])->setLayout($user->getLayout());
    
    //$_SESSION['user']['firstname'] = $user->getFirstname();
    //$_SESSION['user']['lastname'] = $user->getLastname();
    //$_SESSION['user']['bio'] = $user->getBio();
    //$_SESSION['user']['cot'] = $user->getCot();
    //$_SESSION['user']['layout'] = $user->getLayout();

    $backendService->saveUser($user);

    $user = Model\User::fromJSON($backendService->loadUser($_SESSION['user']));

    // Umleitung zur Profilseite mit neuen Parametern
    header("Location: profile.php?username=" . $user->getUsername());
    exit;

}

?>
</html>