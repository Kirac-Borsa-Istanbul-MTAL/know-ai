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
}
?>
