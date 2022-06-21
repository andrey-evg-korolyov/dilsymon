<?php

/**
 * Обьект передачи данных для модуля Disk
 * @property string $filesystem - название раздела диска. Например "/boot/efi"
 * @property integer $used - текущий обьем данного раздела, в Мб
 * @property integer $total - полный обьем данного раздела, в Мб
 */
class Disk_DTO {

    public $filesystem;
    public $used;
    public $total;

    /**
     * Создание обьекта передачи
     * @param string $filesystem - название раздела диска. Например "/boot/efi"
     * @param integer $used - текущий обьем данного раздела, в Мб
     * @param integer $total - полный обьем данного раздела, в Мб
     */
    public function __construct($filesystem, $used, $total) {
        $this->filesystem = $filesystem;
        $this->used = $used;
        $this->total = $total;
    }

}
