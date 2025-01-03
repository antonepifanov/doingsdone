<?php require('projects.php'); ?>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post" autocomplete="off">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <label class="checkbox">
            <input
                class="checkbox__input visually-hidden show_completed"
                type="checkbox"
                <?php if ($show_complete_tasks): ?>checked<?php endif; ?>
            >
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <?php
            if (!count($tasks_by_category)) {
                print("В данном проекте нет задач");
            };
        ?>
        <?php foreach ($tasks_by_category as $key => $task): ?>
            <?php if ($task["status"] && !$show_complete_tasks) continue; ?>
            <?= include_template("/task.php", ["key" => $key, "task" => $task]); ?>
        <?php endforeach; ?>
    </table>
</main>
