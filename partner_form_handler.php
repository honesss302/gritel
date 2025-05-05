<?php
$mysql = new mysqli('localhost', 'root', 'root', 'login-bd');
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

// Получение данных из формы
$company = $_POST['company'] ?? '';
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$partner_type = $_POST['partner-type'] ?? '';
$fleet = $_POST['fleet'] ?? '';
$experience = $_POST['experience'] ?? 0;
$volume = $_POST['volume'] ?? '';
$message = $_POST['message'] ?? '';
$agreement = isset($_POST['agreement']) ? 1 : 0;

// Валидация обязательных полей
if (!$company || !$name || !$phone || !$email || !$partner_type || !$experience || !$agreement) {
    die("Заполните все обязательные поля.");
}

// Подготовка SQL-запроса
$stmt = $mysql->prepare("
    INSERT INTO partner_requests 
    (company, name, phone, email, partner_type, fleet, experience, volume, message, agreement)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
    "ssssssissi",
    $company, $name, $phone, $email,
    $partner_type, $fleet, $experience,
    $volume, $message, $agreement
);

if ($stmt->execute()) {
    echo "Заявка успешно отправлена!";
} else {
    echo "Ошибка при отправке заявки: " . $stmt->error;
}

$stmt->close();
$mysql->close();
?>
