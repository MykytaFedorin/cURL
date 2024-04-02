<?php
require_once "../load_dotenv.php";
// URL для получения страницы входа
require_once "./download_schedule_.php";
// URL для отправки POST запроса с логином и паролем
require_once "Subject.php";
// Логин и пароль для авторизации
if(!records_exist()){
    $scheduleHTML = getSchedule();
    $subjects = parseSchedule($scheduleHTML);
    foreach($subjects as $subject){
        if($subject){
            $subject->commit();
        }
    }
    echo "success";
}
else{
    echo "table already exist";
}
?>

