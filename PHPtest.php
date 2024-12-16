<?php 
require("start.php");
require_once("Utils/BackendService.php");
require_once("Model/User.php");

$backendService = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

var_dump ($_SESSION);

echo $backendService->loadUser($_SESSION['user'])->getFirstname();




?>
