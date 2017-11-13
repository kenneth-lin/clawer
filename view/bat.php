<?php

if(isset($_REQUEST['params']) && isset($_REQUEST['bat_list'])){
    $main_params = $_REQUEST['params'];
    $bat_list = $_REQUEST['bat_list'];

    $record = new InputDataRecord();
    $record->init($main_params);

    $file_name = "./run_bat/".$record->crawler_main_table."_".date('Y_m_d_H_i_s', time()).".php";
    $myfile = fopen($file_name, "w+");

    $string = file_get_contents('./template/bat_template.html');
    $string = str_replace('{0}',$main_params,$string);
    $string = str_replace('{1}',$bat_list,$string);

    fwrite($myfile, $string);
    fclose($myfile);
    
    echo '<div id="bat_warning">You could run bat :<br/>';
    echo '# <span id="run_it">php '.$file_name.'</span></div>';
    EXT_Template::add_header('./template/bat_run_it.html');

}else if(isset($_REQUEST['run_bat'])){
    system($_REQUEST['run_bat']);
}else{
    EXT_Template::add_header('./template/bat.html');
}



?>