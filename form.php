<?php
// Декодируем ошибки и данные из Cookies
$errors = isset($_COOKIE['form_errors']) ? json_decode($_COOKIE['form_errors'], true) : [];
$formData = isset($_COOKIE['form_data']) ? json_decode($_COOKIE['form_data'], true) : [];

// Удаляем Cookies с ошибками после использования
setcookie('form_errors', '', time() - 3600, '/');
setcookie('form_data', '', time() - 3600, '/');

// Подставляем долгосрочные данные из Cookies
foreach ($_COOKIE as $field => $value) {
    if (!isset($formData[$field]) && in_array($field, ['name', 'email', 'phone'])) {
        $formData[$field] = htmlspecialchars($value);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Форма</title>
    <style>
        .error { color: red; }
        .error-field { border: 1px solid red; }
    </style>
</head>
<body>
    <?php foreach ($errors as $error): ?>
        <div class="error"><?= $error ?></div>
    <?php endforeach; ?>

    <form method="post" action="submit.php">
        <label>Имя:
            <input type="text" name="name" value="<?= $formData['name'] ?? '' ?>" class="<?= isset($errors['name']) ? 'error-field' : '' ?>">
        </label><br>

        <label>Email:
            <input type="email" name="email" value="<?= $formData['email'] ?? '' ?>" class="<?= isset($errors['email']) ? 'error-field' : '' ?>">
        </label><br>

        <label>Телефон:
            <input type="text" name="phone" value="<?= $formData['phone'] ?? '' ?>" class="<?= isset($errors['phone']) ? 'error-field' : '' ?>">
        </label><br>

        <button type="submit">Отправить</button>
    </form>
</body>
</html>