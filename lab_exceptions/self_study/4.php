<?php

class DatabaseConnectionException extends Exception {
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

function connectToDatabase($dsn, $username, $password) {
    try {
        if (empty($dsn) || empty($username)) {
            throw new DatabaseConnectionException("Неверные учетные данные или DSN");
        }
        
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Подключение успешно";
    } catch (PDOException $e) {
        throw new DatabaseConnectionException("Ошибка подключения: " . $e->getMessage());
    }
}

try {
    // Симуляция ошибок подключения
    connectToDatabase('', 'root', ''); // Ошибка пустого DSN
} catch (DatabaseConnectionException $e) {
    echo "Произошла ошибка: " . $e->getMessage();
} finally {
    echo "\nВыполнение завершено";
}