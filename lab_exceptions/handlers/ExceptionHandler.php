<?php

class ExceptionHandler {
    public static function handle(Throwable $exception) {
        print("Произошла ошибка: {$exception -> getMessage()}<br>");
        print("Файл: {$exception -> getFile()}<br>");
        print("Строка: {$exception -> getLine()}<br>");
    }
}