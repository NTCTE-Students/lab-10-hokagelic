<?php

// 1. Создание базового исключения ShopException
class ShopException extends Exception {
    public function __construct($message = "Ошибка магазина", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

// 2. Создание исключения InsufficientFundsException для недостаточно средств
class InsufficientFundsException extends ShopException {
    public function __construct($message = "Недостаточно средств на счету", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

// 3. Создание исключения OutOfStockException для отсутствия товара
class OutOfStockException extends ShopException {
    public function __construct($message = "Товар отсутствует на складе", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

// Функция для выполнения покупки
function makePurchase($balance, $price, $stock) {
    try {
        // Проверка на наличие средств
        if ($balance < $price) {
            throw new InsufficientFundsException();
        }

        // Проверка наличия товара
        if ($stock <= 0) {
            throw new OutOfStockException();
        }

        // Если все проверки пройдены, совершаем покупку
        echo "Покупка успешно завершена!";
    } catch (InsufficientFundsException $e) {
        echo "Ошибка: " . $e->getMessage() . "<br>";
    } catch (OutOfStockException $e) {
        echo "Ошибка: " . $e->getMessage() . "<br>";
    } catch (ShopException $e) {
        echo "Ошибка магазина: " . $e->getMessage() . "<br>";
    }
}

// Пример использования
$balance = 50;   // Баланс пользователя
$price = 100;    // Цена товара
$stock = 0;      // Количество товара на складе

// Пытаемся выполнить покупку
makePurchase($balance, $price, $stock);
