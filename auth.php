<?php
require_once("init.php");
require_once("helpers.php");

$register_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['email', 'password'];
	$errors = [];

    $rules = [
        'email' => function($value) {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return "E-mail введён некорректно";
            };
            return null;
        }
    ];

    $auth_fields = filter_input_array(INPUT_POST, ['email' => FILTER_DEFAULT, 'password' => FILTER_DEFAULT], true);

    foreach ($auth_fields as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Это поле надо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (empty($errors)) {
        $email = mysqli_real_escape_string($connection, $auth_fields['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($connection, $sql);

        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        if ($user && empty($errors)) {
            if (password_verify($auth_fields['password'], $user['password'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        } else {
            $errors['email'] = 'Такой пользователь не найден';
        }
	}

    if (count($errors)) {
		$page_content = include_template('auth.php', ['errors' => $errors]);
	} else {
		header("Location: /");
		exit();
	}
} else {
    $page_content = include_template('auth.php', []);

    if (isset($_SESSION['user'])) {
        header("Location: /");
        exit();
    }
}

// окончательный HTML-код
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "title" => "Дела в порядке | Вход на сайт",
    "is_anonymous" => false
]);

print($layout_content);
