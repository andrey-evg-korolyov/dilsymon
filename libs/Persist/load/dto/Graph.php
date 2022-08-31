<?php

/*
 * Обьект передачи данных для модуля load_average
 */

class Graph{
    
    private $data;
    
    public function __construct() {
        $this->data = array();
    }
    
    /**
     * Добавить данные
     * @param Graph_LA_DTO $load_data  данные загрузки ЦП
     */
    public function addLoadData($load_data) {
        $this->data[] = $load_data;             
    }
    
     /**
     * Получить данные загрузки ЦП
     * @return array(Graph_LA_DTO)  данные загрузки
     */
    public function getLoadData() {
        return $this->data;
    }
    
}

/**
 * Обьект передачи данных 
 * @property string  $date  -  дата данных
 * @property integer $min_1  - загрузка ЦП на указанную дату,в %
 * @property integer $min_5 -  загрузка ЦП на указанную дату,в %
 * @property integer $min_15 -  загрузка ЦП на указанную дату,в % 
 */

class Graph_LA_DTO {

    public $date;
    public $min_1;
    public $min_5;
    public $min_15;
    
    

    public function __construct($date, $min_1, $mni_5, $min_15) {
        $this->date   = $date;
        $this->min_1  = $min_1;
        $this->min_5  = $mni_5;
        $this->min_15 = $min_15;
    }

}
