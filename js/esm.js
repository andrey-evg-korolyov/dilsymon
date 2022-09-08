var esm = {};


esm.getSystem = function() {

    var module = 'system';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');

        esm.insertDatas($box, module, data);

        esm.reloadBlock_spin(module);

    }, 'json');

};


esm.getLoad_average = function() {

    var module = 'load_average';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content');

        esm.reconfigureGauge($('input#load-average_1', $box), data[0]);
        esm.reconfigureGauge($('input#load-average_5', $box), data[1]);
        esm.reconfigureGauge($('input#load-average_15', $box), data[2]);
        
            html = '';
          
            chart = [];           
            x_array = [];
            y_array = [];
            
        for(var load_data in data[3].graph_data){ 
                   
            html += '<table border="1">';              
            html += '<tr>';
            html += '<td>'+load_data+'</td>';
            html += '<td>'+data[3].graph_data[load_data].min_1+'</td>';
            html += '<td>'+data[3].graph_data[load_data].min_5+'</td>';
            html += '<td>'+data[3].graph_data[load_data].min_15+'</td>';
            html += '</tr>'; 
            html += '</table>';
        
            x_array.push(load_data);
            y_array.push(data[3].graph_data[load_data].min_1);
            line = [];
            line.x = x_array;
            line.y = y_array;
            line.name = load_data;
            chart.push(line);
          }       
            
                   
        $box.prepend(html);
                  
        esm.reloadBlock_spin(module);
        
        esm.draw_load_average_chart(chart);

    }, 'json')
       .fail(function(data){      
    $('.box#esm-'+module+' .box-content').html(data.responseText);
    });
    
    esm.draw_load_average_chart = function(chart){
        
    var labels;
    const colors = ['red', 'green', 'blue'];

    var datasets = [];
    for (var index in chart) {
        var dataset = {
            label: chart[index].name,
            backgroundColor: colors[index],
            borderColor: colors[index],
            data: chart[index].y
        };
        labels = chart[index].x;

        datasets.push(dataset);
    }
    var data = {labels: labels};
    data.datasets = datasets;

    const config = {
        type: 'line',
        data: data,
        options: {}
        };
        const myLoadChart = new Chart(
          document.getElementById('myLoadChart'),
          config
        );

    };

};

esm.getCpu = function() {

    var module = 'cpu';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');

        esm.insertDatas($box, module, data);

        esm.reloadBlock_spin(module);

    }, 'json');

};


esm.getMemory = function() {

    var module = 'memory';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');

        esm.insertDatas($box, module, data);

        esm.reloadBlock_spin(module);

        // Percent bar
        var $progress = $('.progressbar', $box);

        $progress
            .css('width', data.percent_used+'%')
            .html(data.percent_used+'%')
            .removeClass('green orange red');

        if (data.percent_used <= 50)
            $progress.addClass('green');
        else if (data.percent_used <= 75)
            $progress.addClass('orange');
        else
            $progress.addClass('red');

    }, 'json');

};


esm.getSwap = function() {

    var module = 'swap';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');

        esm.insertDatas($box, module, data);

        // Percent bar
        var $progress = $('.progressbar', $box);

        $progress
            .css('width', data.percent_used+'%')
            .html(data.percent_used+'%')
            .removeClass('green orange red');

        if (data.percent_used <= 50)
            $progress.addClass('green');
        else if (data.percent_used <= 75)
            $progress.addClass('orange');
        else
            $progress.addClass('red');
    
        esm.reloadBlock_spin(module);

    }, 'json');

};


esm.getDisk = function() {

    var module = 'disk';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');
        $box.empty();

        for (var line in data)
        {
            var bar_class = '';

            if (data[line].percent_used <= 50)
                bar_class = 'green';
            else if (data[line].percent_used <= 75)
                bar_class = 'orange';
            else
                bar_class = 'red';

            var html = '';
            html += '<tr>';

            if (typeof data[line].filesystem != 'undefined')
                html += '<td class="filesystem">'+data[line].filesystem+'</td>';

            html += '<td>'+data[line].mount+'</td>';
            html += '<td><div class="progressbar-wrap"><div class="progressbar '+bar_class+'" style="width: '+data[line].percent_used+'%;">'+data[line].percent_used+'%</div></div></td>';
            html += '<td class="t-center">'+data[line].free+'</td>';
            html += '<td class="t-center">'+data[line].used+'</td>';
            html += '<td class="t-center">'+data[line].total+'</td>';
            html += '</tr>';

            $box.append(html);
        }
        
      
        
        html = '';
        chart = [];
        for(var disk_name in data[0].graph_data){   //итерируем по именам дисков
            html += '<br>'+disk_name+':<table border="1">';
            x_array = [];
            y_array = [];
            for(var disk_date in data[0].graph_data[disk_name]){  //итерируем по датам в диске
              html += '<tr>';
              html += '<td>'+disk_date+'</td>';
              html += '<td>'+data[0].graph_data[disk_name][disk_date].used+'</td>';
              html += '<td>'+data[0].graph_data[disk_name][disk_date].total+'</td>';
              html += '</tr>';
              x_array.push(disk_date);
              //y_array.push(data[0].graph_data[disk_name][disk_date].used);
              y_array.push(data[0].graph_data[disk_name][disk_date].total - data[0].graph_data[disk_name][disk_date].used);
            }                        
            html += '</table>';
            line = [];
            line.x = x_array;
            line.y = y_array;
            line.name = disk_name;
            chart.push(line);
        }   
                          
       // $box.prepend(html);
        
        esm.reloadBlock_spin(module);
        esm.draw_disk_chart(chart);
            
    }, 'json')
 .fail(function(data) {
   // alert(ini_set('display_errors', true));
    $('.box#esm-'+module+' .box-content').html(data.responseText);
  });
   
    esm.draw_disk_chart = function(chart){
        var labels;
        const colors = ['red','green','blue'];
        
        var datasets = [];
        for (var index in chart) {
            var dataset = {
                label: chart[index].name,
                backgroundColor: colors[index],
                borderColor: colors[index],
                data: chart[index].y
            };
            labels = chart[index].x;

            datasets.push(dataset);
    }
        var data = {labels: labels};
        data.datasets = datasets;
                  
        const config = {
            type: 'line',
            data: data,
            options: {}
        };
            
        const myChart = new Chart(
              document.getElementById('myChart'),
              config
      );
    };   
   
};

esm.getLast_login = function() {

    var module = 'last_login';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');
        $box.empty();

        for (var line in data)
        {
            var html = '';
            html += '<tr>';
            html += '<td>'+data[line].user+'</td>';
            html += '<td class="w50p">'+data[line].date+'</td>';
            html += '</tr>';

            $box.append(html);
        }
    
        esm.reloadBlock_spin(module);

    }, 'json');

};


esm.getNetwork = function() {

    var module = 'network';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');
        $box.empty();

        for (var line in data)
        {
            var html = '';
            html += '<tr>';
            html += '<td>'+data[line].interface+'</td>';
            html += '<td>'+data[line].ip+'</td>';
            html += '<td class="t-center">'+data[line].receive+'</td>';
            html += '<td class="t-center">'+data[line].transmit+'</td>';
            html += '</tr>';

            $box.append(html);
        }

        esm.reloadBlock_spin(module);

    }, 'json');

};


esm.getPing = function() {

    var module = 'ping';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');
        $box.empty();

        for (var line in data)
        {
            var html = '';
            html += '<tr>';
            html += '<td>'+data[line].host+'</td>';
            html += '<td>'+data[line].ping+' ms</td>';
            html += '</tr>';

            $box.append(html);
        }
    
        esm.reloadBlock_spin(module);

    }, 'json');

};


esm.getServices = function() {

    var module = 'services';
    
    esm.reloadBlock_spin(module);

    $.get('libs/'+module+'.php', function(data) {

        var $box = $('.box#esm-'+module+' .box-content tbody');
        $box.empty();

        for (var line in data)
        {
            var label_color  = data[line].status == 1 ? 'success' : 'error';
            var label_status = data[line].status == 1 ? 'online' : 'offline';

            var html = '';
            html += '<tr>';
            html += '<td class="w15p"><span class="label '+label_color+'">'+label_status+'</span></td>';
            html += '<td>'+data[line].name+'</td>';
            html += '<td class="w15p">'+data[line].port+'</td>';
            html += '</tr>';

            $box.append(html);
        }
    
        esm.reloadBlock_spin(module);

    }, 'json');

};


esm.getAll = function() {
    esm.getSystem();
    esm.getCpu();
    esm.getLoad_average();
    esm.getMemory();
    esm.getSwap();
    esm.getDisk();
    esm.getLast_login();
    esm.getNetwork();
    esm.getPing();
    esm.getServices();
};

esm.reloadBlock = function(block) {

    esm.mapping[block]();

};

esm.reloadBlock_spin = function(block) {

    var $module = $('.box#esm-'+block);

    $('.reload', $module).toggleClass('spin disabled');
    $('.box-content', $module).toggleClass('faded');

};

esm.insertDatas = function($box, block, datas) {
    for (var item in datas)
    {
        $('#'+block+'-'+item, $box).html(datas[item]);
    }
};

esm.reconfigureGauge = function($gauge, newValue) {
    // Change colors according to the percentages
    var colors = { green : '#7BCE6C', orange : '#E3BB80', red : '#CF6B6B' };
    var color  = '';

    if (newValue <= 50)
        color = colors.green;
    else if (newValue <= 75)
        color = colors.orange;
    else
        color = colors.red;

    $gauge.trigger('configure', { 
        'fgColor': color,
        'inputColor': color,
        'fontWeight': 'normal',
        'format' : function (value) {
            return value + '%';
        }
    });

    // Change gauge value
    $gauge.val(newValue).trigger('change');
};


esm.mapping = {
    all: esm.getAll,
    system: esm.getSystem,
    load_average: esm.getLoad_average,
    cpu: esm.getCpu,
    memory: esm.getMemory,
    swap: esm.getSwap,
    disk: esm.getDisk,
    last_login: esm.getLast_login,
    network: esm.getNetwork,
    ping: esm.getPing,
    services: esm.getServices
};