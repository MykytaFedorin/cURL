<?php
require_once "../../../.config/zadanie2/config.global.php";
function getToken(){    
    $username = $_ENV["USERNAME"];
    $password = $_ENV["PASSWORD"];
    $url_login_page = 'https://is.stuba.sk/auth/';
    $ch = curl_init();
    $postData = array(
        'lang' => 'en',
        'login_hidden' => '1',
        'destination' => '/auth/?lang=en',
        'auth_id_hidden' => '0',
        'auth_2fa_type' => 'no',
        'credential_0' => $username,
        'credential_1' => $password,
        'credential_k' => '',
        'credential_2' => '86400'
    );
    curl_setopt($ch, CURLOPT_URL, $url_login_page);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // Выполнение запроса для получения страницы входа
    $response_login_page = curl_exec($ch);

    // Проверка на наличие ошибок
    if($response_login_page === false) {
        echo 'Ошибка cURL: ' . curl_error($ch);
        exit;
    }
    else{
        $pattern = '/UISAuth=([^;]+)/';

        // Ищем совпадения в заголовках
        if (preg_match($pattern, $response_login_page, $matches)) {
            // Значение UISAuth будет в $matches[1]
            $uisAuth = $matches[1];
            return $uisAuth;
        } else {
            echo 'UISAuth не найден в заголовках.';
        }
    }
}
function getSchedule(){
    $token = getToken();
    $cookies = "UISAuth={$token};";
    $url_login_action = 'https://is.stuba.sk/auth/katalog/rozvrhy_view.pl?rozvrh_student_obec=1?zobraz=1;format=html;rozvrh_student=111223;zpet=../student/moje_studium.pl?_m=3110,lang=en,studium=163086,obdobi=630;lang=en';
    $ch = curl_init();
    // Инициализация cURL-сессии
    // Установка параметров запроса для отправки POST запроса с логином и паролем
    curl_setopt($ch, CURLOPT_URL, $url_login_action);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIE, $cookies);

    // Выполнение POST запроса для отправки логина и пароля
    $response_login_action = curl_exec($ch);

    // Проверка на наличие ошибок
    if($response_login_action === false) {
        echo 'Ошибка cURL: ' . curl_error($ch);
    } else {
        // Вывод содержимого страницы после отправки логина и пароля
        # echo $response_login_action;
        return $response_login_action;
    }

    // Закрытие cURL-сессии
    curl_close($ch);
}
function getSubjectObj($subject, $xpath){
        $day = findDayOfSubject($subject, $xpath);
        $class = $subject->getAttribute("class");
        if($class == 'rozvrh-pred'){
            $subject_type = 'prednaška';
        }else{
            $subject_type = 'cvičenie' ;
        }
        $general_info = parseSubject($subject, $xpath);
        if($general_info->item(0)){
            $room = $general_info->item(0)->nodeValue;
            $name = $general_info->item(1)->nodeValue;
            return new Subject($day, $subject_type, $name, $room);
        }
        return null;
}
function parseSchedule($scheduleHTML){
    $dom = new DOMDocument();

    // Загружаем HTML в объект DOMDocument, подавив ошибки парсинга
    @$dom->loadHTML($scheduleHTML);

    // Создаем объект DOMXPath
    $xpath = new DOMXPath($dom);

    // Используем XPath для поиска всех тегов <td> с классом "rozvrh-pred" или "rozvrh-cvic"
    $query = "//td[contains(concat(' ', normalize-space(@class), ' '), ' rozvrh-pred ') or contains(concat(' ', normalize-space(@class), ' '), ' rozvrh-cvic ')]";

    // Выполняем запрос XPath
    $subjects = $xpath->query($query);
    // Выводим HTML найденных тегов <td>
    $sub_objects = array();
    foreach($subjects as $subject) {
        if($subject){ 
            array_push($sub_objects, getSubjectObj($subject, $xpath));
        }
    }  
    return $sub_objects;
}
function findDayOfSubject($tdNode, $xpath){
    $siblingNode = $xpath->query("preceding-sibling::td[@class='zahlavi']", $tdNode)->item(0);
    
    // Проверяем, найден ли соседний тег
    if ($siblingNode !== null) {
        return $siblingNode->nodeValue . "\n"; // Выводим содержимое найденного тега
    }
}
function parseSubject($subject, $xpath){
   $info = $xpath->query("descendant::a", $subject);
   return $info;
}
function records_exist(){
    global $pdo;
    try {
        // Подготовка запроса
        $query = $pdo->prepare("SELECT COUNT(*) as count FROM subjects");
        
        // Выполнение запроса
        $query->execute();
        
        // Извлечение результата
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        // Получение количества записей
        $count = $row['count'];
        
        // Проверка, есть ли хотя бы одна запись
        return $count > 0;
    } catch (PDOException $e) {
        // Обработка ошибки
        echo "Ошибка выполнения запроса: " . $e->getMessage();
        return false; // В случае ошибки возвращаем false
    }
}
?>
