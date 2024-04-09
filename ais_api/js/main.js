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
$(document).ready(function() {
    // Функция для загрузки данных и отображения их в таблице
    function fetchSubjects() {
        $.ajax({
            url: '/ais_api/subjects',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const subjects = data.subjects;
                const tableBody = $('#subjectTableBody');
                tableBody.empty(); // Очищаем содержимое тела таблицы перед добавлением новых данных

                $.each(subjects, function(index, subject) {
                    const row = $('<tr>');
                    row.append($('<td>').text(subject.subject_id));
                    row.append($('<td>').text(subject.name));
                    row.append($('<td>').text(subject.day));
                    row.append($('<td>').text(subject.room));
                    row.append($('<td>').text(subject.subject_type));
                    tableBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching subjects:', error);
            }
        });
    }
    $(document).ready(function() {
$('#subjectTable').on('click', 'td', function() {
        var $td = $(this);
        var text = $td.text().trim();
        var $input = $("<input class='w-100' type='text'>").val(text);
        $td.empty().append($input);
        
        $input.focus();
        
        $input.blur(function() {
            var newText = $(this).val();
            $td.text(newText);
        });
        
        $input.keydown(function(event) {
            if (event.which == 13) { // Enter key
                var newText = $(this).val();
                $td.text(newText);
            }
        });
        event.stopPropagation();
    });
});

    // Загружаем данные при загрузке страницы
    fetchSubjects();

    // Обработчик события для кнопки "Refresh"
    $('#refreshButton').click(function() {
        fetchSubjects();
    });
});
