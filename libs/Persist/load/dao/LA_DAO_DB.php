<?php

/**
 * Реализация DAO для работы с данными модуля Load_average через DB 
 */
class LA_DAO_DB implements LA_DAO_Interface {

    private $mysqli;

    /**
     * Конструктор DAO модуля Load_average для хранения в СУБД
     */
    public function __construct() {

        $Config = new Config();
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);       
        $this->mysqli = new mysqli($Config->get('db:address'), $Config->get('db:user'), $Config->get('db:password'), $Config->get('db:db_name'));
    }

    /**
     * Сохранить данные
     * @param LA_DTO $data - данные формата array()
     */
    public function insertData(LA_DTO $data) {
        $result = $this->mysqli->query("INSERT INTO load_average (min_1,min_5,min_15) VALUES (" .(int) $data->min_1 . ", " . (int) $data->min_5 . ", " . (int) $data->min_15 . ")");
        return $result;
    }

    /**
     * Получить данные ЦП для графика
     * @return  nixed данные для графика 
     */
    public function getDataGraph() {
        
       $test_data = new Graph();
       
//       $test_data->addLoadData(new Graph_LA_DTO('24/08/2022 12:00:00', 15, 25, 35));
//       $test_data->addLoadData(new Graph_LA_DTO('25/08/2022 12:00:00', 17, 27, 37));
       
       $res = $this->mysqli->query("SELECT created, min_1, min_5, min_15 FROM load_average");
        while ($row = mysqli_fetch_assoc($res)) {
            $test_data->addLoadData(new Graph_LA_DTO($row['created'], $row['min_1'], $row['min_5'], $row['min_15']));
        }
         
       return $test_data;
    }

}


