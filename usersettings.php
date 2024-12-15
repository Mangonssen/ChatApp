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

        <form action="friends.php" method="post">

          <div class="input-set">
            <label for="firstname">First Name</label> 
            <br>
            <input type="text" name="firstname" id="firstname" required placeholder="First Name">
          </div>
        
          <div class="input-set">
            <label for="lastname">Last Name</label>
            <br>
            <input type="text" name="lastname" id="lastname" required placeholder="Last Name">
          </div>

          <div class = "input-set">
            <label for="CoT">Coffee or Tea?</label>
            <br>
            <select name="CoT" id="CoT" required>
                <option value="coffee">Coffee</option>
                <option value="tea">Tea</option>
                <option value="both">Both</option>
                <option value="neither">Neither</option>
            </select>
    </div>



    <!-- BIOGRAPHY -->

    <div class="bio">
    <h2>Your Biography</h2>

        <textarea name="biography" id="biography" cols="30" rows="10"></textarea>
    </div>
    <br>

    <!-- CHAT LAYOUT -->
    <h2>Chat Layout Settings</h2>

    <div class="layout">

        <div class="input-set-radio">
            <input type="radio" name="layoutone" id="layoutone" value="one">
            <label for="layoutone">Layout 1</label>
        </div>
        <div class="input-set-radio">
            <input type="radio" name="layouttwo" id="layouttwo" value="two">
            <label for="layouttwo">Layout 2</label> 
        </div>
        
    </div>
    <br>

    <hr>
    
    <!-- SAVE AND CANCEL -->
    <div class="buttons">
    <button type="submit" id="cancel" onclick="window.location.href='friends.php';">Cancel</button>
    <button type="submit" id="save" onclick="window.location.href='profile.php'">Save</button>
    </div>
    </form>

</div>
</body>
</html>