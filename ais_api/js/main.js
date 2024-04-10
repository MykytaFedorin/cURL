$(document).ready(function () {
    $("#myTable").DataTable();
});
$("#downloadBtn").click(function () {
    // Выполняем AJAX-запрос к скрипту download_schedule.php
    $.ajax({
        url: "download_schedule.php", // URL-адрес вашего скрипта
        type: "GET", // Метод запроса
        dataType: "text", // Тип данных, который ожидается в ответе
        success: function (response) {
            // Обновляем содержимое тега с id="resultText" полученным текстом
            $("#resultText").text(response);
            setTimeout(function () {
                $("#resultText").text("");
                fetchSubjects();
            }, 1000);
        },
        error: function (xhr, status, error) {
            // Обработка ошибки
            console.error(error); // Выводим сообщение об ошибке в консоль
        },
    });
});
$("#deleteBtn").click(function () {
    // Выполняем AJAX-запрос к скрипту download_schedule.php
    $.ajax({
        url: "delete_schedule.php", // URL-адрес вашего скрипта
        type: "GET", // Метод запроса
        dataType: "text", // Тип данных, который ожидается в ответе
        success: function (response) {
            // Обновляем содержимое тега с id="resultText" полученным текстом
            $("#resultText").text(response);
            setTimeout(function () {
                $("#resultText").text("");
                fetchSubjects();
            }, 1000);
        },
        error: function (xhr, status, error) {
            // Обработка ошибки
            console.error(error); // Выводим сообщение об ошибке в консоль
        },
    });
});
function fetchSubjects() {
    $.ajax({
        url: "/ais_api/subjects",
        type: "GET",
        dataType: "json",
        success: function (data) {
            const subjects = data.subjects;
            const tableBody = $("#subjectTableBody");
            tableBody.empty(); // Очищаем содержимое тела таблицы перед добавлением новых данных

            $.each(subjects, function (index, subject) {
                const row = $("<tr>");
                row.append($("<td id='subjectId'>").text(subject.subject_id));
                row.append($("<td id='subjectName'>").text(subject.name));
                row.append($("<td id='subjectDay'>").text(subject.day));
                row.append($("<td id='subjectRoom'>").text(subject.room));
                row.append(
                    $("<td id='subjectType'>").text(subject.subject_type)
                );
                row.append($("<td class='hiddenCell'></td>").text("X"));
                tableBody.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching subjects:", error);
        },
    });
}
$(document).ready(function () {
    // Функция для загрузки данных и отображения их в таблице

    // Загружаем данные при загрузке страницы
    fetchSubjects();
    // Обработчик события для кнопки "Refresh"
});
function changeColor($tr, color) {
    $tr.addClass(color);

    // Удаляем класс через 1 секунду
    setTimeout(function () {
        $tr.removeClass(color);
        fetchSubjects();
    }, 1000);
}
$(document).ready(function () {
    $("#createRecordBtn").on("click", function () {
        // Создаем новую строку таблицы
        var newRow = $("<tr>");

        // Добавляем ячейки в новую строку (пустые для начала)
        newRow.append("<td id='subjectId'></td>");
        newRow.append("<td id='subjectName'></td>");
        newRow.append("<td id='subjectDay'></td>");
        newRow.append("<td id='subjectRoom'></td>");
        newRow.append("<td id='subjectType'></td>");
        newRow.append("<td class='hiddenCell'>X</td>");

        // Вставляем новую строку в таблицу #subjectTable
        $("#subjectTable").append(newRow);
    });
});
$(document).ready(function () {
    $("#subjectTable").on("click", "td.hiddenCell", function () {
        var $td = $(this);
        var $tr = $td.closest("tr");
        var id = $tr.find("td:eq(0)").text().trim();
        var requestPayload = { id: id };
        $.ajax({
            url: "subjects",
            type: "DELETE",
            contentType: "application/json",
            data: JSON.stringify(requestPayload),
            success: function (response) {
                console.log(response);
                fetchSubjects();
            },
            error: function (xhr, status, error) {
                console.error("Error occured while updating data:", error);
            },
        });
    });
});
$(document).ready(function () {
    $("#subjectTable").on("click", "td:not([class='hiddenCell'])", function () {
        var $td = $(this);
        var tdId = $td.attr("id");
        var tdClass = $td.attr("class");
        if (tdClass === "hiddenCell") {
        }
        if (tdId === "subjectId" || tdId === "subjectType") {
            var $tr = $td.closest("tr");
            // Добавляем класс, чтобы изменить цвет текста на красный
            changeColor($tr, "red-text");
        } else {
            var text = $td.text().trim();
            var $input = $("<input class='w-100' type='text'>").val(text);
            $td.empty().append($input);

            $input.focus();

            $input.blur(function () {
                var newText = $(this).val();
                $td.text(newText);
            });

            $input.keydown(function (event) {
                if (event.which == 13) {
                    // Enter key
                    var newText = $(this).val();
                    $td.text(newText);
                }
            });

            event.stopPropagation();
        }
    });

    // Добавляем обработчик для строк с классами .subjectId и .subjectType
});
$(document).ready(function () {
    $("#subjectTable").on("focusout keydown", "input", function (event) {
        if (
            event.type === "focusout" ||
            (event.type === "keydown" && event.keyCode === 13)
        ) {
            var $input = $(this);
            var newText = $input.val().trim();
            var $td = $input.closest("td");
            $td.text(newText); // Возвращаем текст в ячейку

            var $tr = $td.closest("tr");
            var id = $tr.find("td:eq(0)").text().trim();
            var rowData = {
                name: $tr.find("td:eq(1)").text().trim(),
                day: $tr.find("td:eq(2)").text().trim(),
                room: $tr.find("td:eq(3)").text().trim(),
                subjectType: "cvičenie",
                /* subjectType: $tr.find("td:eq(4)").text().trim(),*/
            };
            if (id === "") {
                $.ajax({
                    url: "subjects",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(rowData),
                    success: function (response) {
                        console.log(response);
                        changeColor($tr, "green-text");
                    },
                    error: function (xhr, status, error) {
                        console.error(
                            "Error occured while updating data:",
                            error
                        );
                    },
                });
            } else {
                // Отправить строку данных в виде JSON на сервер
                rowData["id"] = id;
                $.ajax({
                    url: "subjects",
                    type: "PUT",
                    contentType: "application/json",
                    data: JSON.stringify(rowData),
                    success: function (response) {
                        console.log(response);
                        changeColor($tr, "green-text");
                    },
                    error: function (xhr, status, error) {
                        console.error(
                            "Error occured while updating data:",
                            error
                        );
                    },
                });
            }
        }
    });
});
