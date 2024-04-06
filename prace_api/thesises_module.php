<?php
    require_once("../../../.config/zadanie2/config.global.php");
    require_once("../load_dotenv.php");
    require_once("Thesis.php");
    # require_once "../ais_api/download_schedule_.php";

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
    function getPage($url){     
        $token = getToken();
        $cookies = "UISAuth={$token};";
        $ch = curl_init();
        // Инициализация cURL-сессии
        // Установка параметров запроса для отправки POST запроса с логином и паролем
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);

        // Выполнение POST запроса для отправки логина и пароля
        $response = curl_exec($ch);

        // Проверка на наличие ошибок
        if($response === false) {
            echo 'Ошибка cURL: ' . curl_error($ch);
        } else {
            // Вывод содержимого страницы после отправки логина и пароля
            # echo $response_login_action;
            return $response;
        }

        // Закрытие cURL-сессии
        curl_close($ch);
    } 

    function getXPATH($page){ 
        $dom = new DOMDocument();

        // Загружаем HTML в объект DOMDocument, подавив ошибки парсинга
        @$dom->loadHTML($page);

        // Создаем объект DOMXPath
        return new DOMXPath($dom);
    }

    function getThesisElements($xpath){ 
        $query = "//tr[contains(@class, 'uis-hl-table') and contains(@class, 'lbn')]";
        $res = $xpath->query($query, $page);
        # echo $res->item(0)->nodeValue;
        return $res;
    }
    function getRowValue($row, $xpath){
        return $xpath->query("./td", $row)->item(1)->nodeValue; 
    }
    function getAbstractURL($element, $xpath){
        $url_elements = $xpath->query("descendant::a", $element); 
        $url = "https://is.stuba.sk" . $url_elements->item(1)->getAttribute("href");
        return $url;
    }
    function getDepartmentUrl($dep){
        $dict_ = array( 
          "Institute of Automotive Mechatronics (FEI)" => 642,
          "Institute of Power and Applied Electrical Engineering (FEI)" => 548, 
          "Institute of Electronics and Phototonics (FEI)" => 549,
          "Institute of Electrical Engineering (FEI)" => 550, 
          "Institute of Computer Science and Mathematics (FEI)" => 816,
          "Institute of Nuclear and Physical Engineering (FEI)" => 817,
          "Institute of Multimedia Information and Communication Technologies (FEI)" => 818,
          "Institute of Robotics and Cybernetics (FEI)" => 356
        );
        $url = "https://is.stuba.sk/auth/pracoviste/prehled_temat.pl?pracoviste=";
        return $url . $dict_[$dep] . ';';
    }
    function getThesisObject($element, $xpath){
        $cells = $xpath->query("./td", $element);
        $ord = $cells->item(1)->nodeValue;
        $type = $cells->item(1)->nodeValue;
        $topic = $cells->item(2)->nodeValue;
        $supervisor = $cells->item(3)->nodeValue;
        $department = $cells->item(4)->nodeValue;
        $programme = $cells->item(5)->nodeValue;
        $track = $cells->item(6)->nodeValue;
        $available = $cells->item(9)->nodeValue;
        $url = getAbstractURL($element, $xpath);

        return new Thesis($type, $topic, $supervisor,
                          $department, $programme, $track,
                          $url, $available);
    }

    function getThesises($url){
        $page = getPage($url);
        $xpath = getXPATH($page);
        $thesisElements = getThesisElements($xpath, $page);
        $thesisObjects = array();
        foreach($thesisElements as $element){
            $thesis = getThesisObject($element, $xpath);
            array_push($thesisObjects, $thesis); 
        }
        return $thesisObjects;
    
    } 

    function filterThesises($thesises, $thesis_type, $department){
        $filtered_thesises = array(); 
        foreach($thesises as $thesis){
          if($thesis->thesis_type === $thesis_type &&
            $thesis->department === $department &&
            $thesis->isFree()){
                array_push($filtered_thesises, $thesis); 
            } 
        }
        return $filtered_thesises;
    }
?>
