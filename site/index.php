<?php

require_once __DIR__ . '/modules/database.php';
require_once __DIR__ . '/modules/page.php';
require_once __DIR__ . '/config.php';

$db = new Database($config["db"]["path"]);
$page = new Page(__DIR__ . '/templates/index.tpl');

// Получаем идентификатор страницы из параметров запроса и проверяем его наличие
$pageId = isset($_GET['page']) ? intval($_GET['page']) : 1; // Устанавливаем значение по умолчанию, если 'page' не задан

// Используем метод Read для безопасного извлечения данных страницы
$data = $db->Read("page", $pageId);

// Проверяем, что данные были успешно получены
if ($data) {
    echo $page->Render($data);
} else {
    echo "Запрошенная страница не найдена."; // Обработка случая, когда данные не найдены
}
