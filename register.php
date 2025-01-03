<?php
require_once("init.php");
require_once("helpers.php");

$register_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['email', 'password', 'name'];
	$errors = [];

    $rules = [
        'email' => function($value) {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return "E-mail введён некорректно";
            };
            return null;
        }
    ];

    $register_fields = filter_input_array(INPUT_POST, ['name' => FILTER_DEFAULT, 'email' => FILTER_DEFAULT, 'password' => FILTER_DEFAULT], true);

    foreach ($register_fields as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Поле $key надо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (empty($errors)) {
        $email = mysqli_real_escape_string($connection, $register_fields['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($connection, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
		else {
            $password = password_hash($register_fields['password'], PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (date_reg, email, name, password) VALUES (NOW(), ?, ?, ?)';
            $stmt = db_get_prepare_stmt($connection, $sql, [$register_fields['email'], $register_fields['name'], $password]);
            $res = mysqli_stmt_execute($stmt);
        }

        if ($res && empty($errors)) {
            header("Location: /");
            exit();
        }
	}

    $register_data['errors'] = $errors;
}

if (!isset($_SESSION['user'])) {
    $page_content = include_template("register.php", $register_data);
} else {
    header("Location: /");
    exit();
}

// окончательный HTML-код
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Дела в порядке | Регистрация",
    "is_anonymous" => false
]);

print($layout_content);
