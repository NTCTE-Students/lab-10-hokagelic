<?php

// Класс для обработки исключений и логирования ошибок
class ExceptionHandler {
    // Метод для обработки исключений
    public static function handle(Throwable $exception) {
        // Печать сообщения об ошибке на экран
        print("Произошла ошибка: {$exception->getMessage()}<br>");
        print("Файл: {$exception->getFile()}<br>");
        print("Строка: {$exception->getLine()}<br>");
        
        // Запись сообщения об ошибке в лог файл
        self::logError($exception);
    }

    // Метод для логирования ошибок в файл error.log
    private static function logError(Throwable $exception) {
        // Формируем строку с информацией об ошибке
        $logMessage = date('Y-m-d H:i:s') . " - Ошибка: {$exception->getMessage()} | Файл: {$exception->getFile()} | Строка: {$exception->getLine()}\n";
        
        // Записываем информацию в файл error.log
        file_put_contents(__DIR__ . '/error.log', $logMessage, FILE_APPEND);
    }
}

// Функция для очистки входных данных
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Инициализация переменных для данных и ошибок
$name = $email = $website = '';
$nameErr = $emailErr = $websiteErr = '';

// Проверка данных при отправке формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Проверка имени
        if (empty($_POST['name'])) {
            throw new Exception('Имя обязательно');
        } else {
            $name = test_input($_POST['name']);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                throw new Exception('Только буквы и пробелы разрешены в имени');
            }
        }

        // Проверка email
        if (empty($_POST['email'])) {
            throw new Exception('E-mail обязателен');
        } else {
            $email = test_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Неверный формат email');
            }
        }

        // Проверка URL
        if (empty($_POST['website'])) {
            $website = '';
        } else {
            $website = test_input($_POST['website']);
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
                throw new Exception('Неверный URL');
            }
        }

        // Если ошибок нет, выводим сообщение об успешной валидации
        echo "Данные успешно отправлены!";
        
    } catch (Exception $e) {
        // Обработка ошибки с записью в лог
        ExceptionHandler::handle($e);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Форма проверки</title>
</head>
<body>
    <h2>Проверка</h2>
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