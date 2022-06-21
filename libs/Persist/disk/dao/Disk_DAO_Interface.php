<?php

/*
 * Единый интерфейс для работы с данными модуля Disk
 */

interface Disk_DAO_Interface {

    /**
     * Сохранить данные
     * @param Disk_DTO $data - данные
     */
    public function insertData(Disk_DTO $data);

    /**
     * Найти данные
     * @param type $id - идентификатор искомой записи
     */
    public function findData($id);
}
