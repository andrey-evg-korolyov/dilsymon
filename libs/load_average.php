<?php

require __DIR__.'/../autoload.php';

$Config = new Config();

if (!($load_tmp = shell_exec('cat /proc/loadavg | awk \'{print $1","$2","$3}\''))) {
    $load = array(0, 0, 0);
    
} else {
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
    
    include_once __DIR__.'/Persist/load/LA_DAO_Factory.php';
    include_once __DIR__.'/Persist/load/dao/LA_DAO_Interface.php';
    include_once __DIR__.'/Persist/load/dao/LA_DAO_DB.php';
    include_once __DIR__.'/Persist/load/dto/LA_DTO.php';
    include_once __DIR__.'/Persist/load/dto/LA_Graph_DTO.php';
    
    error_reporting(E_ALL & ~E_NOTICE);
    $factory = LA_DAO_Factory::getFactory();
    $dao = $factory->getDbDao();
        
    $data = $dao->getDataGraph();
    $json_data = array();
    
    foreach ($data->getLoadData() AS $load_data){
         $json_data[$load_data->date] = array ('min_1'=>$load_data->min_1,
                                               'min_5'=>$load_data->min_5,
                                               'min_15'=>$load_data->min_15);
    }
   
    
    $datas = $load;
    
    $datas[3]['graph_data']= $json_data;
    
}

echo json_encode($datas);
