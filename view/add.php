<?php


if(isset($_REQUEST['params'])){
    $main_params = $_REQUEST['params'];

    $data = Crawler_Data::clawer($main_params);
    MySQLClass::addClawerData($main_params,$data);
    EXT_Template::add_header('./template/go_to_index.html');
}else{
    echo 'You could add data to database.';
}



?>