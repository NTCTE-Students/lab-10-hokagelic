<?php
// Класс исключения для регистрации
class RegistrationException extends Exception {
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

// Функция для очистки данных от нежелательных символов
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Переменные для хранения данных формы и ошибок
$name = $email = $password = '';
$nameErr = $emailErr = $passwordErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Проверка имени
        if (empty($_POST['name'])) {
            throw new RegistrationException('Имя обязательно');
        } else {
            $name = test_input($_POST['name']);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                throw new RegistrationException('Имя должно содержать только буквы, пробелы, апострофы и тире');
            }
        }

        // Проверка email
        if (empty($_POST['email'])) {
            throw new RegistrationException('E-mail обязателен');
        } else {
            $email = test_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new RegistrationException('Неверный формат email');
            }
        }

        // Проверка пароля
        if (empty($_POST['password'])) {
            throw new RegistrationException('Пароль обязателен');
        } else {
            $password = test_input($_POST['password']);
            if (strlen($password) < 6) {
                throw new RegistrationException('Пароль слишком короткий');
            }
        }
        // Если все проверки прошли успешно
        echo "Регистрация прошла успешно!";

    } catch (RegistrationException $e) {
        // Обработка исключений
        echo "Ошибка: {$e->getMessage()}<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
</head>
<body>
    <h2>Форма регистрации</h2>
    <form method="POST" action="">
        <label for="name">Имя:</label><br>
        <input type="text" name="name" value="<?= $name ?>"><br>
        <span><?= $nameErr ?></span><br><br>

        <label for="email">E-mail:</label><br>
        <input type="text" name="email" value="<?= $email ?>"><br>
        <span><?= $emailErr ?></span><br><br>

        <label for="password">Пароль:</label><br>
        <input type="password" name="password"><br>
        <span><?= $passwordErr ?></span><br><br>

        <input type="submit" value="Зарегистрироваться">
    </form>
</body>
</html>