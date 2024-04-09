FROM mysql:8.0

# Копируем скрипт инициализации в директорию /docker-entrypoint-initdb.d/
# Этот скрипт будет выполнен при первом запуске контейнера для настройки базы данных
COPY ./init.sql /docker-entrypoint-initdb.d/

