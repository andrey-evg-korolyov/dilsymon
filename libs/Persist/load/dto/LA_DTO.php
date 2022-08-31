<?php

/**
 * Обьект передачи данных для модуля Load_average
 * @property integer $min_1 - загрузка ЦП в процентах 1 минута.
 * @property integer $min_5 - загрузка ЦП в процентах 5 минут.
 * @property integer $min_15 - загрузка ЦП в процентах 15 минут.
 */
class LA_DTO {

    public $min_1;
    public $min_5;
    public $min_15;

    /**
     * Создание обьекта передачи
     * @param integer $min_1 - загрузка ЦП в процентах 1 минута. 
     * @param integer $min_5 - загрузка ЦП в процентах 5 минут.
     * @param integer $min_15 - загрузка ЦП в процентах 15 минут.
     */
    public function __construct($min_1,$min_5,$min_15) {
        $this->min_1 = $min_1;
        $this->min_5 = $min_5;
        $this->min_15 = $min_15;
    }

}


