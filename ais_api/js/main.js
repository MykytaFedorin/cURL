$(document).ready(function() {
    $('#myTable').DataTable();
});
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
