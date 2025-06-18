<?php

class LoginModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = getConnection();
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT id, email, password, name FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function validatePassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}
?>
