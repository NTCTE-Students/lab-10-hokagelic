<?php

class ValidationException extends Exception {
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new ValidationException('Неверный формат email');
    }
    return true;
}

// Пример использования
$email = "invalid-email@"; // Тестовый неверный email

try {
    validateEmail($email);
    echo "Email корректен.";
} catch (ValidationException $e) {
    echo "Ошибка: " . $e->getMessage();
}
