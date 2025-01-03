<?php
require_once("init.php");
require_once("helpers.php");

if (!isset($_SESSION['user'])) {
    $page_content = include_template("guest.php", []);

    // окончательный HTML-код
    $layout_content = include_template("layout.php", [
        "content" => $page_content,
        "title" => "Дела в порядке",
        "is_anonymous" => true
    ]);
    print($layout_content);
    exit();
}

$projects = [];
$tasks = [];

// Получение списка категорий
$projects_sql = "SELECT id, name FROM projects WHERE user_id = " . $_SESSION['user']['id'] . "";
$projects_result = mysqli_query($connection, $projects_sql);

if ($projects_result) {
    $projects = mysqli_fetch_all($projects_result, MYSQLI_ASSOC);
}

// Получение списка всех задач
$all_tasks_sql = "SELECT t.name AS task, t.date_term AS task_date, t.file, t.status, p.name AS category FROM tasks t JOIN projects p ON p.id = t.project_id  WHERE t.user_id = " . $_SESSION['user']['id'] . " ORDER BY t.date_term DESC";

$all_tasks_result = mysqli_query($connection, $all_tasks_sql);

if ($all_tasks_result) {
    $all_tasks = mysqli_fetch_all($all_tasks_result, MYSQLI_ASSOC);
}
// Получение списка задач в зависимости от категории
$project = filter_input(INPUT_GET, "project");

if (isset($_GET["project"]) && !empty($_GET["project"])) {
    $tasks_by_category_sql ="SELECT t.name AS task, t.date_term AS task_date, t.file, t.status, p.name AS category FROM tasks t JOIN projects p ON p.id = t.project_id WHERE t.user_id = " . $_SESSION['user']['id'] . " AND p.id = " . $_GET["project"] . " ORDER BY t.date_term DESC";
    $tasks_by_category_result = mysqli_query($connection, $tasks_by_category_sql);

    if ($tasks_by_category_result) {
        $tasks_by_category = mysqli_fetch_all($tasks_by_category_result, MYSQLI_ASSOC);
    }
} else {
    $tasks_by_category = $all_tasks;
}

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
    "title" => "Дела в порядке",
    "is_anonymous" => false
]);

print($layout_content);
