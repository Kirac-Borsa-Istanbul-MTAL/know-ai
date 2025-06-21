<?php
class SearchModel {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function updateUserSearchLevel($userId, $searchLevel) {
        $stmt = $this->conn->prepare("UPDATE users SET searchLevel = ? WHERE id = ?");
        $stmt->bind_param("ii", $searchLevel, $userId);
        
        $success = $stmt->execute();
        $error = $success ? null : $this->conn->error;
        
        $stmt->close();
        
        return [
            'success' => $success,
            'error' => $error
        ];
    }

    public function getUserSearchLevel($userId) {
        $stmt = $this->conn->prepare("SELECT searchLevel FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        
        $success = $stmt->execute();
        $result = $stmt->get_result();
        $level = null;
        
        if ($success && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $level = $row['searchLevel'];
        }
        
        $stmt->close();
        
        return [
            'success' => $success,
            'level' => $level,
            'error' => $success ? null : $this->conn->error
        ];
    }
}
?>
