<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Schedule</title>
    <!-- Подключаем библиотеку jQuery -->
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src='./js/main.js'></script>
</body>
</html>

