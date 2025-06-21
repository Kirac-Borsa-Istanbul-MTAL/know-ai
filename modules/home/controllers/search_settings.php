<?php
require_once __DIR__ . '/../models/search.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchLevel = $_POST['searchLevel'] ?? 1;
    $userId = $_SESSION['user_id'] ?? null;

    $searchModel = new SearchModel();
    
    setcookie('searchLevel', $searchLevel, time() + (30 * 24 * 60 * 60), '/');
    
    if ($userId) {
        $result = $searchModel->updateUserSearchLevel($userId, $searchLevel);
        
        if ($result['success']) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode([
                'success' => false, 
                'error' => 'Database error' . ($result['error'] ? ': ' . $result['error'] : '')
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
    }
    exit();
}
?>
