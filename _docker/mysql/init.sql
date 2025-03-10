-- _docker/postgres/init.sql

CREATE DATABASE laravel;
CREATE USER admin WITH PASSWORD 'admin';
GRANT ALL PRIVILEGES ON DATABASE laravel TO admin;

-- Опционально, если вам нужен пользователь admin
-- CREATE USER admin WITH PASSWORD 'admin';
-- GRANT ALL PRIVILEGES ON DATABASE laravel TO admin;
