<?php

/*
 * Фабрика для получения обьекта DAO для модуля Disk
 */

class Disk_DAO_Factory {

    private static $_instance;

    public function __construct() {
        
    }

    /**
     * Получить обьект фабрики модуля Disk
     * @return Disk_DAO_Factory - обьект фабрики
     */
    public static function getFactory() {
        if (!self::$_instance) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Получить DAO модуля Disk
     * @return Disk_DAO_Interface - интерфейс DAO
     */
    public function getDbDao() {
        return new Disk_DAO_DB();
    }

    public function getFileDao() {
        return new Disk_DAO_File;
    }

}
