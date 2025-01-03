<?php
require_once("helpers.php");
session_start();

date_default_timezone_set("Europe/Moscow");

// Подключение к базе данных
$connection = mysqli_connect("127.0.0.1", "root", "", "doingsdone");
mysqli_set_charset($connection, "utf8");

if ($connection == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
    exit();
}
