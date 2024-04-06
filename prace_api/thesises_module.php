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
    function getThesisInfo($element, $xpath){
        $url_elements = $xpath->query("descendant::a", $element); 
        $url = "https://is.stuba.sk" . $url_elements->item(1)->getAttribute("href");
        $page = getPage($url);
        $xpath = getXPATH($page);

        $main_table = $xpath->query("//tbody")->item(0);
        $maint_items = $xpath->query("//tr", $main_table);
        $maint_values = array();
        foreach($maint_items as $row){
            $value = getRowValue($row, $xpath);
            array_push($maint_values, $value);
        }
        
        $thesis_type = $maint_values[0];
        $topic = $maint_values[1]; 
        $supervisor = $maint_values[4];
        $department = $maint_values[6];
        $abstract_ = $maint_values[10];
        $second_table = $xpath->query("//tbody")->item(1);
        $programme = $second_table->nodeValue;
        return new Thesis($thesis_type, $topic, $supervisor,
                          $department, $programme, $abstract_);
        
    }
    function getThesisObject($element, $xpath){
        return getThesisInfo($element, $xpath);
        
    }

    function getThesises($url){
        $page = getPage($url);
        $xpath = getXPATH($page);
        $thesisElements = getThesisElements($xpath, $page);
        $thesisObjects = array();
        foreach($thesisElements as $element){
            $thesis = getThesisObject($element, $xpath);
            $obj_assoc = array("thesis_type"=>$thesis->thesis_type,
                "topic" => $thesis->topic,
                "supervisor" => $thesis->supervisor,
                "department" => $thesis->department, 
                "abstract_" => $thesis->abstract_,
                "programme" => $thesis->programme
             );
            echo json_encode($obj_assoc);
            array_push($thesisObjects, $obj_assoc); 
        }
        return $thesisObjects;
    
    } 

    function filterThesises($thesises, $thesis_type, $department){
        $filtered_thesises = array(); 
        foreach($thesises as $thesis){
            if($thesis->thesis_type == $thesis_type && 
               $thesis->department == $department){
                array_push($filtered_thesises, $thesis); 
            } 
        }
        return $filtered_thesises;
    }
?>
