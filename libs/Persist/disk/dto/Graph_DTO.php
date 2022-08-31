<?php

/*
 * Обьект передачи данных для модуля Disk, которые содержат в себе исторические данные всех дисков
 */

class Graph_DTO {

    private $data;

    /**
     * Создание обьекта передачи
     * @param string  $date  -  дата данных раздела диска
     * @param integer $used  -  обьем данного раздела на указанную дату,в Мб 
     * @param integer $total -  обьем данного раздела на указанную дату,в Мб 
     */
    public function __construct() {
        $this->data = array();
    }

    /**
     * Добавить данные о диске
     * @param string $disk_name          имя диска
     * @param Graph_Disk_DTO $disk_data  данные о диске
     */
    public function addDiskData($disk_name, $disk_data) {
        $this->data[$disk_name][] = $disk_data;             
    }

    /**
     * Получить данные по диску
     * @param string $disk_name       имя диска
     * @return array(Graph_Disk_DTO)  данные диска
     */
    public function getDiskData($disk_name) {
        return $this->data[$disk_name];
    }

    public function getDiskNames() {
        return array_keys($this->data);
    }

}

/**
 * Обьект передачи данных для одного диска, который содержит в себе исторические данные диска
 * @property string  $date  -  дата данных раздела диска
 * @property integer $used  -  обьем данного раздела на указанную дату,в Мб 
 * @property integer $total -  обьем данного раздела на указанную дату,в Мб 
 */
class Graph_Disk_DTO {

    public $date;
    public $used;
    public $total;

    /**
     * Создание обьекта передачи
     * @param string  $date  -  дата данных раздела диска
     * @param integer $used  -  обьем данного раздела на указанную дату,в Мб 
     * @param integer $total -  обьем данного раздела на указанную дату,в Мб 
     */
    public function __construct($date, $used, $total) {
        $this->date = $date;
        $this->used = $used;
        $this->total = $total;
    }

}
