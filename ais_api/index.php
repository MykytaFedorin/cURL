<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Schedule</title>
    <!-- Подключаем библиотеку jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h2>Download Schedule</h2>
    <!-- Создаем кнопку для вызова скрипта download_schedule.php -->
    <button id="downloadBtn">Download Schedule</button>
    <button id="deleteBtn">Delete Schedule</button>

    <!-- Создаем блок для отображения результата загрузки расписания -->
    <div id="scheduleResult">
        <p id="resultText"></p> <!-- Тег для вывода полученного текста -->
    </div>

    <script>
        // При нажатии на кнопку с id="downloadBtn"
        $('#downloadBtn').click(function() {
            // Выполняем AJAX-запрос к скрипту download_schedule.php
            $.ajax({
                url: 'download_schedule.php', // URL-адрес вашего скрипта
                type: 'GET', // Метод запроса
                dataType: 'text', // Тип данных, который ожидается в ответе
                success: function(response) {
                    // Обновляем содержимое тега с id="resultText" полученным текстом
                    $('#resultText').text(response);
                },
                error: function(xhr, status, error) {
                    // Обработка ошибки
                    console.error(error); // Выводим сообщение об ошибке в консоль
                }
            });
        });
        $('#deleteBtn').click(function() {
            // Выполняем AJAX-запрос к скрипту download_schedule.php
            $.ajax({
                url: 'delete_schedule.php', // URL-адрес вашего скрипта
                type: 'GET', // Метод запроса
                dataType: 'text', // Тип данных, который ожидается в ответе
                success: function(response) {
                    // Обновляем содержимое тега с id="resultText" полученным текстом
                    $('#resultText').text(response);
                },
                error: function(xhr, status, error) {
                    // Обработка ошибки
                    console.error(error); // Выводим сообщение об ошибке в консоль
                }
            });
        });
    </script>
</body>
</html>

