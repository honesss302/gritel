<?php
// Подключение к БД
$mysql = new mysqli('localhost', 'root', 'root', 'login-bd');
if ($mysql->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysql->connect_error);
}

// Получение данных из формы
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Проверка заполненности полей
if (empty($username) || empty($password)) {
    header("Location: login.html");
    exit();
}

// Поиск пользователя по логину
$stmt = $mysql->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Пользователь не найден
    header("Location: login.html");
    exit();
}

$user = $result->fetch_assoc();

// Проверка пароля
if ($user['password'] === $password) {
    // Авторизация успешна — установка куки на 1 день
    setcookie('user_id', $user['id'], time() + 86400, '/');
    setcookie('user_login', $user['username'], time() + 86400, '/');

    // Перенаправление на главную
    header("Location: index.html");
    exit();
} else {
    // Неверный пароль
    header("Location: login.html");
    exit();
}

// Закрытие соединения
$mysql->close();
?>
