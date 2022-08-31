<?php

/*
 * Единый интерфейс для работы с данными модуля Load_average
 */

interface LA_DAO_Interface {

    /**
     * Сохранить данные
     * @param LA_DTO $data - данные
     */
    public function insertData(LA_DTO $data);

    
    
    /**
     * Получить данные для графика
     * @result Graph данные
     */
    public function getDataGraph();
}


