// Подключение к базе данных
import mysql from 'mysql';

const connection = mysql.createConnection({
  host: "VH306.spaceweb.ru",
  user: "mukhinnnik",
  password: "opd0PDopd",
  database: "mukhinnnik_pvk"
});

// Загрузка данных из CSV
const loadData = () => {
  connection.query('SELECT * FROM `pvk`', (err, results) => {
    if (err) throw err;

    const table = document.getElementById('table-container');
    table.innerHTML = '';

    const headerRow = document.createElement('tr');
    headerRow.innerHTML = '<th>ID</th><th>Название</th><th>Редактировать</th>';
    table.appendChild(headerRow);

    for (const row of results) {
      const rowElement = document.createElement('tr');
      rowElement.innerHTML = `<td>${row.id}</td><td>${row.название}</td><td><a href="edit.php?id=${row.id}">Редактировать</a></td>`;
      table.appendChild(rowElement);
    }
  });
};

// Добавление новой записи
const addForm = document.getElementById('add-form');

addForm.addEventListener('submit', (event) => {
  event.preventDefault();

  const title = event.target.elements.title.value;

  // Отправка AJAX-запроса
  fetch('add.php', {
    method: 'POST',
    body: JSON.stringify({ title })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Обновление таблицы
      loadData();
    } else {
      // Отображение ошибки
      alert(data.error);
    }
  });
});

// Запуск загрузки данных
loadData();
