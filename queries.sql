# Добавление данных в таблицу users
INSERT INTO users (email, name, password)
  VALUES ("qwe@we.jj", "Антон", "123"), ("qw@we.jj", "Алёна", "123");

# Добавление данных в таблицу projects
INSERT INTO projects (name, user_id)
  VALUES ("Входящие", 1), ("Учеба", 1), ("Работа", 1), ("Домашние дела", 1), ("Авто", 1);

# Добавление данных в таблицу tasks
INSERT INTO tasks (name, date_term, user_id, project_id, status)
  VALUES
    ("Собеседование в IT компании", "2024-08-21", 1, 3, 0),
    ("Выполнить тестовое задание", "2024-08-21", 1, 3, 0),
    ("Сделать задание первого раздела", "2024-07-11", 1, 2, 1),
    ("Встреча с другом", "2024-08-05", 1, 1, 0),
    ("Купить корм для кота", NULL, 1, 4, 0),
    ("Заказать пиццу", NULL, 1, 4, 0);

# Получение списка проектов для пользователя
SELECT name FROM projects WHERE user_id = 1;

# Получение списка задач для одного проекта
SELECT name FROM tasks WHERE project_id = 1;

# Отметка о выполнении задачи
UPDATE tasks SET status = 1 WHERE id = 1;

# Обновление названия задачи
UPDATE tasks SET name = "Встреча с друзьями" WHERE id = 4;
