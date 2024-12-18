<?php
namespace Model;
use JsonSerializable;
class User implements JsonSerializable {

    //Properties
    private $username;
    private $firstname;
    private $lastname;
    private $cot;
    private $bio;
    private $layout;
    private $history;
    private $friends;
   
    private $chat_token;
    
    
    public function __construct($username = null) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function getBio() {
        return $this->bio;
    }

    public function setBio($bio) {
        $this->bio = $bio;
    }

    public function getCot() {
        return $this->cot;
    }

    public function setCot($cot) {
        $this->cot = $cot;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function jsonSerialize():mixed {
        return get_object_vars($this);
    }

    public static function fromJSON($data) {
        $user = new self();
        
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }
        return $user;
    }

    public function getToken() {
        return $this->chat_token;
    }

    public function addToHistory($event) {
        $this->history[] = $event;
    }

    public function getHistory() {
        return $this->history;
    }

    public function debugClearHistory() {
        $this->history = null;
    }

    public function addToFriends($user) {
        $this->friends[] = $user;
    }

    public function getFriends() {
        return $this->friends;
    }

    public function debugClearFriends() {
        $this->friends = null;
    }
    
}
?>