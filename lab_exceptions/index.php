<?php

require_once __DIR__ . '/exceptions/CustomException.php';
require_once __DIR__ . '/handlers/ExceptionHandler.php';

try {
    throw new CustomException('Тестовое исключение');
} catch (Throwable $e) {
    ExceptionHandler::handle($e);
} finally {
    print('Выполнение завершено');
}