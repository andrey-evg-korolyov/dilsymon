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

    /**
     * Получить данные дисков для графика
     * @return  nixed данные для графика по дискам, формата array( 'disk_name'=>array(Graph_DTO))
     */
    public function getGraphData() {
        $test_data = new Graph_DTO();
//        $test_data->addDiskData('disk1', new Graph_Disk_DTO('21/06/2022 13:35:40', 111, 222));
//        $test_data->addDiskData('disk1', new Graph_Disk_DTO('22/06/2022 13:35:40', 11111, 22222));
//        $test_data->addDiskData('disk2', new Graph_Disk_DTO('21/06/2022 13:35:40', 333, 444));
//        $test_data->addDiskData('disk2', new Graph_Disk_DTO('22/06/2022 13:35:40', 33333, 444444));

        $res = $this->mysqli->query("SELECT filesystem, created, used, total FROM disk");
        while ($row = mysqli_fetch_assoc($res)) {
            $test_data->addDiskData($row['filesystem'], new Graph_Disk_DTO($row['created'], $row['used'], $row['total']));
        }
        
        return test_data;
    }

}
