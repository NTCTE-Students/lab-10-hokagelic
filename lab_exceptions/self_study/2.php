<?php
class FileReadException extends Exception {}

function readFileContents($filename) {
    if (!file_exists($filename)) {
        throw new FileReadException("Файл не найден: $filename");
    }
    return file_get_contents($filename);
}

try {
    $content = readFileContents("example.txt");
    echo $content;
} catch (FileReadException $e) {
    echo "Ошибка: " . $e->getMessage();
} finally {
    echo "\nОперация завершена.";
}
?>

<?php
function test_input($data) {
    return trim(stripslashes(htmlspecialchars($data)));
}

$name = $email = $website = "";
$nameErr = $emailErr = $websiteErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name'])) {
        $nameErr = 'Имя обязательно';
    } else {
        $name = test_input($_POST['name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = 'Только буквы и пробелы разрешены';
        }
    }

    if (empty($_POST['email'])) {
        $emailErr = 'E-mail обязателен';
    } else {
        $email = test_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = 'Неверный формат email';
        }
    }

    if (empty($_POST['website'])) {
        $website = '';
    } else {
        $website = test_input($_POST['website']);
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/=%~_|!:,.;]*[-a-z0-9+&@#\/=%~_|]/i", $website)) {
            $websiteErr = 'Неверный URL';
        }
    }
}