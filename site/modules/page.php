<?php

class Page {
    private $template;

    // Конструктор класса, принимает путь к шаблону страницы
    public function __construct($template) {
        $this->template = $template;
    }

    // Отображает страницу, подставляя в шаблон данные из ассоциативного массива $data
    public function Render($data) {
        // Проверяем, существует ли файл шаблона
        if (!file_exists($this->template)) {
            echo "Ошибка: файл шаблона не найден!";
            return;
        }

        // Извлекаем переменные из ассоциативного массива
        extract($data);

        // Включаем буферизацию вывода
        ob_start();
        
        // Подключаем файл шаблона
        include $this->template;

        // Получаем содержимое буфера и очищаем его
        $content = ob_get_clean();

        // Выводим содержимое
        echo $content;
    }
}
