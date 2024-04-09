<?php

function insert($table, $column_values) {
    global $pdo; // Предположим, что у вас есть соединение с базой данных в переменной $pdo
    $columns = implode(', ', array_keys($column_values));
    $placeholders = implode(', ', array_fill(0, count($column_values), '?'));
    $values = array_values($column_values);
    $stmt = $pdo->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
    $stmt->execute($values);
    $pdo->commit();
}

function fetchAll($table, $columns) {
    global $pdo; // Предположим, что у вас есть соединение с базой данных в переменной $pdo
    $columnsJoined = implode(', ', $columns);
    $stmt = $pdo->prepare("SELECT $columnsJoined FROM $table");
    $stmt->execute();
    $result = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}

function delete($table, $row_id) {
    global $pdo; // Предположим, что у вас есть соединение с базой данных в переменной $pdo
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$row_id]);
    $pdo->commit();
}


?>
