<?php

// Подключение к базе данных
$mysqli = mysqli_connect("VH306.spaceweb.ru", "mukhinnnik", "opd0PDopd", "mukhinnnik_pvk");

// Проверка подключения
if (!$mysqli) {
    echo "Ошибка подключения к базе данных: " . mysqli_connect_error();
    exit;
}

// Заполнение базы данных из CSV
$file = fopen("pvk.csv", "r");

// Чтение первой строки (заголовка)
$header = fgetcsv($file);

// Итерация по строкам CSV
while (($row = fgetcsv($file)) !== FALSE) {

    // Формирование запроса INSERT
    $sql = "INSERT INTO `pvk` (`название`) VALUES (?)";

    // Подготовка запроса
    $stmt = $mysqli->prepare($sql);

    // Привязка значения к параметру запроса
    $stmt->bind_param("s", $row[0]);

    // Выполнение запроса
    $stmt->execute();

    // Закрытие запроса
    $stmt->close();
}

// Закрытие файла CSV
fclose($file);

// Вывод содержимого базы данных
$sql = "SELECT * FROM `pvk`";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Название</th><th>Редактировать</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['название']}</td><td><a href='edit.php?id={$row['id']}'>Редактировать</a></td></tr>";
    }
    echo "</table>";
} else {
    echo "В базе данных нет записей.";
}

?>

