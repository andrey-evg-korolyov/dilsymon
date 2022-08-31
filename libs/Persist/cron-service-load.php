<?php

// Сервисный скрипт, предназначенный для вызова из крона операционной системы.
//
// Пример вызова: "/usr/bin/php /var/www/ezmon/libs/Persist/cron-service-load.php load_average"
// Входные параметры:
// $argv[1] - имя функции для выполнения, обязательный.
// Задаётся в hs сктрипте аргументом командной строки,
// например: "php cron-service-load.php load_average"
//

echo PHP_EOL . date('d-m-y h:i:s') . ' Start...';
switch ($argv[1]) {
    case 'load_average':storeLoad();
        break;
    default :echo 'unknown service "' . $argv[1] . '"';
        exit;
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

        foreach ($load_res AS $load) {
            if (mb_substr($load['mount'], 0, 1) !== "/")
                continue;

            $min_1 = $load['min_1'];
            $min_5 = $load['min_5'];
            $min_15 = $load['min_15'];

            $data = new LA_DTO($min_1, $min_5, $min_15);
            $result = LA_DAO_Factory::getFactory()->getDbDao()->insertData($data);
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


