<?php
namespace Model;
use JsonSerializable;
class User implements JsonSerializable {


    private $username;
    
    public function __construct($username = null) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
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
}
?>