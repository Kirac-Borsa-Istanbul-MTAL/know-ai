<?php

class RegisterModel {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function createUser($email, $password, $name) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->conn->prepare("INSERT INTO users (email, password, name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashed_password, $name);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'user_id' => $stmt->insert_id,
                'email' => $email,
                'name' => $name
            ];
        }
        
        return [
            'success' => false,
            'error' => 'Registration failed'
        ];
    }
}
?>
