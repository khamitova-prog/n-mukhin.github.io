<?php

// Подключение к базе данных
$mysqli = mysqli_connect("VH306.spaceweb.ru", "mukhinnnik", "opd0PDopd", "mukhinnnik_pvk");

// Проверка подключения
if (!$mysqli) {
  echo json_encode([
    'success' => false,
    'error' => 'Ошибка подключения к базе данных'
  ]);
  exit;
}

// Получение данных из JSON-запроса
$data = json_decode(file_get_contents('php://input'), true);

// Добавление новой записи
$sql = "INSERT INTO `pvk` (`название`) VALUES (?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $data['title']);
$stmt->execute();
$stmt->close();

// Ответ с результатом
echo json_encode([
  'success' => true
]);

?>
