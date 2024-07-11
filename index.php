<?php
require_once('data.php');
require_once('helpers.php');

// HTML-код главной страницы
$page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);

// окончательный HTML-код
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);
