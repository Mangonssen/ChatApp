<!DOCTYPE html>

<html>

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Friend List</title>
  <link rel="stylesheet" href="chatapp-css.css">
  <link rel="stylesheet" href="https://use.typekit.net/ngh4elb.css">
  <link rel="icon" href="logo.ico" type="image/x-icon">

</head>

<body>

<div class="page-container">


  <header class="site-header">
    <a href="profile.html">
        <img src="logo.png" alt="logo" id="logo" >
    </a>
</header>


<div class="heading-container-left">
  <img src="friends.png" alt="friends icon" class="title-icon">
  <h1>Friends</h1>
</div>

<hr>

<nav class="links">
  <a href="logout.html"> ← Logout</a>  <a href="usersettings.html">* Settings</a>
</nav>

<ul id="friendlist">


</ul>

<hr> 
<div class="friend-requests">

<h2>New Requests</h2>



<ol id="friendRequests">

<li>Friend request from <b>Track</b> <button type="Request">Accept</button> <button type="Request">Reject</button></li>

</ol>

</div>

<hr> 

<form action ="friends.html" method="post">


<input type="text" name="addfriend" id="addfriend" required placeholder="Add Friend to List"> 

<button id="addfriend" type="add">Add</button>
</form>

</div>
</div>
<script src="mainJS.js"></script>
<script src="friendlist-js.js">
  
</script>
</body>

</html>