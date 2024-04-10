<?php
header('Content-Type: application/json');

// Проверка наличия данных в запросе JSON
$postData = json_decode(file_get_contents("php://input"), true);
if (!$postData) {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid JSON data provided."));
    exit;
}

// Извлечение значений из данных запроса
$name = $postData['name'] ?? null;
$day = $postData['day'] ?? null;
$room = $postData['room'] ?? null;
$subjectType = $postData['subjectType'] ?? null;

// Проверка наличия всех необходимых данных
if (!$name || !$day || !$room || !$subjectType) {
    http_response_code(400);
    echo json_encode(array("message" => "Missing required data."));
    exit;
}

try {
    $stmt=$pdo->prepare("SELECT type_id FROM subject_type WHERE type_name=:subject_type");
    $stmt->bindValue(':subject_type', $subjectType, PDO::PARAM_STR);
    $stmt->execute();
    $type_id = $stmt->fetch(PDO::FETCH_ASSOC)['type_id'];
    // Подготовка SQL-запроса с параметризованными значениями
    $stmt = $pdo->prepare('INSERT INTO subjects (name, day, room, subject_type) VALUES (:name, :day, :room, :subjectType)');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':day', $day, PDO::PARAM_STR);
    $stmt->bindValue(':room', $room, PDO::PARAM_STR);
    $stmt->bindValue(':subjectType', $type_id, PDO::PARAM_STR);
    $stmt->execute();

    // Проверка успешности выполнения запроса
    if ($stmt->rowCount() > 0) {
        // Возврат сообщения об успешном создании предмета в формате JSON
        echo json_encode(array("message" => "Subject created successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to create subject."));
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Database error: " . $e->getMessage()));
}
?>

