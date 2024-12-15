<?php
require("start.php");
require_once("Utils/BackendService.php");
require_once("Model/User.php");

$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
$service->login("Tom", "12345679");

$testUser = $service->loadUser("Tom");
echo $testUser->getUsername();
echo $testUser->getFirstname();

?>