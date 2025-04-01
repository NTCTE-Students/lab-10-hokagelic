<?php

// Определяем кастомные исключения
class InvalidNameException extends Exception {}
class InvalidEmailException extends Exception {}
class InvalidUrlException extends Exception {}

// Функции валидации для имени, email и URL
function validateName($name) {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        throw new InvalidNameException('Только буквы и пробелы разрешены');
    }
}

function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidEmailException('Неверный формат email');
    }
}

function validateUrl($website) {
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
        throw new InvalidUrlException('Неверный URL');
    }
}

// Инициализация переменных для формы
$name = $email = $website = '';
$nameErr = $emailErr = $websiteErr = '';

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Проверка имени
        if (empty($_POST['name'])) {
            $nameErr = 'Имя обязательно';
        } else {
            $name = $_POST['name'];
            validateName($name);
        }

        // Проверка email
        if (empty($_POST['email'])) {
            $emailErr = 'E-mail обязателен';
        } else {
            $email = $_POST['email'];
            validateEmail($email);
        }

        // Проверка URL
        if (!empty($_POST['website'])) {
            $website = $_POST['website'];
            validateUrl($website);
        }

    } catch (InvalidNameException | InvalidEmailException | InvalidUrlException $e) {
        // Обработка различных исключений в одном блоке catch
        echo "Ошибка: {$e->getMessage()}<br>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Форма проверки</title>
</head>
<body>
    <h2>мяу</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Имя: <input type="text" name="name" value="<?php echo $name; ?>">
        <span><?php echo $nameErr; ?></span>
        <br><br>
        E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
        <span><?php echo $emailErr; ?></span>
        <br><br>
        Сайт: <input type="text" name="website" value="<?php echo $website; ?>">
        <span><?php echo $websiteErr; ?></span>
        <br><br>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>