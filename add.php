<?php
require_once("init.php");
require_once("helpers.php");

if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

$projects = [];
$tasks = [];

// Получение списка категорий
$projects_sql = "SELECT id, name FROM projects WHERE user_id = " . $_SESSION['user']['id'] . "";
$projects_result = mysqli_query($connection, $projects_sql);

if ($projects_result) {
    $projects = mysqli_fetch_all($projects_result, MYSQLI_ASSOC);
    $projects_ids = array_column($projects, 'id');
}

// Получение списка всех задач
$all_tasks_sql = "SELECT t.name AS task, t.date_term AS task_date, t.status, p.name AS category FROM tasks t JOIN projects p ON p.id = t.project_id  WHERE t.user_id = " . $_SESSION['user']['id'] . "";

$all_tasks_result = mysqli_query($connection, $all_tasks_sql);

if ($all_tasks_result) {
    $all_tasks = mysqli_fetch_all($all_tasks_result, MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['name', 'project'];
	$errors = [];

    $rules = [
        'project' => function($value) use ($projects_ids) {
            return validate_project($value, $projects_ids);
        },
        'date' => function($value) {
            if (!is_date_valid($value)) {
                return "Дата должна быть больше или равна текущей";
            };

            return null;
        }
    ];

    $task = filter_input_array(INPUT_POST, ['name' => FILTER_DEFAULT, 'project' => FILTER_DEFAULT, 'date' => FILTER_DEFAULT], true);

    foreach ($task as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Поле $key надо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (!empty($_FILES['file']['name'])) {
		$file_name = $_FILES['file']['name'];
        $file_path = __DIR__ . '/uploads/';
        move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
        $task['file'] = '/uploads/' . $file_name;
	}

    if (count($errors)) {
		$page_content = include_template('form-task.php', [
            'task' => $task,
            'errors' => $errors,
            'projects' => $projects,
            'all_tasks' => $all_tasks,
        ]);
	} else {
        $form_task_sql = 'INSERT INTO tasks (date_add, user_id, name, project_id, date_term, file) VALUES (NOW(), 1, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($connection, $form_task_sql, $task);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: /");
        }
	}
} else {
	$page_content = include_template("form-task.php", [
        "projects" => $projects,
        "all_tasks" => $all_tasks,
    ]);
}

// окончательный HTML-код
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Дела в порядке",
    "is_anonymous" => false
]);

print($layout_content);
