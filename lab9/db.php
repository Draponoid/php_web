<?php
// ЛР В-1: Подключение к БД (настройте под свой хостинг)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'phonebook');

function getDB(): mysqli {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_errno) {
        die('<p style="color:red;">Ошибка подключения к БД: ' . $db->connect_error . '</p>');
    }
    $db->set_charset('utf8mb4');
    return $db;
}

/*
CREATE DATABASE IF NOT EXISTS phonebook CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE phonebook;

CREATE TABLE IF NOT EXISTS contacts (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    lastname  VARCHAR(100) NOT NULL DEFAULT '',
    firstname VARCHAR(100) NOT NULL DEFAULT '',
    patronym  VARCHAR(100) NOT NULL DEFAULT '',
    gender    ENUM('М','Ж') DEFAULT 'М',
    birthdate DATE,
    phone     VARCHAR(30),
    address   TEXT,
    email     VARCHAR(150),
    comment   TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/
