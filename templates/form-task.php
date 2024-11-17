<?php require('projects.php'); ?>

<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form"  action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <?php $classname = isset($errors['name']) ? "form__input--error" : ""; ?>

            <input class="form__input <?= $classname; ?>" type="text" name="name" id="name" value="<?= get_post_val('name'); ?>" placeholder="Введите название">
            <p class="form__message"><?= $errors['name'] ?? ""; ?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <?php $classname = isset($errors['project']) ? "form__input--error" : ""; ?>

            <select class="form__input form__input--select <?= $classname; ?>" name="project" id="project">
                <option>Выбрать</option>
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id'] ?>" <?php if ($project['id'] == get_post_val('project')): ?>selected<?php endif; ?>>
                        <?=$project["name"];?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="form__message"><?= $errors['project'] ?? ""; ?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <?php $classname = isset($errors['date']) ? "form__input--error" : ""; ?>

            <input class="form__input form__input--date <?= $classname; ?>" type="text" name="date" id="date" value="<?= get_post_val('date'); ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <p class="form__message"><?= $errors['date'] ?? ""; ?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file" id="file" value="<?= get_post_val('file'); ?>">

                <label class="button button--transparent" for="file">
                    <span>Выберите файл</span>
                </label>
            </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
