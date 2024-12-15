<?php

spl_autoload_register(function($class) {
    include str_replace('\\', '/', $class) . '.php';
});

session_start();

define('CHAT_SERVER_URL', 'https://online-lectures-cs.thi.de/chat/');
define('CHAT_SERVER_ID', '54f425ca-c5bd-4a9a-aa30-2b7107f6dbcb');

$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
?>
