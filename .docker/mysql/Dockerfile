FROM mysql:8.0

# Устанавливаем переменные окружения для задания пароля root при сборке образа
ENV MYSQL_ROOT_PASSWORD=root

# Копируем скрипт инициализации в директорию /docker-entrypoint-initdb.d/
# Этот скрипт будет выполнен при первом запуске контейнера для настройки базы данных
COPY init.sql /docker-entrypoint-initdb.d/

