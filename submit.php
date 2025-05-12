<?php
$errors = [];
$formData = [];

// Регулярные выражения для валидации
$patterns = [
    'name' => '/^[a-zA-Zа-яА-Я\s]+$/u',
    'email' => '/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
    'phone' => '/^\+?\d{1,3}[- ]?\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/'
];

// Проверка каждого поля
foreach (['name', 'email', 'phone'] as $field) {
    $value = trim($_POST[$field] ?? '');
    if (empty($value)) {
        $errors[$field] = "Поле '$field' обязательно для заполнения";
    } elseif (!preg_match($patterns[$field], $value)) {
        $errorsMessages = [
            'name' => 'Допустимы только буквы и пробелы',
            'email' => 'Неверный формат email',
            'phone' => 'Неверный формат телефона'
        ];
        $errors[$field] = $errorsMessages[$field];
    }
    $formData[$field] = htmlspecialchars($value);
}

// Если есть ошибки
if (!empty($errors)) {
    setcookie('form_errors', json_encode($errors), 0, '/');
    setcookie('form_data', json_encode($formData), 0, '/');
    header('Location: form.php');
    exit;
}

// Успешная валидация
foreach ($formData as $field => $value) {
    setcookie($field, $value, time() + 365 * 24 * 3600, '/');
}

// Сохранение в БД (заглушка)
// ...

header('Location: success.php');
exit;