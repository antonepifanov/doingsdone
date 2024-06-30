<?php
    // массив проектов
    $projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

    // массив задач
    $tasks = [
        [
            "task" => "Собеседование в IT компании",
            "task_date" => "01.12.2019",
            "category" => "Работа",
            "is_complete" => false
        ],
        [
            "task" => "Выполнить тестовое задание",
            "task_date" => "25.12.2019",
            "category" => "Работа",
            "is_complete" => false
        ],
        [
            "task" => "Сделать задание первого раздела",
            "task_date" => "21.12.2019",
            "category" => "Учеба",
            "is_complete" => true
        ],
        [
            "task" => "Встреча с другом",
            "task_date" => "22.12.2019",
            "category" => "Входящие",
            "is_complete" => false
        ],
        [
            "task" => "Купить корм для кота",
            "task_date" => null,
            "category" => "Домашние дела",
            "is_complete" => false
        ],
        [
            "task" => "Заказать пиццу",
            "task_date" => null,
            "category" => "Домашние дела",
            "is_complete" => false
        ],
    ];

    // показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);

    require_once('helpers.php');

    // HTML-код главной страницы
    $page_content = include_template('/main.php', ['projects' => $projects, 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);

    // окончательный HTML-код
    $layout_content = include_template('/layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);

    print($layout_content);
