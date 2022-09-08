<?php

// Сервисный скрипт, предназначенный для вызова из крона операционной системы.
//
// Пример вызова: "/usr/bin/php /var/www/ezmon/libs/Persist/cron-service.php disk"
// Входные параметры:
// $argv[1] - имя функции для выполнения, обязательный.
// Задаётся в hs скрипте аргументом командной строки,
// например: "php cron-service.php disk"
//

echo PHP_EOL . date('d-m-y h:i:s') . ' Start...';
switch ($argv[1]) {
    case 'disk':storeDisk();
        break;
    case 'load_average':storeLoad();
        break;
    default :echo 'unknown service "' . $argv[1] . '"';
        exit;
}

function storeDisk() {
    include_once __DIR__ . '/disk/Disk_DAO_Factory.php';
    include_once __DIR__ . '/disk/dao/Disk_DAO_Interface.php';
    include_once __DIR__ . '/disk/dao/Disk_DAO_DB.php';
    include_once __DIR__ . '/disk/dto/Disk_DTO.php';

    echo " disk...";

    $error = "";
    $result = array();
    try {
        ob_start();
        include_once __DIR__ .'/../disk.php';
        $disk_res = json_decode(ob_get_clean(), true);

        error_reporting(E_ALL & ~E_NOTICE);

        foreach ($disk_res AS $disk) {
            if (mb_substr($disk['mount'], 0, 1) !== "/")
                continue;

            $filesystem = $disk['filesystem'];
            $used = str_to_mbytes($disk['used']);
            $total = str_to_mbytes($disk['total']);

            $data = new Disk_DTO($filesystem, $used, $total);
            $result[$filesystem] = Disk_DAO_Factory::getFactory()->getDbDao()->InsertData($data);
        }
    } catch (Exception $ex) {
        $error = $ex->getMessage();
    }

    if ($error) {
        echo 'ERROR: ' . $error . PHP_EOL;
    }
    else {
        echo 'Done successfulli. Result: ' . str_replace(PHP_EOL, "", print_r($result, true)) . PHP_EOL;
    }
    exit();
}

function str_to_mbytes($str) {
    $result = (float) filter_var($str, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $gb = strpos($str, "GB") === false ? 1 : 1024;
    return round($result * $gb);
}

function storeLoad() {
    include_once __DIR__ . '/load/LA_DAO_Factory.php';
    include_once __DIR__ . '/load/dao/LA_DAO_Interface.php';
    include_once __DIR__ . '/load/dao/LA_DAO_DB.php';
    include_once __DIR__ . '/load/dto/LA_DTO.php';

    echo " load_average...";

    $error = "";
    $result = array();
    try {
        ob_start();
        include_once __DIR__ .'/../load_average.php';
        $load_res = json_decode(ob_get_clean(), true);

        error_reporting(E_ALL & ~E_NOTICE);

        $min_1 = $load[0];
        $min_5 = $load[1];
        $min_15 = $load[2];

        $data = new LA_DTO($min_1, $min_5, $min_15);
        $result = LA_DAO_Factory::getFactory()->getDbDao()->insertData($data);
        
    } catch (Exception $ex) {
        $error = $ex->getMessage();
    }

    if ($error) {
        echo 'ERROR: ' . $error . PHP_EOL;
    }
    else {
        echo 'Done successfulli. Result: ' . str_replace(PHP_EOL, "", print_r($result, true)) . PHP_EOL;
    }
    exit();
}

