<tr class="tasks__item task <?php if ($task["status"]): ?>task--completed<?php endif; ?> <?php if (isset($task["task_date"]) && !$task["status"] && is_important_task($task["task_date"])): ?>task--important<?php endif; ?>">
    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=$key + 1;?>">
            <span class="checkbox__text"><?=htmlspecialchars($task["task"]);?></span>
        </label>
    </td>


    <td class="task__file">
        <?php if (isset($task["file"])): ?>
            <a class="download-link" href="<?=htmlspecialchars($task["file"]);?>" target="_blank"><?=htmlspecialchars($task["file"]);?></a>
        <?php endif; ?>
    </td>


    <td class="task__date">
        <?php if (isset($task["task_date"])): ?>
            <?=htmlspecialchars($task["task_date"]);?>
        <?php endif; ?>
    </td>
</tr>
