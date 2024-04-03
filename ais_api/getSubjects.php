<?php
header('Content-Type: application/json');

$stmt = $pdo->query('SELECT sb.subject_id, sb.name, sb.day, sb.room, st.type_name as subject_type
                     FROM subjects AS sb 
                     LEFT JOIN subject_type AS st 
                     ON sb.subject_type=st.type_id');
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(array("subjects" => $subjects));
?>

