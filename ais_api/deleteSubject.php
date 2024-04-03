<?php
header('Content-Type: application/json');

// Проверка наличия данных в запросе JSON
$postData = json_decode(file_get_contents("php://input"), true);
if (!$postData) {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid JSON data provided."));
    exit;
}

$id = $postData["id"];
try {
    $stmt = $pdo->prepare('DELETE FROM subjects WHERE subject_id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Проверка успешности выполнения запроса
    if ($stmt->rowCount() > 0) {
        // Возврат сообщения об успешном обновлении данных предмета в формате JSON
        echo json_encode(array("message" => "Subject deleted successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to delete subject."));
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Database error: " . $e->getMessage()));
}
?>

