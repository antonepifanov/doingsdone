<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $project): ?>
                <li class="main-navigation__list-item <?php if (isset($_GET["project"]) && $_GET["project"] == $project["id"]): ?>main-navigation__list-item--active<?php endif; ?>">
                    <a class="main-navigation__list-item-link" href="/?project=<?=$project["id"];?>"><?=htmlspecialchars($project["name"]);?></a>
                    <span class="main-navigation__list-item-count"><?=get_tasks_count($all_tasks, $project["name"]);?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button"
    href="pages/form-project.html" target="project_add">Добавить проект</a>
</section>

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
                http_response_code(404);
                print("В данном проекте нет задач");
            };
        ?>
        <?php foreach ($tasks_by_category as $key => $task): ?>
            <?php if ($task["status"] && !$show_complete_tasks) continue; ?>
            <?= include_template("/task.php", ["key" => $key, "task" => $task]); ?>
        <?php endforeach; ?>
    </table>
</main>
