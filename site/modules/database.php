<?php

class Database {
    private $connection;

    // Конструктор класса для открытия соединения с базой данных
    public function __construct($path) {
        try {
            $this->connection = new PDO("sqlite:$path");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Ошибка подключения к базе данных: " . $e->getMessage();
            exit;
        }
    }

    // Выполнение SQL запроса без возврата результатов
    public function Execute($sql) {
        try {
            $this->connection->exec($sql);
        } catch (PDOException $e) {
            echo "Ошибка выполнения SQL: " . $e->getMessage();
        }
    }

    // Выполнение SQL запроса с возвратом данных
    public function Fetch($sql) {
        try {
            $stmt = $this->connection->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Ошибка извлечения данных: " . $e->getMessage();
            return [];
        }
    }

    // Создание новой записи в таблице
    public function Create($table, $data) {
        $keys = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function ($val) { return "'$val'"; }, array_values($data)));

        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $this->Execute($sql);
        return $this->connection->lastInsertId();
    }

    // Чтение записи по ID
    public function Read($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = $id";
        $result = $this->Fetch($sql);
        return $result ? $result[0] : null;
    }

    // Обновление записи по ID
    public function Update($table, $id, $data) {
        $set = implode(', ', array_map(function ($key, $value) { return "$key = '$value'"; }, array_keys($data), array_values($data)));

        $sql = "UPDATE $table SET $set WHERE id = $id";
        $this->Execute($sql);
    }

    // Удаление записи по ID
    public function Delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = $id";
        $this->Execute($sql);
    }

    // Подсчёт количества записей в таблице
    public function Count($table) {
        $sql = "SELECT COUNT(*) AS count FROM $table";
        $result = $this->Fetch($sql);
        return $result ? $result[0]['count'] : 0;
    }

    // Деструктор класса для закрытия соединения с базой данных
    public function __destruct() {
        $this->connection = null;
    }
}
