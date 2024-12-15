<?php
namespace Model;
use JsonSerializable;
class Friend implements JsonSerializable {
    private string $username;    private string $status;
    public function __construct(string $username, string $status = "offline") {
        $this->username = $username;
        $this->status = $status;
    }
    public function getUsername(): string {
        return $this->username;
    }
    public function getStatus(): string {
        return $this->status;
    }
    public function setStatus(string $status): void {
        $this->status = $status;
    }
    public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }
    public static function fromJson($data): Friend {
        return new self($data->username, $data->status ?? "offline");
    }
}

?>
