<?php

//require '../autoload.php';
require __DIR__.'/../autoload.php';

$Config = new Config();

if (!($load_tmp = shell_exec('cat /proc/loadavg | awk \'{print $1","$2","$3}\''))) {
    $load = array(0, 0, 0);
}
else {
    // Number of cores
    $cores = Misc::getCpuCoresNumber();

    $load_exp = explode(',', $load_tmp);

    $load = array_map(
        function ($value, $cores) {
            $v = (int) ((float) $value * 100 / $cores);
            if ($v > 100) {
                $v = 100;
            }
            return $v;
        },
        $load_exp,
            array_fill(0, 3, $cores)
    );
               
          $min_1 =  $load[0]; 
          $min_5 =  $load[1];
          $min_15 =  $load[2];       

    //Тестовое сохранение в БД
//    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//    $mysqli = new mysqli($Config->get('db:address'), $Config->get('db:user'), $Config->get('db:password'), $Config->get('db:db_name'));
//    $result = $mysqli->query("INSERT INTO load_average (min_1, min_5, min_15) VALUES ('$min_1','$min_5',$min_15)");
    
    include_once __DIR__.'/Persist/load/LA_DAO_Factory.php';
    include_once __DIR__.'/Persist/load/dao/LA_DAO_Interface.php';
    include_once __DIR__.'/Persist/load/dao/LA_DAO_DB.php';
    include_once __DIR__.'/Persist/load/dto/LA_DTO.php';
    include_once __DIR__.'/Persist/load/dto/Graph.php';
    
    error_reporting(E_ALL & ~E_NOTICE);
    $factory = LA_DAO_Factory::getFactory();
    $dao = $factory->getDbDao();
 //сохраняет данные о загрузке ЦП в БД при каждом обновление окна в браузере  
    //$data = new LA_DTO($min_1, $min_5, $min_15);      
   // $dao->insertData($data);
        
    $data = $dao->getDataGraph();
    $json_data = array();
    
    foreach ($data->getLoadData() AS $load_data){
         $json_data[$load_data->date] = array ('min_1'=>$load_data->min_1,
                                               'min_5'=>$load_data->min_5,
                                               'min_15'=>$load_data->min_15);
                             
    }
    
    $datas[0]['graph_data']= $json_data;
    
}


//$datas = $load;

echo json_encode($datas);
