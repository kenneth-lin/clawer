<?php

if(isset($_REQUEST['params']) && isset($_REQUEST['bat_list'])){
    $main_params = $_REQUEST['params'];
    $bat_list = $_REQUEST['bat_list'];

    $file_name = "./run_bat/newfile_".date('Y_m_d_H_i_s', time()).".php";
    $myfile = fopen($file_name, "w+");

    $string = file_get_contents('./template/bat_template.html');
    $string = str_replace('{0}',$main_params,$string);
    $string = str_replace('{1}',$bat_list,$string);

    fwrite($myfile, $string);
    fclose($myfile);
    
    echo "You could run bat :<br/>";
    echo "# php ".$file_name;

}else{
    EXT_Template::add_header('./template/bat.html');
}



?>