<?php
require_once('helpers.php');
date_default_timezone_set('Europe/Moscow');

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
    $projects_sql = "SELECT name FROM projects WHERE user_id = 1";
    $projects_result = mysqli_query($connection, $projects_sql);

    if ($projects_result) {
        while ($project = mysqli_fetch_assoc($projects_result)) {
            $projects[] = $project['name'];
        }
    }

    // Получение списка задач
    $tasks_sql = "SELECT t.name AS task, t.date_term AS task_date, t.status, p.name AS category FROM tasks t JOIN projects p ON p.id = t.project_id  WHERE t.user_id = 1";
    $tasks_result = mysqli_query($connection, $tasks_sql);

    $tasks = mysqli_fetch_all($tasks_result, MYSQLI_ASSOC);
};

// HTML-код главной страницы
$page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);

// окончательный HTML-код
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);
