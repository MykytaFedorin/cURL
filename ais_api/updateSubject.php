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
$id = $postData['id'] ?? null; // Предполагается, что в запросе также передается идентификатор предмета, который нужно обновить
$name = $postData['name'] ?? null;
$day = $postData['day'] ?? null;
$room = $postData['room'] ?? null;
$subjectType = $postData['subjectType'] ?? null;

// Проверка наличия всех необходимых данных
if (!$id || !$name || !$day || !$room || !$subjectType) {
    http_response_code(400);
    echo json_encode(array("message" => "Missing required data."));
    exit;
}

try {
    $stmt=$pdo->prepare("SELECT type_id FROM subject_type WHERE type_name=:subject_type");
    $stmt->bindValue(':subject_type', $subjectType, PDO::PARAM_STR);
    $stmt->execute();
    $type_id = $stmt->fetch(PDO::FETCH_ASSOC)['type_id'];
    // Подготовка SQL-запроса для обновления данных предмета
    $stmt = $pdo->prepare('UPDATE subjects SET name = :name, day = :day, room = :room, subject_type = :subjectType WHERE subject_id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':day', $day, PDO::PARAM_STR);
    $stmt->bindValue(':room', $room, PDO::PARAM_STR);
    $stmt->bindValue(':subjectType', $type_id, PDO::PARAM_INT); // Учитывается, что subject_type - это внешний ключ
    $stmt->execute();

    // Проверка успешности выполнения запроса
    if ($stmt->rowCount() > 0) {
        // Возврат сообщения об успешном обновлении данных предмета в формате JSON
        echo json_encode(array("message" => "Subject updated successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to update subject."));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Database error: " . $e->getMessage()));
}
?>

