<?php
require_once("helpers.php");
date_default_timezone_set("Europe/Moscow");

// Подключение к базе данных
$connection = mysqli_connect("127.0.0.1", "root", "", "doingsdone");
mysqli_set_charset($connection, "utf8");

$projects = [];
$tasks = [];
if ($connection == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    // Получение списка категорий
    $projects_sql = "SELECT id, name FROM projects WHERE user_id = 1";
    $projects_result = mysqli_query($connection, $projects_sql);

    if ($projects_result) {
        $projects = mysqli_fetch_all($projects_result, MYSQLI_ASSOC);
    }

    // Получение списка всех задач
    $all_tasks_sql = "SELECT t.name AS task, t.date_term AS task_date, t.file, t.status, p.name AS category FROM tasks t JOIN projects p ON p.id = t.project_id  WHERE t.user_id = 1 ORDER BY t.date_term DESC";

    $all_tasks_result = mysqli_query($connection, $all_tasks_sql);

    if ($all_tasks_result) {
        $all_tasks = mysqli_fetch_all($all_tasks_result, MYSQLI_ASSOC);
    }
    // Получение списка задач в зависимости от категории
    $project = filter_input(INPUT_GET, "project");

    if (isset($_GET["project"]) && !empty($_GET["project"])) {
        $tasks_by_category_sql ="SELECT t.name AS task, t.date_term AS task_date, t.file, t.status, p.name AS category FROM tasks t JOIN projects p ON p.id = t.project_id WHERE t.user_id = 1 AND p.id = " . $_GET["project"] . " ORDER BY t.date_term DESC";
        $tasks_by_category_result = mysqli_query($connection, $tasks_by_category_sql);

        if ($tasks_by_category_result) {
            $tasks_by_category = mysqli_fetch_all($tasks_by_category_result, MYSQLI_ASSOC);
        }
    } else {
        $tasks_by_category = $all_tasks;
    }
};

// HTML-код главной страницы
$page_content = include_template("main.php", [
    "projects" => $projects,
    "all_tasks" => $all_tasks,
    "tasks_by_category" => $tasks_by_category,
    "show_complete_tasks" => $show_complete_tasks
]);

// окончательный HTML-код
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Дела в порядке"
]);

print($layout_content);
