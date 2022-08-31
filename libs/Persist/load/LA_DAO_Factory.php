<?php

/*
 * Фабрика для получения обьекта DAO для модуля Load_average
 */

class LA_DAO_Factory {

    private static $_instance;

    public function __construct() {
        
    }

    /**
     * Получить обьект фабрики модуля Load_average
     * @return LA_DAO_Factory - обьект фабрики
     */
    public static function getFactory() {
        if (!self::$_instance) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Получить DAO модуля Load_average
     * @return LA_DAO_Interface - интерфейс DAO
     */
    public function getDbDao() {
        return new LA_DAO_DB();
    }

    public function getFileDao() {
        return new LA_DAO_File;
    }

}


