<?php

/**
 * Реализация DAO для работы с данными модуля Disk через DB 
 */
class Disk_DAO_DB implements Disk_DAO_Interface {

    private $mysqli;

    /**
     * Конструктор DAO модуля Disk для хранения в СУБД
     */
    public function __construct() {
        //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->mysqli = new mysqli('localhost', 'andrey', 'andrey1984k13', 'ezmon');
    }

    /**
     * Сохранить данные
     * @param Disk_DTO $data - данные формата array()
     */
    public function InsertData(Disk_DTO $data) {
        $result = $this->mysqli->query("INSERT INTO disk (filesystem, used, total) VALUES ('$data->filesystem', " . (int) $data->used . ", " . (int) $data->total . ")");
        return $result;
    }

    /**
     * Найти данные
     * @param type $id - идентификатор искомой записи
     */
    public function findData($id) {
        
    }

}
