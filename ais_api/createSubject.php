<?php
header('Content-Type: application/json');

// Подключение к базе данных (предполагается, что $conn уже настроен на подключение)

// Получение данных из запроса JSON
$postData = json_decode(file_get_contents("php://input"), true);

// Извлечение значений из данных запроса
$name = $postData['name'];
$day = $postData['day'];
$room = $postData['room'];
$subjectType = $postData['subject_type'];

// Подготовка SQL-запроса с параметризованными значениями
$stmt = $conn->prepare('INSERT INTO subjects (name, day, room, subject_type) VALUES (:name, :day, :room, :subjectType)');
$stmt->bindParam(':name', $name);
$stmt->bindParam(':day', $day);
$stmt->bindParam(':room', $room);
$stmt->bindParam(':subjectType', $subjectType);
$stmt->execute();
// Возврат сообщения об успешном создании предмета в формате JSON
echo json_encode(array("message" => "Subject created successfully."));
?>

