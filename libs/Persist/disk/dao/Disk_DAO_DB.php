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

        $Config = new Config();
        //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);       
        $this->mysqli = new mysqli($Config->get('db:address'), $Config->get('db:user'), $Config->get('db:password'), $Config->get('db:db_name'));
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

    /**
     * Получить данные дисков для графика
     * @return  nixed данные для графика по дискам, формата array( 'disk_name'=>array(Graph_DTO))
     */
    public function getGraphData() {
        
        $test_data = new Graph_DTO();
        $Config = new Config();              
        
        $res = $this->mysqli->query("SELECT filesystem, created, used, total FROM disk ORDER BY id DESC LIMIT ".$Config->get('db:x_period_disk')."");
        while ($row = mysqli_fetch_assoc($res)) {
            $test_data->addDiskData($row['filesystem'], new Graph_Disk_DTO($row['created'], $row['used'], $row['total']));
        }

        return $test_data;
    }

}
